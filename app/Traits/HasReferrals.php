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

    public function getSuccessfulReferralsCountAttribute() {
        return $this->referrals()->claimed()->count();
    }

    public function getReferralPointsAttribute() {
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
