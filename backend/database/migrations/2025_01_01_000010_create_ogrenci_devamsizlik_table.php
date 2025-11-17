<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ogrenci_devamsizlik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ogrenci_id')->index();
            $table->unsignedBigInteger('ders_programi_id')->index();
            $table->boolean('devamsiz_mi');
            $table->integer('gecikme_dakika')->nullable();
            $table->text('aciklama')->nullable();
            $table->unsignedBigInteger('kaydeden_admin_id');
            $table->timestamps();

            $table->foreign('ogrenci_id')
                  ->references('id')
                  ->on('ogrenciler')
                  ->onDelete('cascade');

            $table->foreign('ders_programi_id')
                  ->references('id')
                  ->on('ders_programlari')
                  ->onDelete('cascade');

            $table->foreign('kaydeden_admin_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ogrenci_devamsizlik');
    }
};
