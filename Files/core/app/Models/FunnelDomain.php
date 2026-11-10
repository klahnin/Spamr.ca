<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunnelDomain extends Model
{
    protected $fillable = ['user_id', 'hostname', 'verification_token', 'verification_method', 'verified_at', 'cname_verified_at'];
    protected $casts = ['verified_at' => 'datetime', 'cname_verified_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function funnels() { return $this->hasMany(Funnel::class); }
}
