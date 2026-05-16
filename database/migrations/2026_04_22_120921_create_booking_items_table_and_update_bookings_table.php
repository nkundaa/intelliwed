<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update bookings table to support totals and multi-service
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_price', 10, 2)->after('user_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable()->change(); // Allow null since we'll use items
        });

        // Create booking_items table
        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('total_price');
            $table->unsignedBigInteger('service_id')->nullable(false)->change();
        });
    }
};
