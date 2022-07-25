<?php

namespace App\Services;

use App\Enums\ReferralStatus;
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
    public function sendReferralLinks(User $referrer, array $emails)
    {
        // Create array of [['recipient_email' => $email], ...]
        $referralEmails = collect($emails)
            ->map(function ($email) {
                return ['recipient_email' => $email];
            });

        // Persist to DB
        $referrals = $referrer->referrals()->createMany($referralEmails);

        // Send out invitation links
        $referrals->each(function($referral) {
            SendReferralLink::dispatch($referral);
        });
    }

    /**
     * Mark a referral as claimed after the recipient has registered
     *
     * @param User $user User who creates the referrals, i.e. referrer
     * @param array $emails Emails to send out invitations to
     * @return void
     */
    public function claimReferral(Referral $referral)
    {
        $referral->update(['status' => ReferralStatus::Claimed]);
    }
}
