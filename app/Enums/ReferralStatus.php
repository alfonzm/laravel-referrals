<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ReferralStatus extends Enum
{
    const Sent    = 'sent';
    const Claimed = 'claimed';

    public static function getDescription($value): string
    {
        if ($value === self::Sent) {
            return 'Invitation Sent';
        }

        if ($value === self::Claimed) {
            return 'Claimed!';
        }

        return parent::getDescription($value);
    }
}
