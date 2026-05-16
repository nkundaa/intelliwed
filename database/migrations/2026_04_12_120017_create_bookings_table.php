<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');

            // booking details
            $table->date('date'); // booking date
            $table->string('status')->default('pending'); // pending, approved, rejected

            $table->timestamps();
            $table->string('payment_status')->default('pending');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};