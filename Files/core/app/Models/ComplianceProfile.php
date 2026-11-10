<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ComplianceProfile extends Model {
    protected $fillable = ['user_id','account_type','legal_business_name','operating_country','operating_region','website','audience_types','industry','monthly_sms_volume','recipient_countries','consent_methods','consent_evidence_url','consent_sample_language','campaign_purposes','sender_name','support_email','public_business_address','privacy_policy_url','submitted_at'];
    protected $casts = ['audience_types'=>'array','recipient_countries'=>'array','consent_methods'=>'array','campaign_purposes'=>'array','submitted_at'=>'datetime'];
    public function user(){ return $this->belongsTo(User::class); }
}
