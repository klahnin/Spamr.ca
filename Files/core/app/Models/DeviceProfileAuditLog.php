<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceProfileAuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'personal_access_token_id',
        'event',
        'changed_fields',
    ];

    protected $casts = [
        'changed_fields' => 'array',
    ];
}
