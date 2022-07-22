<?php

namespace App\Rules;

use App\Enums\ReferralStatus;
use App\Models\Referral;
use Illuminate\Contracts\Validation\Rule;

class UnclaimedReferralCode implements Rule
{
    /**
     * Determine if the Referral code is valid and unclaimed
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Referral::where([
            'code' => $value,
            'status' => ReferralStatus::Sent,
        ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid or already used.';
    }
}
