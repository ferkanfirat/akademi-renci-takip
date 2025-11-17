<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('odemeler', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ogrenci_id')->index();
            $table->dateTime('odeme_tarihi')->index();
            $table->decimal('tutar', 10, 2);
            $table->string('odeme_sekli', 50);
            $table->string('odeme_tipi', 50)->index();
            $table->text('aciklama')->nullable();
            $table->unsignedBigInteger('kaydeden_admin_id');
            $table->string('dekont_yolu', 500)->nullable();
            $table->timestamps();

            $table->foreign('ogrenci_id')
                  ->references('id')
                  ->on('ogrenciler')
                  ->onDelete('cascade');

            $table->foreign('kaydeden_admin_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('odemeler');
    }
};
