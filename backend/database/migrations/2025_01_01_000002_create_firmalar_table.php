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
        Schema::create('firmalar', function (Blueprint $table) {
            $table->id();
            $table->string('firma_adi')->index();
            $table->string('il', 100)->nullable();
            $table->string('ilce', 100)->nullable();
            $table->string('vergi_no', 20)->nullable();
            $table->string('vergi_dairesi', 100)->nullable();
            $table->text('adres')->nullable();
            $table->string('telefon', 20)->nullable();
            $table->string('email')->nullable();
            $table->boolean('aktif_mi')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firmalar');
    }
};
