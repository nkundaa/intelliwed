<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename vendors table to services
        Schema::rename('vendors', 'services');

        // Add new fields to services table
        Schema::table('services', function (Blueprint $table) {
            $table->string('title')->after('name'); // Rename name to title
            $table->string('category')->after('service_type'); // Rename service_type to category
            $table->string('main_image')->after('image');
            $table->string('image2')->nullable()->after('main_image');
            $table->string('image3')->nullable()->after('image2');
            $table->dropColumn(['service_type', 'name']); // Remove old columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('service_type')->after('name');
            $table->dropColumn(['title', 'category', 'main_image', 'image2', 'image3']);
        });

        Schema::rename('services', 'vendors');
    }
};
