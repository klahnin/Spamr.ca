<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KycVerification extends Model {
    protected $fillable = ['user_id','status','reason','verification_type','id_document_path','selfie_path','business_document_path','director_id_document_path','verification_data','admin_note','reviewed_by','submitted_at','reviewed_at','consent_at'];
    protected $casts = ['verification_data'=>'encrypted:array','submitted_at'=>'datetime','reviewed_at'=>'datetime','consent_at'=>'datetime'];
    public function user(){ return $this->belongsTo(User::class); }
    public function reviewer(){ return $this->belongsTo(Admin::class,'reviewed_by'); }
}
