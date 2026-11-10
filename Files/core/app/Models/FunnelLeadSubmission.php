<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunnelLeadSubmission extends Model
{
    protected $fillable = ['user_id', 'funnel_id', 'funnel_link_id', 'campaign_id', 'recipient_hash', 'fields', 'status', 'submitted_at'];
    protected $casts = ['fields' => 'encrypted:array', 'submitted_at' => 'datetime'];
    public function funnel() { return $this->belongsTo(Funnel::class); }
}
