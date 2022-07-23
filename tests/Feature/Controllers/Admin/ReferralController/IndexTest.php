<?php

namespace Tests\Feature\Controllers\Admin\ReferralController;

use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->seed(AdminSeeder::class);
    }

    /** @test */
    public function unauthenticatedUserCannotAccessReferralsDashboard()
    {
        $response = $this->get(route('admin.referrals.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function nonAdminCannotAccessReferralsDashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.referrals.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function adminCanAccessReferralsDashboard()
    {
        $user = User::factory()->admin()->create();
        $response = $this->actingAs($user)->get(route('admin.referrals.index'));
        $response->assertOk();
    }
}
