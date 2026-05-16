<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate old category values to new standardised ones
        DB::statement("UPDATE services SET category = 'photography' WHERE category = 'photographer'");
        DB::statement("UPDATE services SET category = 'decor' WHERE category IN ('decorator', 'flowers')");
        DB::statement("UPDATE services SET category = 'attire' WHERE category = 'beauty'");
        DB::statement("UPDATE services SET category = 'transport' WHERE category IN ('car_rental', 'transportation')");
        DB::statement("UPDATE services SET category = 'other' WHERE category = 'cake'");

        DB::statement("ALTER TABLE services MODIFY COLUMN category ENUM(
            'venue',
            'catering',
            'photography',
            'decor',
            'attire',
            'music',
            'invitations',
            'transport',
            'ceremony',
            'other'
        ) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("UPDATE services SET category = 'photographer' WHERE category = 'photography'");
        DB::statement("UPDATE services SET category = 'decorator' WHERE category = 'decor'");
        DB::statement("UPDATE services SET category = 'beauty' WHERE category = 'attire'");
        DB::statement("UPDATE services SET category = 'car_rental' WHERE category = 'transport'");

        DB::statement("ALTER TABLE services MODIFY COLUMN category ENUM(
            'venue',
            'car_rental',
            'photographer',
            'decorator',
            'catering',
            'music',
            'beauty',
            'cake',
            'flowers',
            'transportation'
        ) NOT NULL");
    }
};
