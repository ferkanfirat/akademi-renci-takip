<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ogrenciler', function (Blueprint $table) {
            $table->id();

            // Program Bilgileri
            $table->unsignedBigInteger('sinif_id')->nullable()->index();
            $table->enum('program_turu', ['T1', 'T2', 'Y1', 'Y2', 'T3'])->index();
            $table->dateTime('kayit_tarihi')->index();
            $table->date('sinav_tarihi')->nullable()->index();

            // Kişisel Bilgiler
            $table->string('tc_kimlik_no', 11)->unique();
            $table->string('ad_soyad')->index();
            $table->date('dogum_tarihi');
            $table->string('kan_grubu', 10)->nullable();
            $table->date('ogg_kimlik_bitis_tarihi')->nullable()->index();

            // Çalışma Bilgileri
            $table->unsignedBigInteger('halen_calistigi_firma_id')->nullable()->index();
            $table->string('halen_calistigi_proje')->nullable();
            $table->string('proje_ilcesi', 100)->nullable();

            // İletişim Bilgileri
            $table->string('ikamet_il', 100)->index();
            $table->string('ikamet_ilce', 100);
            $table->string('ogrenim_durumu', 100)->nullable();
            $table->string('cep_tel', 20)->index();
            $table->string('cep_tel2', 20)->nullable();
            $table->string('email')->index();
            $table->string('yakin_ad_soyad')->nullable();
            $table->json('bize_nasil_ulasti')->nullable();

            // Dosyalar
            $table->string('kimlik_fotograf_yolu', 500)->nullable();
            $table->string('profil_fotograf_yolu', 500)->nullable();

            // Durum
            $table->string('durum', 50)->index();
            $table->text('durum_notu')->nullable();
            $table->enum('kayit_kanali', ['Ofis', 'Web', 'Mobil']);

            // Ödeme Bilgileri
            $table->decimal('toplam_bedel', 10, 2);
            $table->decimal('odenen_bedel', 10, 2);
            $table->decimal('kalan_bedel', 10, 2);
            $table->date('kalan_odeme_tarihi')->nullable()->index();
            $table->boolean('harc_kurumsal_odeyecek')->default(false);
            $table->string('odeme_sekli', 50)->nullable();

            // Fatura Bilgileri
            $table->boolean('kurumsal_fatura')->default(false);
            $table->string('fatura_unvani')->nullable();
            $table->string('vergi_no', 20)->nullable();
            $table->string('vergi_dairesi', 100)->nullable();
            $table->text('fatura_adresi')->nullable();

            // İndirim
            $table->boolean('indirim_uygulandi')->default(false);
            $table->text('indirim_aciklama')->nullable();

            // Harç Hakları (6 adet)
            $table->date('harc1_tarihi')->nullable();
            $table->string('harc1_durumu', 50)->nullable();
            $table->date('harc2_tarihi')->nullable();
            $table->string('harc2_durumu', 50)->nullable();
            $table->date('harc3_tarihi')->nullable();
            $table->string('harc3_durumu', 50)->nullable();
            $table->date('harc4_tarihi')->nullable();
            $table->string('harc4_durumu', 50)->nullable();
            $table->date('harc5_tarihi')->nullable();
            $table->string('harc5_durumu', 50)->nullable();
            $table->date('harc6_tarihi')->nullable();
            $table->string('harc6_durumu', 50)->nullable();

            // KVKK
            $table->boolean('kvkk_onay')->default(false);
            $table->dateTime('kvkk_onay_tarihi')->nullable();
            $table->string('kvkk_onay_ip', 45)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('sinif_id')
                  ->references('id')
                  ->on('siniflar')
                  ->onDelete('set null');

            $table->foreign('halen_calistigi_firma_id')
                  ->references('id')
                  ->on('firmalar')
                  ->onDelete('set null');
        });

        // Add foreign key to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('ogrenci_id')
                  ->references('id')
                  ->on('ogrenciler')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ogrenci_id']);
        });

        Schema::dropIfExists('ogrenciler');
    }
};
