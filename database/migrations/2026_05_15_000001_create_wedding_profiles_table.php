<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('partner_name')->nullable();
            $table->date('wedding_date')->nullable();
            $table->string('venue')->nullable();
            $table->string('venue_location')->nullable();
            $table->enum('theme', ['luxury', 'traditional', 'modern', 'minimalist', 'garden', 'royal', 'afro-fusion'])->nullable();
            $table->enum('ceremony_type', ['gusaba', 'gukwa', 'traditional', 'civil', 'modern', 'reception', 'mixed'])->nullable();
            $table->decimal('total_budget', 12, 2)->nullable();
            $table->integer('guest_count_estimate')->nullable();
            $table->text('love_story')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->boolean('website_enabled')->default(false);
            $table->string('website_theme')->default('classic');
            $table->string('cover_image')->nullable();
            $table->string('primary_color')->default('#9bf6af');
            $table->text('special_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_profiles');
    }
};
