<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ReferralStatus extends Enum
{
    const Sent    = 'sent';
    const Claimed = 'claimed';
}
