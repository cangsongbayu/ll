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
        Schema::create('payment_service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_open_for_business')->default(1);
            $table->decimal('balance', 20, 6)->default(0);
            $table->decimal('deposit', 20, 6)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_service_providers');
    }
};
