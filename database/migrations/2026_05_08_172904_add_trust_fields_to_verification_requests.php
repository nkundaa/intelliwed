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
        Schema::table('verification_requests', function (Blueprint $table) {
            $table->string('business_license_path')->nullable()->after('id_document_path');
            $table->string('portfolio_link')->nullable()->after('business_license_path');
            $table->string('physical_address')->nullable()->after('portfolio_link');
            $table->integer('years_experience')->nullable()->after('physical_address');
            $table->string('reference_contact')->nullable()->after('years_experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verification_requests', function (Blueprint $table) {
            $table->dropColumn(['business_license_path', 'portfolio_link', 'physical_address', 'years_experience', 'reference_contact']);
        });
    }
};
