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
            $model->code = self::generateReferralCode();
        });
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
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeClaimed($query) {
        return $query->where('status', ReferralStatus::Claimed);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Create a referral link URL with a `code` query parameter
     * ex: https://<domain>/refer?code=abc-123
     */
    public function getInviteLinkAttribute() {
        return route('registerReferral', ['code' => $this->code]);
    }

    /**
     * sent    === 'Invitation Sent'
     * claimed === 'Claimed!'
     */
    public function getFormattedStatusAttribute() {
        return ReferralStatus::getDescription($this->status);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public static function generateReferralCode(): string {
        return (string) Str::uuid();
    }
}
