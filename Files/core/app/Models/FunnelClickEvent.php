<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunnelClickEvent extends Model
{
    protected $fillable = ['funnel_link_id', 'recipient_hash', 'visitor_hash', 'clicked_at'];
    protected $casts = ['clicked_at' => 'datetime'];
}
