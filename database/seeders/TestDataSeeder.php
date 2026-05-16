<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Service;
use App\Models\Booking;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // Create vendor user and vendor account
        $vendorUser = User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@test.com',
            'password' => bcrypt('password'),
            'role' => 'vendor'
        ]);

        $vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'business_name' => 'Perfect Wedding Photography',
            'description' => 'Professional wedding photography services',
            'phone' => '+1234567890',
            'website' => 'https://perfectwedding.com',
            'status' => 'approved'
        ]);

        // Create a service for the vendor
        $service = Service::create([
            'user_id' => $vendorUser->id,
            'title' => 'Premium Wedding Package',
            'category' => 'photographer',
            'description' => 'Full day wedding photography with 2 photographers',
            'price' => 2500.00,
            'location' => 'New York, NY',
            'phone' => '+1234567890',
            'website' => 'https://perfectwedding.com',
            'main_image' => 'services/wedding1.jpg',
            'image2' => 'services/wedding2.jpg',
            'image3' => 'services/wedding3.jpg',
            'status' => 'approved'
        ]);

        // Create client user
        $client = User::create([
            'name' => 'Client User',
            'email' => 'client@test.com',
            'password' => bcrypt('password'),
            'role' => 'client'
        ]);

        // Create a booking
        Booking::create([
            'user_id' => $client->id,
            'service_id' => $service->id,
            'date' => now()->addDays(30),
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);
    }
}
