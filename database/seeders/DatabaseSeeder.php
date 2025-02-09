<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RegionSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            AdSeeder::class,
            BadgeSeeder::class,
            MessagingTestSeeder::class,
        ]);
    }
}
