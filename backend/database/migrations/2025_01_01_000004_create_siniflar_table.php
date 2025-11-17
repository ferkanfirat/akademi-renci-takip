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
        Schema::create('siniflar', function (Blueprint $table) {
            $table->id();
            $table->string('sinif_kodu', 50)->unique();
            $table->string('sinif_adi');
            $table->enum('program_turu', ['T1', 'T2', 'Y1', 'Y2', 'T3'])->index();
            $table->integer('kontenjan');
            $table->integer('mevcut_ogrenci_sayisi')->default(0);
            $table->date('baslangic_tarihi')->index();
            $table->date('bitis_tarihi')->nullable()->index();
            $table->string('durum', 50)->index();
            $table->unsignedBigInteger('sorumlu_egitmen_id')->nullable();
            $table->string('yer')->nullable();
            $table->text('aciklama')->nullable();
            $table->timestamps();

            $table->foreign('sorumlu_egitmen_id')
                  ->references('id')
                  ->on('egitmenler')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siniflar');
    }
};
