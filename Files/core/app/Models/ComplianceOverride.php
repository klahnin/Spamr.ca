<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplianceOverride extends Model
{
    protected $fillable = ['user_id', 'completed_by', 'completed_at'];

    protected $casts = ['completed_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
