<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ders_programlari', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sinif_id')->index();
            $table->unsignedBigInteger('ders_id')->index();
            $table->unsignedBigInteger('egitmen_id')->nullable()->index();
            $table->date('tarih')->index();
            $table->time('saat_baslangic');
            $table->time('saat_bitis');
            $table->string('yer')->nullable();
            $table->string('konu', 500)->nullable();
            $table->string('durum', 50)->index();
            $table->text('aciklama')->nullable();
            $table->timestamps();

            $table->foreign('sinif_id')
                  ->references('id')
                  ->on('siniflar')
                  ->onDelete('cascade');

            $table->foreign('ders_id')
                  ->references('id')
                  ->on('dersler')
                  ->onDelete('cascade');

            $table->foreign('egitmen_id')
                  ->references('id')
                  ->on('egitmenler')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ders_programlari');
    }
};
