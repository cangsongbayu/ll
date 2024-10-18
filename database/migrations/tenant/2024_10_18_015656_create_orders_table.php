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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('payment_channel_id')->nullable();
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('collection_method_id')->nullable();
            $table->string('trade_no');
            $table->string('out_trade_no');
            $table->unsignedSmallInteger('status');
            $table->decimal('amount', 20, 6);
            $table->decimal('paid_amount', 20, 6);
            $table->datetime('paid_at')->nullable();
            $table->datetime('cancel_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
