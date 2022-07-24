<?php

namespace App\Traits;

use App\Models\Referral;

trait HasReferrals
{
    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function referrals() {
        return $this->hasMany(Referral::class, 'referrer_user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Returns number of successful/claimed referrals, regardless of max points
     */
    public function getSuccessfulReferralsCountAttribute(): int {
        return $this->referrals()->claimed()->count();
    }

    /**
     * Returns referral points, taking into account max points
     */
    public function getReferralPointsAttribute(): int {
        return min($this->successfulReferralsCount, config('referrals.max_referral_points'));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function latestReferrals() {
        return $this->referrals()->latest('updated_at')->get();
    }
}
