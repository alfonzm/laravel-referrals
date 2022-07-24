<?php

namespace Database\Seeders;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ReferralsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name'  => 'Referrals',
            'email' => 'referrals@contactout.com',
            // password is 'password'
        ]);

        Referral::factory(10)
            ->claimed()
            ->referredBy($user->id)
            ->create();
    }
}
