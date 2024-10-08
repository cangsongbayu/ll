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
        Schema::create('collection_method_types', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type_ids')->comment('对应的付款方式 ID');
            $table->string('name')->unique();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_method_types');
    }
};
