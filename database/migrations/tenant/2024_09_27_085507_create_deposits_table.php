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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->morphs('depositable');
            $table->string('trade_no')->unique();
            $table->unsignedBigInteger('currency_id')->comment('订单货币');
            $table->decimal('amount', 20, 6)->comment('订单金额');
            $table->decimal('exchange_rate', 20, 6)->unsigned()->comment('汇率');
            $table->unsignedBigInteger('base_currency_id')->comment('基准货币');
            $table->decimal('base_amount', 20, 6)->comment('基准货币订单金额');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
