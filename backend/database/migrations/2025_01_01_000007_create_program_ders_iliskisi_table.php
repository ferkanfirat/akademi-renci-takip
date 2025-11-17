<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_ders_iliskisi', function (Blueprint $table) {
            $table->id();
            $table->enum('program_turu', ['T1', 'T2', 'Y1', 'Y2', 'T3'])->index();
            $table->unsignedBigInteger('ders_id')->index();
            $table->boolean('zorunlu_mu')->default(true);
            $table->integer('sira')->nullable();
            $table->timestamps();

            $table->unique(['program_turu', 'ders_id']);

            $table->foreign('ders_id')
                  ->references('id')
                  ->on('dersler')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_ders_iliskisi');
    }
};
