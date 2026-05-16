<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->after('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->default(5)->comment('1-5 stars');
            $table->string('title')->nullable();
            $table->text('body');
            $table->boolean('is_verified')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['service_id']);
            $table->dropColumn(['user_id', 'service_id', 'rating', 'title', 'body', 'is_verified']);
        });
    }
};
