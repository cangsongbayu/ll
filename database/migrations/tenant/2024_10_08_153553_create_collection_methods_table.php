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
        Schema::create('collection_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collection_method_type_id');
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('name')->unique();
            $table->unsignedDecimal('daily_limit', 10, 2)->default(0)->comment('收款限额');
            $table->unsignedMediumInteger('daily_transaction_limit')->default(0)->comment('收款次数限制');
            $table->boolean('is_open_for_business')->default(0);
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_methods');
    }
};
