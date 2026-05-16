<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\User;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photographer = User::where('email', 'photographer@example.com')->first();
        $venue = User::where('email', 'venue@example.com')->first();
        $decorator = User::where('email', 'decorator@example.com')->first();
        $caterer = User::where('email', 'caterer@example.com')->first();
        $musician = User::where('email', 'musician@example.com')->first();
        $beauty = User::where('email', 'beauty@example.com')->first();
        $transport = User::where('email', 'transport@example.com')->first();
        $cake = User::where('email', 'cake@example.com')->first();

        if ($photographer) {
            Vendor::create([
                'user_id' => $photographer->id,
                'name' => 'Elegant Moments Photography',
                'service_type' => 'photographer',
                'price' => 2500,
                'location' => 'Nairobi, Kenya',
                'description' => 'Capture your special moments with our professional wedding photography services. We specialize in candid shots, portraits, and cinematic videography.',
                'image' => null,
                'status' => 'approved',
            ]);
        }

        if ($venue) {
            Vendor::create([
                'user_id' => $venue->id,
                'name' => 'Grand Ballroom Venue',
                'service_type' => 'venue',
                'price' => 5000,
                'location' => 'Nairobi, Kenya',
                'description' => 'A luxurious ballroom perfect for your dream wedding. Capacity for 300 guests, elegant decor, and full catering facilities.',
                'image' => null,
                'status' => 'approved',
            ]);
        }

        if ($decorator) {
            Vendor::create([
                'user_id' => $decorator->id,
                'name' => 'Floral Dreams Decor',
                'service_type' => 'decorator',
                'price' => 1500,
                'location' => 'Nairobi, Kenya',
                'description' => 'Transform your venue into a magical wonderland with our expert floral arrangements and wedding decorations.',
                'image' => null,
                'status' => 'approved',
            ]);
        }

        if ($caterer) {
            Vendor::create([
                'user_id' => $caterer->id,
                'name' => 'Gourmet Catering Co.',
                'service_type' => 'catering',
                'price' => 3000,
                'location' => 'Nairobi, Kenya',
                'description' => 'Delicious cuisine for your special day. From traditional Kenyan dishes to international cuisine, we cater to all preferences.',
                'image' => null,
                'status' => 'approved',
            ]);
        }

        if ($musician) {
            Vendor::create([
                'user_id' => $musician->id,
                'name' => 'Melody Music Band',
                'service_type' => 'music',
                'price' => 2000,
                'location' => 'Nairobi, Kenya',
                'description' => 'Live music to make your wedding unforgettable. From classical to contemporary, we provide the perfect soundtrack.',
                'image' => null,
                'status' => 'approved',
            ]);
        }

        if ($beauty) {
            Vendor::create([
                'user_id' => $beauty->id,
                'name' => 'Beauty by Bella',
                'service_type' => 'beauty',
                'price' => 800,
                'location' => 'Nairobi, Kenya',
                'description' => 'Professional makeup, hair styling, and beauty services for the bride, groom, and bridal party.',
                'image' => null,
                'status' => 'approved',
            ]);
        }

        if ($transport) {
            Vendor::create([
                'user_id' => $transport->id,
                'name' => 'Luxury Car Rentals',
                'service_type' => 'transport',
                'price' => 1200,
                'location' => 'Nairobi, Kenya',
                'description' => 'Elegant transportation for your wedding day. Luxury cars, limousines, and shuttle services.',
                'image' => null,
                'status' => 'approved',
            ]);
        }

        if ($cake) {
            Vendor::create([
                'user_id' => $cake->id,
                'name' => 'Cake Creations',
                'service_type' => 'cake',
                'price' => 600,
                'location' => 'Nairobi, Kenya',
                'description' => 'Custom wedding cakes and desserts. From traditional tiered cakes to modern designs, we create edible art.',
                'image' => null,
                'status' => 'approved',
            ]);
        }
    }
}
