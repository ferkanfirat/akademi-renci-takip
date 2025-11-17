<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sinavlar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sinif_id')->index();
            $table->date('sinav_tarihi')->index();
            $table->time('sinav_saati')->nullable();
            $table->string('sinav_yeri')->nullable();
            $table->string('sinav_turu', 100);
            $table->text('aciklama')->nullable();
            $table->timestamps();

            $table->foreign('sinif_id')
                  ->references('id')
                  ->on('siniflar')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sinavlar');
    }
};
