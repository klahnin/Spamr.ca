<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\ComplianceProfile;
use App\Models\KycVerification;
use Illuminate\Http\Request;

class ComplianceOnboardingController extends Controller {
    public function show(){ $pageTitle='Compliance onboarding'; return view('Template::user.compliance_onboarding', compact('pageTitle')); }
    public function submit(Request $request){
        $request->validate([
            'account_type'=>'required|in:individual,business,agency,nonprofit','legal_business_name'=>'nullable|string|max:255','operating_country'=>'required|string|max:100','operating_region'=>'required|string|max:100','website'=>'required|url|max:2048',
            'audience_types'=>'required|array|min:1','audience_types.*'=>'in:customers,opted_in_leads,members,internal_team','industry'=>'required|string|max:120','monthly_sms_volume'=>'required|in:under_1000,1000_10000,10001_50000,50001_250000,over_250000','recipient_countries'=>'required|string|max:1000',
            'consent_methods'=>'required|array|min:1','consent_methods.*'=>'in:website_checkbox,checkout_relationship,in_person_written,documented_other','consent_evidence_url'=>'nullable|url|max:2048','consent_sample_language'=>'nullable|string|max:5000','campaign_purposes'=>'required|array|min:1','campaign_purposes.*'=>'in:promotions,appointments,updates,events,account_notifications',
            'sender_name'=>'required|string|max:120','support_email'=>'required|email|max:255','public_business_address'=>'required|string|max:1000','privacy_policy_url'=>'required|url|max:2048','prohibited_use_ack'=>'accepted','opt_out_ack'=>'accepted','documented_consent_ack'=>'accepted','no_harvested_lists_ack'=>'accepted','suspension_ack'=>'accepted',
        ]);
        if ($request->account_type !== 'individual') $request->validate(['legal_business_name'=>'required|string|max:255']);
        if (!$request->filled('consent_evidence_url') && !$request->filled('consent_sample_language')) {
            return back()->withErrors([
                'consent_evidence_url' => 'Provide a landing-page URL or sample consent language before activation.',
            ])->withInput();
        }
        $profile = ComplianceProfile::updateOrCreate(['user_id'=>auth()->id()], array_merge($request->only(['account_type','legal_business_name','operating_country','operating_region','website','audience_types','industry','monthly_sms_volume','consent_methods','consent_evidence_url','consent_sample_language','campaign_purposes','sender_name','support_email','public_business_address','privacy_policy_url']), ['recipient_countries'=>array_values(array_filter(array_map('trim', explode(',', $request->recipient_countries)))),'submitted_at'=>now()]));
        KycVerification::updateOrCreate(['user_id'=>auth()->id()], ['status'=>'required','verification_type'=>$profile->account_type === 'individual' ? 'individual' : 'business','reason'=>'Initial compliance and identity verification required.']);
        return to_route('user.kyc.show')->withNotify([['success','Compliance profile saved. Complete verification to activate messaging.']]);
    }
}
