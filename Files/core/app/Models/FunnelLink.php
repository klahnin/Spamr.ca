<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunnelLink extends Model
{
    protected $fillable = ['user_id', 'funnel_id', 'campaign_id', 'label', 'slug', 'token_hash', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function funnel() { return $this->belongsTo(Funnel::class); }
}
