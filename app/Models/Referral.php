<?php

namespace App\Models;

use App\Enums\ReferralStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_user_id',
        'recipient_email',
        'status',
    ];

    protected $appends = ['formattedStatus'];

    public static function boot() {
        parent::boot();

        self::creating(function ($model) {
            $model->code = (string) Str::uuid();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeClaimed($query) {
        return $query->where('status', ReferralStatus::Claimed);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_user_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getInviteLinkAttribute() {
        return route('registerReferral', ['code' => $this->code]);
    }

    public function getFormattedStatusAttribute() {
        return ReferralStatus::getDescription($this->status);
    }
}
