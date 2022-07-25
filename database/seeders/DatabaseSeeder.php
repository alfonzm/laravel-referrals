<?php

namespace Database\Seeders;

use Database\Seeders\AdminSeeder;
use Database\Seeders\ReferralsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(ReferralsSeeder::class);
    }
}
