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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['admin', 'ogrenci'])->index();
            $table->unsignedBigInteger('ogrenci_id')->nullable()->unique();
            $table->string('username')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('cep_tel', 20)->nullable()->index();
            $table->string('password')->nullable();
            $table->string('role', 50)->index();
            $table->boolean('aktif_mi')->default(true)->index();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('cep_tel_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
