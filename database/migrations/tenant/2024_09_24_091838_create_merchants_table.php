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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('appid')->unique();
            $table->string('name')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedSmallInteger('max_token_count')->default(1);
            $table->boolean('is_enable_tfa')->default(0);
            $table->string('tfa_secret')->nullable();
            $table->string('allowed_ip_addresses')->nullable();
            $table->boolean('is_open_for_business')->default(1);
            $table->decimal('balance', 20, 6)->default(0);
            $table->decimal('deposit', 20, 6)->default(0);
            $table->decimal('prepayment', 20, 6)->default(0);
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
