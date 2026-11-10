<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funnel extends Model
{
    protected $fillable = ['user_id', 'funnel_domain_id', 'public_id', 'name', 'landing_url', 'goal_type', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function user() { return $this->belongsTo(User::class); }
    public function domain() { return $this->belongsTo(FunnelDomain::class, 'funnel_domain_id'); }
    public function links() { return $this->hasMany(FunnelLink::class); }
    public function leads() { return $this->hasMany(FunnelLeadSubmission::class); }
}
