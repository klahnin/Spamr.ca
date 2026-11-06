<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class KycController extends Controller
{
    public function show()
    {
        $kyc = KycVerification::firstOrCreate(['user_id' => auth()->id()]);
        return view('templates.basic.user.kyc', compact('kyc'));
    }

    public function submit(Request $request)
    {
        $kyc = KycVerification::firstOrCreate(['user_id' => auth()->id()]);
        abort_unless(in_array($kyc->status, ['required', 'rejected'], true), 403);

        $request->validate([
            'id_document' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
            'selfie' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
            'consent' => ['accepted'],
        ]);

        Storage::delete(array_filter([$kyc->id_document_path, $kyc->selfie_path]));
        $kyc->update([
            'id_document_path' => $request->file('id_document')->store('kyc/' . auth()->id(), 'local'),
            'selfie_path' => $request->file('selfie')->store('kyc/' . auth()->id(), 'local'),
            'status' => 'submitted',
            'submitted_at' => now(),
            'consent_at' => now(),
            'admin_note' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);

        return back()->withNotify([['success','KYC submitted for review.']]);
    }
}
