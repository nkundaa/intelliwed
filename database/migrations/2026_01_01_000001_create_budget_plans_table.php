<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('budget_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_budget', 12, 2);
            $table->decimal('remaining_budget', 12, 2);
            $table->json('allocations')->nullable(); // Store how budget is allocated
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('budget_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('budget_amount', 12, 2);
            $table->json('suggested_services');
            $table->json('packages');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budget_suggestions');
        Schema::dropIfExists('budget_plans');
    }
};