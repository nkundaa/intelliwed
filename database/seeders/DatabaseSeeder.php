<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'client',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create multiple vendor users
        $photographer = User::factory()->create([
            'name' => 'Elegant Moments Photography',
            'email' => 'photographer@example.com',
            'role' => 'vendor',
        ]);

        $venue = User::factory()->create([
            'name' => 'Grand Ballroom Venue',
            'email' => 'venue@example.com',
            'role' => 'vendor',
        ]);

        $decorator = User::factory()->create([
            'name' => 'Floral Dreams Decor',
            'email' => 'decorator@example.com',
            'role' => 'vendor',
        ]);

        $caterer = User::factory()->create([
            'name' => 'Gourmet Catering Co.',
            'email' => 'caterer@example.com',
            'role' => 'vendor',
        ]);

        $musician = User::factory()->create([
            'name' => 'Melody Music Band',
            'email' => 'musician@example.com',
            'role' => 'vendor',
        ]);

        $beauty = User::factory()->create([
            'name' => 'Beauty by Bella',
            'email' => 'beauty@example.com',
            'role' => 'vendor',
        ]);

        $transport = User::factory()->create([
            'name' => 'Luxury Car Rentals',
            'email' => 'transport@example.com',
            'role' => 'vendor',
        ]);

        $cake = User::factory()->create([
            'name' => 'Cake Creations',
            'email' => 'cake@example.com',
            'role' => 'vendor',
        ]);

        $this->call([
            IntelliWedSeeder::class,
        ]);
    }
}
