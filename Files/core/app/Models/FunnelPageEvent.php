<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunnelPageEvent extends Model
{
    protected $fillable = ['funnel_id', 'funnel_link_id', 'visitor_hash', 'event_type', 'scroll_depth', 'occurred_at'];
    protected $casts = ['occurred_at' => 'datetime'];
}
