<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\RentalItem;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Only one court featured: "Pickle ball court"
        Court::updateOrCreate(
            ['slug' => 'pickleball-court'],
            [
                'name' => 'Pickle ball court',
                'court_type' => 'pickleball',
                'description' => 'Championship pickleball court with cushioned tournament surface, regulation net, LED court lighting, and shaded player lounge.',
                'default_slots_per_hour' => 4,
                'hourly_rate' => 350.00,
                'is_active' => true,
            ]
        );

        // Deactivate basketball or other legacy courts so only Pickle ball court is active
        Court::where('slug', '!=', 'pickleball-court')->update(['is_active' => false]);

        // 2. Initial Rental Items (Managed by Admin)
        $rentalItems = [
            [
                'name' => 'Carbon Fiber Pickleball Paddle',
                'slug' => 'carbon-fiber-paddle',
                'picture' => 'https://images.unsplash.com/photo-1599474924187-334a4ae5bd3c?auto=format&fit=crop&w=600&q=80',
                'description' => 'Lightweight USAPA-approved carbon fiber paddle with ergonomic grip and enhanced sweet spot control.',
                'rental_price' => 50.00,
                'total_stock' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Tournament Outdoor Ball Set (3-Pack)',
                'slug' => 'pickleball-balls-3pack',
                'picture' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=600&q=80',
                'description' => 'High-visibility precision-drilled 40-hole balls engineered for wind resistance and true outdoor bounce.',
                'rental_price' => 30.00,
                'total_stock' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Anti-Fog Protective Court Eyewear',
                'slug' => 'protective-eyewear',
                'picture' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=600&q=80',
                'description' => 'Impact-resistant polycarbonate sports safety goggles with anti-fog ventilation and adjustable strap.',
                'rental_price' => 40.00,
                'total_stock' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($rentalItems as $item) {
            RentalItem::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
