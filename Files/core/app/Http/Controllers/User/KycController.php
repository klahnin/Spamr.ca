<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\ComplianceProfile;
use App\Models\KycVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class KycController extends Controller {
    public function show(){
        $profile = ComplianceProfile::where('user_id', auth()->id())->first();
        $type = $profile?->account_type === 'individual' ? 'individual' : 'business';
        $kyc = KycVerification::firstOrCreate(['user_id'=>auth()->id()], ['status'=>'required','verification_type'=>$type]);
        $pageTitle = $type === 'individual' ? 'Identity verification' : 'Business verification';
        return view('Template::user.kyc', compact('pageTitle','kyc','profile','type'));
    }
    public function submit(Request $request){
        $profile = ComplianceProfile::where('user_id', auth()->id())->first();
        $type = $profile?->account_type === 'individual' ? 'individual' : 'business';
        $kyc = KycVerification::firstOrCreate(['user_id'=>auth()->id()], ['status'=>'required','verification_type'=>$type]);
        abort_unless(in_array($kyc->status, ['required','rejected'], true), 403);
        $rules = ['consent'=>['accepted']];
        if ($type === 'individual') $rules += ['legal_name'=>['required','string','max:255'],'date_of_birth'=>['required','date','before:today'],'residential_address'=>['required','string','max:1000'],'id_front'=>['required','image','mimes:jpg,jpeg,png','max:10240'],'id_back'=>['required','image','mimes:jpg,jpeg,png','max:10240']];
        else $rules += ['legal_entity_name'=>['required','string','max:255'],'incorporation_number'=>['required','string','max:120'],'registered_address'=>['required','string','max:1000'],'beneficial_owners'=>['required','string','max:4000'],'business_document'=>['required','file','mimes:jpg,jpeg,png,pdf','max:10240'],'director_id_document'=>['required','file','mimes:jpg,jpeg,png,pdf','max:10240'],'domain_confirmation'=>['accepted']];
        $request->validate($rules);
        Storage::delete(array_filter([$kyc->id_document_path,$kyc->selfie_path,$kyc->business_document_path,$kyc->director_id_document_path]));
        $data = $type === 'individual' ? $request->only('legal_name','date_of_birth','residential_address') : $request->only('legal_entity_name','incorporation_number','registered_address','beneficial_owners');
        $kyc->update(['status'=>'submitted','verification_type'=>$type,'verification_data'=>$data,'id_document_path'=>$type==='individual' ? $request->file('id_front')->store('kyc/'.auth()->id(),'local') : null,'selfie_path'=>$type==='individual' ? $request->file('id_back')->store('kyc/'.auth()->id(),'local') : null,'business_document_path'=>$type==='business' ? $request->file('business_document')->store('kyc/'.auth()->id(),'local') : null,'director_id_document_path'=>$type==='business' ? $request->file('director_id_document')->store('kyc/'.auth()->id(),'local') : null,'submitted_at'=>now(),'consent_at'=>now(),'admin_note'=>null,'reviewed_by'=>null,'reviewed_at'=>null]);
        return back()->withNotify([['success','Verification submitted for manual review.']]);
    }
}
