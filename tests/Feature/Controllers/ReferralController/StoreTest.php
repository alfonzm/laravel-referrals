<?php

namespace Tests\Feature\Controllers\ReferralController;

use App\Enums\ReferralStatus;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $authenticatedEmail = 'authenticated@email.com';
    private $registeredEmail    = 'registered@email.com';

    /** @test */
    public function unauthenticatedUserCannotCreateReferrals()
    {
        $response = $this->post(route('referrals.store'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticatedUserCanCreateReferrals()
    {
        $referrerUser = User::factory()->create();
        $recipientEmails = [
            $this->faker->email(),
            $this->faker->email(),
        ];

        $response = $this->actingAs($referrerUser)
            ->post(route('referrals.store'), ['emails' => $recipientEmails]);

        $response->assertCreated();

        $this->assertDatabaseCount('referrals', 2);

        foreach($recipientEmails as $email) {
            $this->assertDatabaseHas('referrals', [
                'recipient_email'  => $email,
                'referrer_user_id' => $referrerUser->id,
                'status'           => ReferralStatus::Sent,
            ]);
        }
    }

    /**
     * @test
     * @dataProvider provideInvalidEmailsData
     */
    public function invalidEmailsShouldReturnErrors($emails)
    {
        // Create a user and referral to test errors for existing and invited emails
        User::factory()->create(['email' => $this->registeredEmail]);

        $authUser = User::factory()->create(['email' => $this->authenticatedEmail]);

        $response = $this->actingAs($authUser)
            ->postJson(route('referrals.store'), ['emails' => $emails])
            ->dump()
            ->assertStatus(422);
    }

    public function provideInvalidEmailsData()
    {
        return [
            'empty array'           => [[]],
            'empty email string'    => [['']],
            'invalid email'         => [['email2']],
            'duplicate emails'      => [['duplicate@email.com', 'duplicate@email.com']],
            'current user email'    => [[$this->authenticatedEmail]],
            'registered user email' => [[$this->registeredEmail]],
        ];
    }
}
