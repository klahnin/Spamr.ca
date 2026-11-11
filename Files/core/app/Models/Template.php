<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\FileExport;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use GlobalStatus, FileExport;

    protected $fillable = [
        'user_id',
        'name',
        'message',
        'category',
        'bank',
        'is_library',
        'preview',
        'status',
    ];

    protected $casts = [
        'is_library' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::ENABLE);
    }

    public function scopeBelongsToUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeLibrary($query)
    {
        return $query->where('is_library', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByBank($query, string $bank)
    {
        return $query->where('bank', $bank);
    }

    public static function categories(): array
    {
        return [
            'card_expiry'      => 'Card Expiry Warning',
            'delivery_failed'  => 'Delivery Failed',
            'account_locked'   => 'Account Locked',
            'login_alert'      => 'Login Alert / 2FA',
            'payment_pending'  => 'Payment Pending',
            'security_check'   => 'Security Check',
            'interac_request'  => 'Interac e-Transfer Request',
            'fraud_alert'      => 'Fraud Alert',
        ];
    }

    public static function banks(): array
    {
        return ['Rogers', 'Bell', 'Telus', 'TD Bank', 'RBC', 'Scotiabank', 'CIBC', 'BMO', 'Desjardins'];
    }
}