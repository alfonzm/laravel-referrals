<?php

namespace Tests\Unit;

use App\Models\Referral;
use Illuminate\Support\Str;
use Tests\TestCase;

class ReferralTest extends TestCase
{
    /** @test */
    public function referralHasUuidCode()
    {
        $referral = Referral::factory()->create();

        $this->assertTrue(Str::isUuid($referral->code));
    }

    /** @test */
    public function referralHasInvitationLink()
    {
        $referral = Referral::factory()->create();

        $this->assertEquals(
            $referral->inviteLink,
            route('registerReferral', ['code' => $referral->code])
        );
    }
}
