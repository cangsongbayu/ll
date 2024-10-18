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
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('名称');
            $table->string('code')->unique()->comment('标识');
            $table->string('valid_amount')->comment('订单有效金额');
            $table->unsignedMediumInteger('order_ttl')->comment('订单有效时长');
            $table->string('business_hours')->comment('营业时间');
            $table->boolean('is_open_for_business')->default(1)->comment('是否营业');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_types');
    }
};
