<?php

namespace App\Services;

use App\Jobs\SendReferralLink;
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
    public function sendReferralLink(User $referrer, array $emails)
    {
        // Create referrals and persist to DB
        $referralEmails = collect($emails)
            ->map(function ($email) {
                return ['recipient_email' => $email];
            });

        $referrals = $referrer->referrals()->createMany($referralEmails);

        // Send out invitation links
        $referrals->each(function($referral) {
            SendReferralLink::dispatch($referral);
        });
    }
}
