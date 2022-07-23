<?php

namespace Tests\Unit;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function userEarnsReferralPointsForSuccessfulReferrals()
    {
        $user = User::factory()->create();

        // Create 3 unclaimed referrals, or referrals made by other users
        Referral::factory()->create(['referrer_user_id' => $user->id]);
        Referral::factory()->create();
        Referral::factory()->claimed()->create();

        // Create 1 successful referral
        Referral::factory()->claimed()->create(['referrer_user_id' => $user->id]);

        $this->assertEquals($user->referralPoints, 1);
    }

    /** @test */
    public function userCannotEarnMoreThanMaximumPoints()
    {
        $maxPoints = config('referrals.max_referral_points');

        $user = User::factory()->create();
        Referral::factory($maxPoints + 1)->claimed()->create(['referrer_user_id' => $user->id]);

        $this->assertEquals($user->referralPoints, $maxPoints);
    }
}
