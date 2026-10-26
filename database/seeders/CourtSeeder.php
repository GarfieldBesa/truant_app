<?php

namespace Database\Seeders;

use App\Models\Court;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Court::firstOrCreate(
            ['slug' => 'pickleball-court'],
            [
                'name' => 'Pickleball Court',
                'court_type' => 'pickleball',
                'description' => 'Championship pickleball court with cushioned tournament surface, regulation net, LED court lighting, and shaded player lounge.',
                'default_slots_per_hour' => 4,
                'hourly_rate' => 350.00,
                'is_active' => true,
            ]
        );

        Court::firstOrCreate(
            ['slug' => 'basketball-court'],
            [
                'name' => 'Basketball Court',
                'court_type' => 'basketball',
                'description' => 'Full-size standard hardwood basketball court with professional breakaway hoops, digital shot clocks, and spectator seating.',
                'default_slots_per_hour' => 4,
                'hourly_rate' => 600.00,
                'is_active' => true,
            ]
        );
    }
}
