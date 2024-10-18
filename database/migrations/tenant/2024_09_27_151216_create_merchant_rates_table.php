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
        Schema::create('merchant_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_type_id')->comment('支付方式');
            $table->unsignedBigInteger('merchant_id')->comment('商户');
            $table->unsignedDecimal('rate', 7, 6)->comment('商户费率');
            $table->unsignedDecimal('platform_rate', 7, 6)->comment('平台利润费率');
            $table->unsignedDecimal('rebate', 7, 6)->comment('回扣');
            $table->boolean('is_open_for_business')->default(1)->comment('是否营业');
            $table->string('valid_amount');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['merchant_id', 'payment_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_rates');
    }
};
