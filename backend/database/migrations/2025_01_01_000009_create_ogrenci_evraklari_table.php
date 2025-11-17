<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ogrenci_evraklari', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ogrenci_id')->index();
            $table->string('evrak_tipi', 100)->index();
            $table->string('durum', 50)->index();
            $table->string('dosya_yolu', 500)->nullable();
            $table->dateTime('yukleme_tarihi')->nullable();
            $table->unsignedBigInteger('onaylayan_admin_id')->nullable();
            $table->dateTime('onay_tarihi')->nullable();
            $table->text('ret_nedeni')->nullable();
            $table->text('aciklama')->nullable();
            $table->timestamps();

            $table->foreign('ogrenci_id')
                  ->references('id')
                  ->on('ogrenciler')
                  ->onDelete('cascade');

            $table->foreign('onaylayan_admin_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ogrenci_evraklari');
    }
};
