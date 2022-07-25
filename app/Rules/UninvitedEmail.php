<?php

namespace App\Rules;

use App\Models\Referral;
use Illuminate\Contracts\Validation\Rule;

class UninvitedEmail implements Rule
{
    /**
     * Determine if authenticated user has not yet invited the email address
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Referral::where([
            'referrer_user_id' => auth()->user()->id,
            'recipient_email' => $value,
        ])->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have already invited the :attribute :input.';
    }
}
