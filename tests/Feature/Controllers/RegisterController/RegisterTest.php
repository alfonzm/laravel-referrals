<?php

namespace Tests\Feature;

use App\Enums\ReferralStatus;
use App\Models\Referral;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function guestCanRegisterWithoutReferralCode()
    {
        $referral = Referral::factory()->create();

        $response = $this->postJson(route('register'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => '::password::',
            'password_confirmation' => '::password::',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseCount('users', 2);
    }

    /** @test */
    public function guestCanRegisterWithReferralCode()
    {
        $referral = Referral::factory()->create();

        $response = $this->postJson(route('register'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => '::password::',
            'password_confirmation' => '::password::',
            'referral_code' => $referral->code,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseCount('users', 2);

        $this->assertDatabaseHas('referrals', [
            'id' => $referral->id,
            'status' => ReferralStatus::Claimed
        ]);
    }

    /** @test */
    public function guestCannotRegisterWithClaimedReferralCode()
    {
        $claimedReferral = Referral::factory()->claimed()->create();

        $response = $this->postJson(route('register'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => '::password::',
            'password_confirmation' => '::password::',
            'referral_code' => $claimedReferral->code,
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function guestCannotRegisterWithInvalidReferralCode()
    {
        $response = $this->postJson(route('register'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => '::password::',
            'password_confirmation' => '::password::',
            'referral_code' => '::invalidReferralCode::',
        ]);

        $response->assertStatus(422);
    }
}
