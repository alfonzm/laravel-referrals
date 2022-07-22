<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\User;

class ReferralService
{
    /**
     * Create referrals and send out invitation links
     *
     * @param User $user User who creates the referrals, i.e. referrer
     * @param array $emails Emails to send out invitations to
     * @return void
     */
    public function createReferrals(User $referrer, array $emails)
    {
        $referrals = collect($emails)->map(function ($email) use ($referrer) {
            return [
                'referrer_user_id' => $referrer->id,
                'recipient_email' => $email,
            ];
        });

        $referrer->referrals()->createMany($referrals);
    }
}
