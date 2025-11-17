<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ogrenci_notlar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ogrenci_id')->index();
            $table->unsignedBigInteger('yazar_admin_id');
            $table->text('icerik');
            $table->string('onem_durumu', 50)->index();
            $table->string('kategori', 100)->nullable()->index();
            $table->timestamps();

            $table->foreign('ogrenci_id')
                  ->references('id')
                  ->on('ogrenciler')
                  ->onDelete('cascade');

            $table->foreign('yazar_admin_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ogrenci_notlar');
    }
};
