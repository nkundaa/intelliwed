<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->integer('table_number')->nullable()->after('meal_pref');
            $table->enum('category', ['family', 'friend', 'colleague', 'vip', 'other'])->default('other')->after('table_number');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn(['table_number', 'category']);
        });
    }
};
