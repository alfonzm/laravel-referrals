<?php

namespace Tests\Feature\Controllers\ReferralController;

use App\Enums\ReferralStatus;
use App\Jobs\SendReferralLink;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $authenticatedEmail = 'authenticated@email.com';
    private $registeredEmail    = 'registered@email.com';
    private $invitedEmail       = 'invited@email.com';

    /** @test */
    public function unauthenticatedUserCannotCreateReferrals()
    {
        $response = $this->post(route('referrals.store'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticatedUserCanSendReferrals()
    {
        Queue::fake();

        $referrerUser = User::factory()->create();
        $recipientEmails = [
            $this->faker->email(),
            $this->faker->email(),
        ];

        $response = $this->actingAs($referrerUser)
            ->postJson(route('referrals.store'), ['emails' => $recipientEmails]);

        $response->assertCreated();

        $this->assertDatabaseCount('referrals', count($recipientEmails));

        foreach($recipientEmails as $email) {
            $this->assertDatabaseHas('referrals', [
                'recipient_email'  => $email,
                'referrer_user_id' => $referrerUser->id,
                'status'           => ReferralStatus::Sent,
            ]);
        }

        Queue::assertPushed(SendReferralLink::class, count($recipientEmails));
    }

    /** @test */
    public function userCannotInviteEmailAgain()
    {
        Queue::fake();

        $referral = Referral::factory()->create(['recipient_email' => $this->invitedEmail]);

        $response = $this->actingAs($referral->referrer)
            ->postJson(route('referrals.store'), ['emails' => [$this->invitedEmail]]);

        $response->assertStatus(422);

        $this->assertDatabaseCount('referrals', 1);

        Queue::assertNothingPushed();
    }

    /** @test */
    public function otherUserCanInviteInvitedEmailAgain()
    {
        Queue::fake();

        $referral = Referral::factory()->create(['recipient_email' => $this->invitedEmail]);
        $newUser = User::factory()->create();

        $response = $this->actingAs($newUser)
            ->postJson(route('referrals.store'), ['emails' => [$this->invitedEmail]]);

        $response->assertCreated();

        $this->assertEquals(2, Referral::where('recipient_email', $this->invitedEmail)->count());

        Queue::assertPushed(SendReferralLink::class, 1);
    }

    /**
     * @test
     * @dataProvider provideInvalidEmailsData
     */
    public function invalidEmailsCannotBeInvited($emails)
    {
        Queue::fake();

        // Create a user and referral to test errors for existing and invited emails
        User::factory()->create(['email' => $this->registeredEmail]);
        Referral::factory()->create(['recipient_email' => $this->invitedEmail]);

        $authUser = User::factory()->create(['email' => $this->authenticatedEmail]);

        $response = $this->actingAs($authUser)
            ->postJson(route('referrals.store'), ['emails' => $emails])
            ->assertStatus(422);

        Queue::assertNothingPushed();
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
