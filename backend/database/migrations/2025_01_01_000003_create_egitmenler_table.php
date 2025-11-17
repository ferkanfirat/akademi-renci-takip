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
        Schema::create('egitmenler', function (Blueprint $table) {
            $table->id();
            $table->string('tc_kimlik_no', 11)->unique();
            $table->string('ad_soyad')->index();
            $table->date('dogum_tarihi')->nullable();
            $table->string('cep_tel', 20);
            $table->string('email')->nullable();
            $table->json('branslar')->nullable();
            $table->string('uzmanlik_alani')->nullable();
            $table->boolean('aktif_mi')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egitmenler');
    }
};
