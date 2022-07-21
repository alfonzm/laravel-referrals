<?php

namespace Tests\Feature\Controllers\ReferralController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticatedUserCannotAccessReferralsPage()
    {
        $response = $this->get(route('referrals.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticatedUserCanAccessReferralsPage()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('referrals.index'));
        $response->assertOk();
    }
}
