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
        Schema::create('supplier_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_type_id')->comment('支付方式');
            $table->unsignedBigInteger('supplier_id')->comment('供应商');
            $table->unsignedDecimal('rate', 7, 6)->comment('供应商费率');
            $table->boolean('is_open_for_business')->default(1)->comment('是否营业');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['supplier_id', 'payment_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_rates');
    }
};
