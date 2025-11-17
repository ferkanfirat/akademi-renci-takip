<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sinav_sonuclari', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sinav_id')->index();
            $table->unsignedBigInteger('ogrenci_id')->index();
            $table->decimal('puan', 5, 2)->nullable();
            $table->string('sonuc', 50)->nullable()->index();
            $table->boolean('katildi_mi');
            $table->text('aciklama')->nullable();
            $table->timestamps();

            $table->foreign('sinav_id')
                  ->references('id')
                  ->on('sinavlar')
                  ->onDelete('cascade');

            $table->foreign('ogrenci_id')
                  ->references('id')
                  ->on('ogrenciler')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sinav_sonuclari');
    }
};
