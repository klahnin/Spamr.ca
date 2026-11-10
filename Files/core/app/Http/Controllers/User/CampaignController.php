<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Events\MessageSend;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Device;
use App\Models\Group;
use App\Models\GroupContact;
use App\Models\Sms;
use App\Models\Template;
use App\Rules\FileTypeValidate;
use App\Services\CampaignDestinationPolicy;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CampaignController extends Controller
{

    public function index()
    {
        $pageTitle = 'Campaign History';
        $campaigns = Campaign::belongsToUser()->latest('id')->paginate(getPaginate());

        return view('Template::user.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle      = 'Create Campaign';
        $allDevice      = Device::belongsToUser()->orderBy('id', 'DESC')->get();
        $groups         = Group::belongsToUser()->active()->whereHas('contact')->orderBy('id', 'DESC')->get();
        $templates      = Template::belongsToUser()->active()->orderBy('id', 'DESC')->get();
        $contactExists  = Contact::belongsToUser()->active()->exists();
        $info           = json_decode(json_encode(getIpInfo()), true);
        $mobileCode     = implode(',', $info['code'] ?? []);
        $countries      = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.campaign.create', compact('pageTitle', 'allDevice', 'templates', 'groups', 'contactExists', 'mobileCode', 'countries'));
    }

    public function save(Request $request)
    {
        $destinationPolicy = app(CampaignDestinationPolicy::class);
        $request->validate([
            'title'          => 'required',
            'device'         => 'required|integer',
            'sim'            => 'required',
            'schedule'       => 'required|in:1,2', // schedule 1=now,2=future date
            'date'           => 'nullable|required_if:schedule,2|date|date_format:Y-m-d H:i|after_or_equal:today',
            'selection_type' => 'required|in:1,2,3,4',
            'contact_list'   => 'nullable|array',
            'group'          => 'nullable|array',
            'mobile_numbers' => 'nullable|required_if:selection_type,3',
            'mobile_code'    => 'nullable|required_if:selection_type,3',
            'country_code'   => ['nullable', 'required_if:selection_type,3', Rule::notIn(CampaignDestinationPolicy::RESTRICTED_COUNTRY_CODES)],
            'country'        => ['nullable', 'required_if:selection_type,3', Rule::notIn(CampaignDestinationPolicy::RESTRICTED_COUNTRY_NAMES)],
            'random_delay_range' => 'required|in:0,3-6,6-12',
            'load_balance_mode' => 'required|in:selected_sim,evenly_split',
            'file'           => ['nullable', 'required_if:selection_type,4', new FileTypeValidate(['csv', 'xlsx', 'txt'])],
            'message'        => 'required|string',
        ]);


        if($request->selection_type == Status::CONTACT && (!$request->contact_list && !$request->select_all_contact)){
            $notify[] = ['error', 'The contact list field is required'];
            return back()->withNotify($notify)->withInput();
        }

        if($request->selection_type == Status::GROUP && (!$request->group && !$request->select_all_group)){
            $notify[] = ['error', 'The group field is required'];
            return back()->withNotify($notify)->withInput();
        }

        $user = auth()->user();
        $numbers = [];
        $eligibleContact = fn (Contact $contact) => !$destinationPolicy->isRestrictedDestination($contact->country, $contact->state);

        if ($request->selection_type == Status::CONTACT) {
            if ($request->select_all_contact) {
                $numbers = Contact::belongsToUser()
                    ->active()
                    ->select('dial_code', 'mobile', 'country', 'state')
                    ->get()
                    ->filter($eligibleContact)
                    ->map(fn($contact) => $contact->dial_code . $contact->mobile)
                    ->toArray();
            } elseif ($request->contact_list) {
                $numbers = Contact::belongsToUser()
                    ->active()
                    ->whereIn('id', $request->contact_list ?? [])
                    ->select('dial_code', 'mobile', 'country', 'state')
                    ->get()
                    ->filter($eligibleContact)
                    ->map(fn($contact) => $contact->dial_code . $contact->mobile)
                    ->toArray();
            }
        } elseif ($request->selection_type == Status::GROUP) {

            if ($request->select_all_group) {
                $numbers = GroupContact::belongsToUser()
                    ->whereHas('contact', fn ($query) => $query->active())
                    ->with('contact:id,dial_code,mobile,country,state,status')
                    ->get()
                    ->filter(fn ($groupContact) => $groupContact->contact && $eligibleContact($groupContact->contact))
                    ->map(fn($groupContact) => $groupContact->contact->dial_code . $groupContact->contact->mobile)
                    ->toArray();
            } elseif ($request->group) {
                $numbers = GroupContact::belongsToUser()
                    ->whereHas('contact', fn ($query) => $query->active())
                    ->whereIn('group_id', $request->group ?? [])
                    ->with('contact:id,dial_code,mobile,country,state,status')
                    ->get()
                    ->filter(fn ($groupContact) => $groupContact->contact && $eligibleContact($groupContact->contact))
                    ->map(fn($groupContact) => $groupContact->contact->dial_code . $groupContact->contact->mobile)
                    ->toArray();
            }
        } elseif($request->selection_type == Status::DIRECT_INPUT) {

            $mobileNumbers = explode("\r\n", trim($request->mobile_numbers));
            $numbers = array_map(fn($number) => $request->mobile_code . $number, $mobileNumbers);
        }elseif($request->selection_type == Status::DIRECT_INPUT_FROM_FILE){
            if ($request->hasFile('file')) {
                $columnNames = ['firstname', 'lastname', 'email', 'dial_code', 'mobile', 'country', 'city', 'state', 'zip'];
                $notify      = [];
                try {
                    $import = importFileReader($request->file, $columnNames, $columnNames);
                    $readData = $import->getReadData();

                    $hasRestrictedRecipient = collect($readData)->contains(function ($row) use ($destinationPolicy) {
                        return $destinationPolicy->isRestrictedDestination($row[5] ?? null, $row[7] ?? null);
                    });
                    if ($hasRestrictedRecipient) {
                        $notify[] = ['error', 'The uploaded file contains a number from a restricted country.'];
                        return back()->withNotify($notify)->withInput();
                    }

                    $numbers = array_map(fn($row) => $row[3] . $row[4], $readData);
                } catch (Exception $ex) {
                    $notify[] = ['error', $ex->getMessage()];
                    return back()->withNotify($notify)->withInput();
                }
            }
        }

        $numbers = array_map('trim', $numbers);
        $numbers = array_unique(array_filter($numbers));

        if (count($numbers) <= 0) {
            $notify[] = ['error', 'At least one mobile number required'];
            return back()->withNotify($notify)->withInput();
        }

        if (!$user->hasLimit('available_sms', count($numbers))) {
            $notify[] = ['error', 'Can\'t send sms. The maximum number of sms limit reached'];
            return back()->withNotify($notify)->withInput();
        }

        if ($request->date) {
            $schedule     = now()->parse($request->date)->format("Y-m-d H:i");
            $eventTrigger = Status::NO;
            $status       = Status::CAMPAIGN_PENDING;
        } else {
            $eventTrigger = Status::YES;
            $schedule     = now()->format("Y-m-d H:i");
            $status       = Status::CAMPAIGN_INITIAL;
        }

        $device = Device::belongsToUser()->find($request->device);

        if (!$device) {
            $notify[] = ['error', 'Device not found'];
            return back()->withNotify($notify)->withInput();
        }

        if (!$device->status) {
            $notify[] = ['error', 'The device is not connected'];
            return back()->withNotify($notify)->withInput();
        }

        if (!array_key_exists($request->sim, $device->sim)) {
            $notify[] = ['error', 'Device slot not found'];
            return back()->withNotify($notify)->withInput();
        }

        $deviceSlot = $device->sim[$request->sim];
        $dispatchTargets = collect([['device' => $device, 'slot' => $deviceSlot]]);

        if ($request->load_balance_mode === 'evenly_split') {
            $dispatchTargets = Device::belongsToUser()
                ->connected()
                ->get()
                ->flatMap(function ($connectedDevice) {
                    return collect($connectedDevice->sim ?? [])
                        ->filter(fn ($slot) => is_array($slot) && isset($slot['slot']))
                        ->map(fn ($slot) => ['device' => $connectedDevice, 'slot' => $slot]);
                })
                ->values();

            if ($dispatchTargets->isEmpty()) {
                $notify[] = ['error', 'No connected Android SIM is available for load balancing.'];
                return back()->withNotify($notify)->withInput();
            }
        }

        [$delayMin, $delayMax] = $request->random_delay_range === '0'
            ? [0, 0]
            : array_map('intval', explode('-', $request->random_delay_range));

        $campaign             = new Campaign();
        $campaign->user_id    = $user->id;
        $campaign->title      = $request->title;
        $campaign->schedule   = $schedule;
        $campaign->et         = $eventTrigger;
        $campaign->status     = $status;
        $campaign->message    = $request->message;
        $campaign->random_delay_min_seconds = $delayMin;
        $campaign->random_delay_max_seconds = $delayMax;
        $campaign->load_balance_mode = $request->load_balance_mode;
        $campaign->save();

        $batch = createBatch();

        if ($request->date) {
            $schedule     = now()->parse($request->date)->format("Y-m-d H:i");
            $eventTrigger = Status::NO;
            $status       = Status::SMS_SCHEDULED;
        } else {
            $eventTrigger = Status::YES;
            $schedule     = now()->format("Y-m-d H:i");
            $status       = Status::SMS_INITIAL;
        }

        $messages = [];
        $dispatchAt = Carbon::parse($schedule);
        $usesRandomDelay = $delayMax > 0;
        foreach ($numbers as $index => $number) {
            $dispatchTarget = $dispatchTargets[$index % $dispatchTargets->count()];
            if ($index > 0 && $usesRandomDelay) {
                $dispatchAt->addSeconds(random_int($delayMin, $delayMax));
            }
            $messageSchedule = $dispatchAt->format('Y-m-d H:i:s');
            $sms                     = new Sms();
            $sms->device_id          = $dispatchTarget['device']->id;
            $sms->user_id            = $campaign->user->id;
            $sms->campaign_id        = $campaign->id;
            $sms->device_slot_number = $dispatchTarget['slot']['slot'];
            $sms->device_slot_name   = $dispatchTarget['slot']['name'] ?? '';
            $sms->mobile_number      = $number;
            $sms->message            = $campaign->message;
            $sms->schedule           = $messageSchedule;
            $sms->batch_id           = $batch->id;
            $sms->status             = $status;
            // Delayed messages stay pending; the server dispatcher releases only those due.
            $sms->et                 = $usesRandomDelay ? Status::NO : $eventTrigger;
            $sms->save();

            $messages[] = $sms;
        }

        $user->subtractLimitCounter('available_sms', count($messages));

        if ($eventTrigger && !$usesRandomDelay) {
            collect($messages)->groupBy('device_id')->each(function ($deviceMessages, $deviceId) use ($delayMin, $delayMax, $request) {
                $targetDevice = Device::find($deviceId);
                event(new MessageSend([
                    'success' => true,
                    'device_id' => $targetDevice?->device_id,
                    'original_data' => [
                        'message' => $deviceMessages->values(),
                        'dispatch_options' => [
                            'random_delay_min_seconds' => $delayMin,
                            'random_delay_max_seconds' => $delayMax,
                            'load_balance_mode' => $request->load_balance_mode,
                        ],
                    ],
                ]));
            });
        }

        $notify[] = ['success', 'Campaign created successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        Campaign::belongsToUser()->findOrFail($id);
        return Campaign::changeStatus($id);
    }

}
