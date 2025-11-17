<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dersler', function (Blueprint $table) {
            $table->id();
            $table->string('ders_kodu', 50)->unique();
            $table->string('ders_adi')->index();
            $table->boolean('silahli_mi')->index();
            $table->integer('teorik_saat');
            $table->integer('uygulama_saat');
            $table->integer('toplam_saat');
            $table->text('aciklama')->nullable();
            $table->boolean('aktif_mi')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dersler');
    }
};
