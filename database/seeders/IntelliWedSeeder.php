<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class IntelliWedSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@intelliwed.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Vendor Users and their services
        $vendorData = [
            [
                'name' => 'Elegant Moments Photography',
                'email' => 'photo@elegantmoments.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Premium Wedding Photography Package',
                        'category' => 'photographer',
                        'description' => 'Full-day wedding photography coverage with two professional photographers. Includes engagement session, bridal portraits, ceremony coverage, and reception coverage. You\'ll receive all edited high-resolution images with printing rights. Our team specializes in capturing candid moments and creating stunning portraits that tell your unique love story.',
                        'price' => 3500.00,
                        'location' => 'New York, NY',
                        'contact_info' => 'photo@elegantmoments.com | (555) 123-4567',
                    ],
                    [
                        'title' => 'Intimate Wedding Photography',
                        'category' => 'photographer',
                        'description' => 'Perfect for smaller weddings with up to 50 guests. Includes 6 hours of coverage, one photographer, engagement session, and all edited digital images. We focus on capturing the intimate moments and details that make your special day unique.',
                        'price' => 1800.00,
                        'location' => 'New York, NY',
                        'contact_info' => 'photo@elegantmoments.com | (555) 123-4567',
                    ]
                ]
            ],
            [
                'name' => 'Grand Ballroom Venues',
                'email' => 'events@grandballroom.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Luxury Ballroom Wedding Package',
                        'category' => 'venue',
                        'description' => 'Elegant ballroom venue with capacity for 300 guests. Includes full catering service, open bar, professional staff, wedding coordinator, tables, chairs, linens, and centerpieces. Our ballroom features crystal chandeliers, hardwood dance floor, and bridal suite. Perfect for traditional and modern weddings.',
                        'price' => 15000.00,
                        'location' => 'Manhattan, NY',
                        'contact_info' => 'events@grandballroom.com | (555) 234-5678',
                    ]
                ]
            ],
            [
                'name' => 'Floral Dreams Decor',
                'email' => 'design@floraldreams.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Complete Wedding Decoration Package',
                        'category' => 'decorator',
                        'description' => 'Full wedding decoration service including ceremony and reception decor. Custom floral arrangements, aisle decorations, altar flowers, table centerpieces, chair decorations, and lighting design. We work with your color scheme and theme to create the perfect ambiance for your special day.',
                        'price' => 4500.00,
                        'location' => 'Brooklyn, NY',
                        'contact_info' => 'design@floraldreams.com | (555) 345-6789',
                    ]
                ]
            ],
            [
                'name' => 'Gourmet Catering Co.',
                'email' => 'catering@gourmetco.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Premium Wedding Catering Service',
                        'category' => 'catering',
                        'description' => 'Full-service wedding catering for up to 200 guests. Includes appetizers, main course with multiple options, sides, salads, wedding cake, and late-night snacks. Professional staff, bartending service, and all dinnerware provided. We accommodate dietary restrictions and special requests.',
                        'price' => 120.00,
                        'location' => 'Queens, NY',
                        'contact_info' => 'catering@gourmetco.com | (555) 456-7890',
                    ]
                ]
            ],
            [
                'name' => 'Melody Music Band',
                'email' => 'music@melodyband.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Live Wedding Band Entertainment',
                        'category' => 'music',
                        'description' => 'Professional 6-piece wedding band with male and female vocalists. We perform a wide variety of music genres including pop, rock, jazz, R&B, and traditional wedding songs. Includes ceremony music, cocktail hour entertainment, and reception dance party. Professional sound system and lighting included.',
                        'price' => 3500.00,
                        'location' => 'Bronx, NY',
                        'contact_info' => 'music@melodyband.com | (555) 567-8901',
                    ]
                ]
            ],
            [
                'name' => 'Beauty by Bella',
                'email' => 'beauty@beautybella.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Bridal Beauty Package',
                        'category' => 'beauty',
                        'description' => 'Complete bridal beauty services including makeup and hair styling for bride and up to 4 bridesmaids. Includes trial session, wedding day touch-up kit, and on-location services. Our artists use high-end products and specialize in both natural and dramatic looks that last all day.',
                        'price' => 1200.00,
                        'location' => 'Manhattan, NY',
                        'contact_info' => 'beauty@beautybella.com | (555) 678-9012',
                    ]
                ]
            ],
            [
                'name' => 'Luxury Car Rentals',
                'email' => 'cars@luxuryrentals.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Wedding Transportation Package',
                        'category' => 'transportation',
                        'description' => 'Luxury wedding transportation service including 3-hour limousine service for bride and bridesmaids, separate transportation for groom and groomsmen, and luxury car for newlyweds after reception. Professional chauffeurs, decorated vehicles, and champagne service included.',
                        'price' => 2500.00,
                        'location' => 'New York, NY',
                        'contact_info' => 'cars@luxuryrentals.com | (555) 789-0123',
                    ]
                ]
            ],
            [
                'name' => 'Cake Creations Studio',
                'email' => 'cakes@cakecreations.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Custom Wedding Cake Package',
                        'category' => 'cake',
                        'description' => 'Custom-designed wedding cake serving up to 150 guests. Includes consultation, custom design, delivery, setup, and cake cutting service. We use premium ingredients and can accommodate dietary restrictions. Multiple cake tiers, custom flavors, and intricate decorations available.',
                        'price' => 800.00,
                        'location' => 'Staten Island, NY',
                        'contact_info' => 'cakes@cakecreations.com | (555) 890-1234',
                    ]
                ]
            ],
            [
                'name' => 'Bloom & Blossom Florists',
                'email' => 'flowers@bloomblossom.com',
                'password' => 'vendor123',
                'services' => [
                    [
                        'title' => 'Complete Floral Design Package',
                        'category' => 'flowers',
                        'description' => 'Comprehensive floral design service including bridal bouquet, bridesmaid bouquets, boutonnieres, corsages, ceremony flowers, and reception centerpieces. We work with seasonal flowers and your color palette to create stunning arrangements. Delivery and setup included.',
                        'price' => 3200.00,
                        'location' => 'New York, NY',
                        'contact_info' => 'flowers@bloomblossom.com | (555) 901-2345',
                    ]
                ]
            ]
        ];

        foreach ($vendorData as $vendorInfo) {
            // Create vendor user
            $vendorUser = User::create([
                'name' => $vendorInfo['name'],
                'email' => $vendorInfo['email'],
                'password' => Hash::make($vendorInfo['password']),
                'role' => 'vendor',
            ]);

            // Create vendor record
            $vendor = Vendor::create([
                'user_id' => $vendorUser->id,
                'status' => 'approved',
            ]);

            // Create services for this vendor
            foreach ($vendorInfo['services'] as $serviceData) {
                Service::create([
                    'vendor_id' => $vendor->id,
                    'title' => $serviceData['title'],
                    'category' => $serviceData['category'],
                    'description' => $serviceData['description'],
                    'price' => $serviceData['price'],
                    'location' => $serviceData['location'],
                    'contact_info' => $serviceData['contact_info'],
                    'main_image' => 'services/' . strtolower(str_replace(' ', '_', $serviceData['category'])) . '_1.jpg',
                    'image2' => 'services/' . strtolower(str_replace(' ', '_', $serviceData['category'])) . '_2.jpg',
                    'image3' => 'services/' . strtolower(str_replace(' ', '_', $serviceData['category'])) . '_3.jpg',
                    'status' => 'active',
                ]);
            }
        }

        // Create Client Users
        $clientData = [
            ['name' => 'Sarah Johnson', 'email' => 'sarah.j@email.com', 'password' => 'client123'],
            ['name' => 'Michael Chen', 'email' => 'michael.c@email.com', 'password' => 'client123'],
            ['name' => 'Emily Rodriguez', 'email' => 'emily.r@email.com', 'password' => 'client123'],
            ['name' => 'David Thompson', 'email' => 'david.t@email.com', 'password' => 'client123'],
            ['name' => 'Jessica Martinez', 'email' => 'jessica.m@email.com', 'password' => 'client123'],
        ];

        $clients = [];
        foreach ($clientData as $clientInfo) {
            $client = User::create([
                'name' => $clientInfo['name'],
                'email' => $clientInfo['email'],
                'password' => Hash::make($clientInfo['password']),
                'role' => 'client',
            ]);
            $clients[] = $client;
        }

        // Create some sample bookings
        $services = Service::all();
        $bookingStatuses = ['pending', 'confirmed', 'completed'];

        foreach ($clients as $index => $client) {
            if ($index < 3 && $services->count() > $index) {
                $service = $services->random();
                Booking::create([
                    'user_id' => $client->id,
                    'service_id' => $service->id,
                    'status' => $bookingStatuses[array_rand($bookingStatuses)],
                    'booking_date' => now()->addDays(rand(10, 60)),
                    'notes' => 'Looking forward to our special day!',
                ]);
            }
        }

        $this->command->info('IntelliWed database seeded successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin@intelliwed.com / admin123');
        $this->command->info('Vendors: (any vendor email) / vendor123');
        $this->command->info('Clients: (any client email) / client123');
    }
}
