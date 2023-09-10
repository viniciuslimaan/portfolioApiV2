<?php

namespace Database\Seeders;

use App\Models\Academic;
use App\Models\Portfolio;
use App\Models\User;
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
        User::factory()->count(3)->create();
        Academic::factory()->create();
        Portfolio::factory()->count(10)->create();

        $this->call([
            DefaultAdminSeeder::class
        ]);
    }
}
