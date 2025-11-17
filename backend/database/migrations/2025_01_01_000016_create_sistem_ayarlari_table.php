<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sistem_ayarlari', function (Blueprint $table) {
            $table->id();
            $table->string('ayar_anahtar', 100)->unique();
            $table->text('ayar_deger')->nullable();
            $table->string('ayar_tipi', 50);
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sistem_ayarlari');
    }
};
