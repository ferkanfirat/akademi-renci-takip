# VERİTABANI ŞEMASI - ÖZEL GÜVENLİK EĞİTİM MERKEZİ

## TABLOLAR VE İLİŞKİLER

### 1. ogrenciler (Ana öğrenci/kursiyer tablosu)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| sinif_id | BIGINT UNSIGNED | Atandığı sınıf | ✗ | FK, Index |
| program_turu | ENUM('T1','T2','Y1','Y2','T3') | Kurs tipi | ✓ | Index |
| kayit_tarihi | DATETIME | Kayıt tarihi | ✓ | Index |
| sinav_tarihi | DATE | Planlanan sınav tarihi | ✗ | Index |
| tc_kimlik_no | VARCHAR(11) | TC Kimlik No | ✓ | UNIQUE |
| ad_soyad | VARCHAR(255) | Ad Soyad | ✓ | Index |
| dogum_tarihi | DATE | Doğum tarihi | ✓ | - |
| kan_grubu | VARCHAR(10) | Kan grubu | ✗ | - |
| ogg_kimlik_bitis_tarihi | DATE | ÖGG kimlik bitiş (Y1/Y2/T3) | ✗ | Index |
| halen_calistigi_firma_id | BIGINT UNSIGNED | Firma referansı | ✗ | FK, Index |
| halen_calistigi_proje | VARCHAR(255) | Proje adı | ✗ | - |
| proje_ilcesi | VARCHAR(100) | Proje ilçesi | ✗ | - |
| ikamet_il | VARCHAR(100) | İkamet ili | ✓ | Index |
| ikamet_ilce | VARCHAR(100) | İkamet ilçesi | ✓ | - |
| ogrenim_durumu | VARCHAR(100) | Öğrenim durumu | ✗ | - |
| cep_tel | VARCHAR(20) | Cep telefonu | ✓ | Index |
| cep_tel2 | VARCHAR(20) | İkinci cep telefonu | ✗ | - |
| email | VARCHAR(255) | E-posta | ✓ | Index |
| yakin_ad_soyad | VARCHAR(255) | Yakın adı soyadı | ✗ | - |
| bize_nasil_ulasti | JSON | Ulaşım kanalları (çoklu seçim) | ✗ | - |
| kimlik_fotograf_yolu | VARCHAR(500) | Kimlik fotoğrafı path | ✗ | - |
| profil_fotograf_yolu | VARCHAR(500) | Profil fotoğrafı path | ✗ | - |
| durum | VARCHAR(50) | Öğrenci durumu | ✓ | Index |
| durum_notu | TEXT | Durum açıklaması | ✗ | - |
| kayit_kanali | ENUM('Ofis','Web','Mobil') | Kayıt kanalı | ✓ | - |
| toplam_bedel | DECIMAL(10,2) | Toplam ücret | ✓ | - |
| odenen_bedel | DECIMAL(10,2) | Ödenen tutar | ✓ | - |
| kalan_bedel | DECIMAL(10,2) | Kalan borç (computed) | ✓ | - |
| kalan_odeme_tarihi | DATE | Son ödeme tarihi | ✗ | Index |
| harc_kurumsal_odeyecek | BOOLEAN | Kurumsal harç ödemesi | ✓ | - |
| odeme_sekli | VARCHAR(50) | Ödeme şekli | ✗ | - |
| kurumsal_fatura | BOOLEAN | Kurumsal fatura? | ✓ | - |
| fatura_unvani | VARCHAR(255) | Fatura ünvanı | ✗ | - |
| vergi_no | VARCHAR(20) | Vergi numarası | ✗ | - |
| vergi_dairesi | VARCHAR(100) | Vergi dairesi | ✗ | - |
| fatura_adresi | TEXT | Fatura adresi | ✗ | - |
| indirim_uygulandi | BOOLEAN | İndirim var mı? | ✓ | - |
| indirim_aciklama | TEXT | İndirim açıklaması | ✗ | - |
| harc1_tarihi | DATE | 1. Harç tarihi | ✗ | - |
| harc1_durumu | VARCHAR(50) | 1. Harç durumu | ✗ | - |
| harc2_tarihi | DATE | 2. Harç tarihi | ✗ | - |
| harc2_durumu | VARCHAR(50) | 2. Harç durumu | ✗ | - |
| harc3_tarihi | DATE | 3. Harç tarihi | ✗ | - |
| harc3_durumu | VARCHAR(50) | 3. Harç durumu | ✗ | - |
| harc4_tarihi | DATE | 4. Harç tarihi | ✗ | - |
| harc4_durumu | VARCHAR(50) | 4. Harç durumu | ✗ | - |
| harc5_tarihi | DATE | 5. Harç tarihi | ✗ | - |
| harc5_durumu | VARCHAR(50) | 5. Harç durumu | ✗ | - |
| harc6_tarihi | DATE | 6. Harç tarihi | ✗ | - |
| harc6_durumu | VARCHAR(50) | 6. Harç durumu | ✗ | - |
| kvkk_onay | BOOLEAN | KVKK onayı | ✓ | - |
| kvkk_onay_tarihi | DATETIME | KVKK onay tarihi | ✗ | - |
| kvkk_onay_ip | VARCHAR(45) | KVKK onay IP | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |
| deleted_at | TIMESTAMP | Soft delete | ✗ | Index |

**Durum Değerleri:**
- `Kayıt Alındı`
- `Evrak Tamamlandı`
- `Eğitimde`
- `Sınavda`
- `Sınav Başarılı`
- `Sınav Başarısız`
- `Kimlik Başvurusu`
- `Kimlik Geldi`
- `Göreve Başladı`
- `Yenileme Zamanı Yaklaşmış`
- `Pasif`

---

### 2. firmalar (Çalışılan firmalar listesi)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| firma_adi | VARCHAR(255) | Firma adı | ✓ | Index |
| il | VARCHAR(100) | İl | ✗ | - |
| ilce | VARCHAR(100) | İlçe | ✗ | - |
| vergi_no | VARCHAR(20) | Vergi numarası | ✗ | - |
| vergi_dairesi | VARCHAR(100) | Vergi dairesi | ✗ | - |
| adres | TEXT | Adres | ✗ | - |
| telefon | VARCHAR(20) | Telefon | ✗ | - |
| email | VARCHAR(255) | E-posta | ✗ | - |
| aktif_mi | BOOLEAN | Aktif durumu | ✓ | Index |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

---

### 3. siniflar (Eğitim sınıfları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| sinif_kodu | VARCHAR(50) | Sınıf kodu (411, 910 vb.) | ✓ | UNIQUE |
| sinif_adi | VARCHAR(255) | Sınıf adı | ✓ | - |
| program_turu | ENUM('T1','T2','Y1','Y2','T3') | Program türü | ✓ | Index |
| kontenjan | INT | Maksimum kontenjan | ✓ | - |
| mevcut_ogrenci_sayisi | INT | Güncel öğrenci sayısı | ✓ | - |
| baslangic_tarihi | DATE | Başlangıç tarihi | ✓ | Index |
| bitis_tarihi | DATE | Bitiş tarihi | ✗ | Index |
| durum | VARCHAR(50) | Sınıf durumu | ✓ | Index |
| sorumlu_egitmen_id | BIGINT UNSIGNED | Sorumlu eğitmen | ✗ | FK |
| yer | VARCHAR(255) | Eğitim yeri | ✗ | - |
| aciklama | TEXT | Açıklama | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

**Durum Değerleri:**
- `Açık` (Kayıt kabul ediyor)
- `Devam Ediyor` (Eğitim başladı)
- `Tamamlandı` (Eğitim bitti)
- `İptal` (İptal edildi)

---

### 4. dersler (Ders tanımları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| ders_kodu | VARCHAR(50) | Ders kodu | ✓ | UNIQUE |
| ders_adi | VARCHAR(255) | Ders adı | ✓ | Index |
| silahli_mi | BOOLEAN | Silahlı program için mi? | ✓ | Index |
| teorik_saat | INT | Teorik ders saati | ✓ | - |
| uygulama_saat | INT | Uygulama saati | ✓ | - |
| toplam_saat | INT | Toplam saat | ✓ | - |
| aciklama | TEXT | Ders açıklaması | ✗ | - |
| aktif_mi | BOOLEAN | Aktif durumu | ✓ | Index |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

---

### 5. program_ders_iliskisi (Program türü - ders ilişkisi)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| program_turu | ENUM('T1','T2','Y1','Y2','T3') | Program türü | ✓ | Index |
| ders_id | BIGINT UNSIGNED | Ders referansı | ✓ | FK |
| zorunlu_mu | BOOLEAN | Zorunlu ders mi? | ✓ | - |
| sira | INT | Ders sırası | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

**UNIQUE KEY:** (program_turu, ders_id)

---

### 6. ders_programlari (Sınıf bazlı ders programı)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| sinif_id | BIGINT UNSIGNED | Sınıf referansı | ✓ | FK, Index |
| ders_id | BIGINT UNSIGNED | Ders referansı | ✓ | FK, Index |
| egitmen_id | BIGINT UNSIGNED | Eğitmen referansı | ✗ | FK, Index |
| tarih | DATE | Ders tarihi | ✓ | Index |
| saat_baslangic | TIME | Başlangıç saati | ✓ | - |
| saat_bitis | TIME | Bitiş saati | ✓ | - |
| yer | VARCHAR(255) | Ders yeri (sınıf/poligon) | ✗ | - |
| konu | VARCHAR(500) | Ders konusu | ✗ | - |
| durum | VARCHAR(50) | Ders durumu | ✓ | Index |
| aciklama | TEXT | Açıklama | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

**Durum Değerleri:**
- `Planlandı`
- `Tamamlandı`
- `İptal`
- `Ertelendi`

---

### 7. egitmenler (Eğitmenler)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| tc_kimlik_no | VARCHAR(11) | TC Kimlik No | ✓ | UNIQUE |
| ad_soyad | VARCHAR(255) | Ad Soyad | ✓ | Index |
| dogum_tarihi | DATE | Doğum tarihi | ✗ | - |
| cep_tel | VARCHAR(20) | Cep telefonu | ✓ | - |
| email | VARCHAR(255) | E-posta | ✗ | - |
| branslar | JSON | Branşlar (çoklu) | ✗ | - |
| uzmanlik_alani | VARCHAR(255) | Uzmanlık alanı | ✗ | - |
| aktif_mi | BOOLEAN | Aktif durumu | ✓ | Index |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

---

### 8. ogrenci_evraklari (Öğrenci evrak takibi)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| ogrenci_id | BIGINT UNSIGNED | Öğrenci referansı | ✓ | FK, Index |
| evrak_tipi | VARCHAR(100) | Evrak tipi | ✓ | Index |
| durum | VARCHAR(50) | Evrak durumu | ✓ | Index |
| dosya_yolu | VARCHAR(500) | Dosya yolu | ✗ | - |
| yukleme_tarihi | DATETIME | Yükleme tarihi | ✗ | - |
| onaylayan_admin_id | BIGINT UNSIGNED | Onaylayan admin | ✗ | FK |
| onay_tarihi | DATETIME | Onay tarihi | ✗ | - |
| ret_nedeni | TEXT | Red nedeni | ✗ | - |
| aciklama | TEXT | Açıklama | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

**Evrak Tipleri:**
- `temel_nufus_fotokopi`
- `temel_resim`
- `temel_saglik_raporu`
- `temel_diploma`
- `yenileme_nufus_fotokopi`
- `yenileme_resim`
- `yenileme_ogg_kimlik_fotokopi`
- `yenileme_saglik_raporu`

**Durum Değerleri:**
- `Yok`
- `Yüklendi`
- `Onaylandı`
- `Reddedildi`
- `Eksik`

---

### 9. ogrenci_devamsizlik (Devamsızlık kayıtları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| ogrenci_id | BIGINT UNSIGNED | Öğrenci referansı | ✓ | FK, Index |
| ders_programi_id | BIGINT UNSIGNED | Ders programı referansı | ✓ | FK, Index |
| devamsiz_mi | BOOLEAN | Devamsız mı? | ✓ | - |
| gecikme_dakika | INT | Gecikmesi (dakika) | ✗ | - |
| aciklama | TEXT | Açıklama | ✗ | - |
| kaydeden_admin_id | BIGINT UNSIGNED | Kaydeden admin | ✓ | FK |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

---

### 10. ogrenci_notlar (Admin notları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| ogrenci_id | BIGINT UNSIGNED | Öğrenci referansı | ✓ | FK, Index |
| yazar_admin_id | BIGINT UNSIGNED | Yazan admin | ✓ | FK |
| icerik | TEXT | Not içeriği | ✓ | - |
| onem_durumu | VARCHAR(50) | Önem derecesi | ✓ | Index |
| kategori | VARCHAR(100) | Not kategorisi | ✗ | Index |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | Index |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

**Önem Durumu:**
- `Normal`
- `Önemli`
- `Kritik`

---

### 11. odemeler (Ödeme kayıtları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| ogrenci_id | BIGINT UNSIGNED | Öğrenci referansı | ✓ | FK, Index |
| odeme_tarihi | DATETIME | Ödeme tarihi | ✓ | Index |
| tutar | DECIMAL(10,2) | Ödeme tutarı | ✓ | - |
| odeme_sekli | VARCHAR(50) | Ödeme şekli | ✓ | - |
| odeme_tipi | VARCHAR(50) | Ödeme tipi | ✓ | Index |
| aciklama | TEXT | Açıklama | ✗ | - |
| kaydeden_admin_id | BIGINT UNSIGNED | Kaydeden admin | ✓ | FK |
| dekont_yolu | VARCHAR(500) | Dekont dosya yolu | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

**Ödeme Tipi:**
- `Kayıt Ücreti`
- `Taksit`
- `Harç`
- `Diğer`

---

### 12. sinavlar (Sınav kayıtları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| sinif_id | BIGINT UNSIGNED | Sınıf referansı | ✓ | FK, Index |
| sinav_tarihi | DATE | Sınav tarihi | ✓ | Index |
| sinav_saati | TIME | Sınav saati | ✗ | - |
| sinav_yeri | VARCHAR(255) | Sınav yeri | ✗ | - |
| sinav_turu | VARCHAR(100) | Sınav türü | ✓ | - |
| aciklama | TEXT | Açıklama | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

---

### 13. sinav_sonuclari (Öğrenci sınav sonuçları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| sinav_id | BIGINT UNSIGNED | Sınav referansı | ✓ | FK, Index |
| ogrenci_id | BIGINT UNSIGNED | Öğrenci referansı | ✓ | FK, Index |
| puan | DECIMAL(5,2) | Sınav puanı | ✗ | - |
| sonuc | VARCHAR(50) | Sonuç (Başarılı/Başarısız) | ✗ | Index |
| katildi_mi | BOOLEAN | Sınava katıldı mı? | ✓ | - |
| aciklama | TEXT | Açıklama | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

---

### 14. users (Sistem kullanıcıları - Admin ve öğrenciler)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| user_type | ENUM('admin','ogrenci') | Kullanıcı tipi | ✓ | Index |
| ogrenci_id | BIGINT UNSIGNED | Öğrenci referansı (öğrenci ise) | ✗ | FK, UNIQUE |
| username | VARCHAR(255) | Kullanıcı adı (admin için) | ✗ | UNIQUE |
| email | VARCHAR(255) | E-posta | ✓ | UNIQUE |
| cep_tel | VARCHAR(20) | Cep telefonu | ✗ | Index |
| password | VARCHAR(255) | Şifre hash (admin için) | ✗ | - |
| role | VARCHAR(50) | Rol | ✓ | Index |
| aktif_mi | BOOLEAN | Aktif durumu | ✓ | Index |
| last_login_at | DATETIME | Son giriş | ✗ | - |
| email_verified_at | DATETIME | E-posta doğrulama | ✗ | - |
| cep_tel_verified_at | DATETIME | Telefon doğrulama | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

**Roller:**
- `super_admin` (Tam yetki)
- `admin` (Standart yönetici)
- `egitmen` (Eğitmen yetkisi)
- `ogrenci` (Öğrenci)

---

### 15. otp_codes (Tek kullanımlık şifreler)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| email | VARCHAR(255) | E-posta | ✗ | Index |
| cep_tel | VARCHAR(20) | Cep telefonu | ✗ | Index |
| code | VARCHAR(10) | OTP kodu | ✓ | - |
| purpose | VARCHAR(50) | Amaç (login/register) | ✓ | - |
| expires_at | DATETIME | Geçerlilik süresi | ✓ | Index |
| used_at | DATETIME | Kullanım zamanı | ✗ | - |
| ip_address | VARCHAR(45) | IP adresi | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |

---

### 16. sistem_ayarlari (Sistem ayarları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| ayar_anahtar | VARCHAR(100) | Ayar anahtarı | ✓ | UNIQUE |
| ayar_deger | TEXT | Ayar değeri | ✗ | - |
| ayar_tipi | VARCHAR(50) | Veri tipi | ✓ | - |
| aciklama | TEXT | Açıklama | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | - |
| updated_at | TIMESTAMP | Güncelleme zamanı | ✓ | - |

**Örnek Ayarlar:**
- `kvkk_metni`
- `aydinlatma_metni`
- `temel_kurs_ucreti_t1`
- `temel_kurs_ucreti_t2`
- `yenileme_kurs_ucreti_y1`
- `yenileme_kurs_ucreti_y2`
- `gecis_kurs_ucreti_t3`
- `sms_api_key`
- `email_smtp_settings`

---

### 17. activity_logs (Aktivite logları)

| Alan Adı | Tip | Açıklama | Zorunlu | Index |
|----------|-----|----------|---------|-------|
| id | BIGINT UNSIGNED | Primary Key | ✓ | PK |
| user_id | BIGINT UNSIGNED | Kullanıcı referansı | ✗ | FK, Index |
| action | VARCHAR(100) | Yapılan işlem | ✓ | Index |
| model_type | VARCHAR(100) | Model tipi | ✗ | Index |
| model_id | BIGINT UNSIGNED | Model ID | ✗ | Index |
| ip_address | VARCHAR(45) | IP adresi | ✗ | - |
| user_agent | TEXT | User agent | ✗ | - |
| changes | JSON | Değişiklikler | ✗ | - |
| created_at | TIMESTAMP | Oluşturma zamanı | ✓ | Index |

---

## İLİŞKİLER (FOREIGN KEYS)

```
ogrenciler.sinif_id → siniflar.id
ogrenciler.halen_calistigi_firma_id → firmalar.id

siniflar.sorumlu_egitmen_id → egitmenler.id

program_ders_iliskisi.ders_id → dersler.id

ders_programlari.sinif_id → siniflar.id
ders_programlari.ders_id → dersler.id
ders_programlari.egitmen_id → egitmenler.id

ogrenci_evraklari.ogrenci_id → ogrenciler.id
ogrenci_evraklari.onaylayan_admin_id → users.id

ogrenci_devamsizlik.ogrenci_id → ogrenciler.id
ogrenci_devamsizlik.ders_programi_id → ders_programlari.id
ogrenci_devamsizlik.kaydeden_admin_id → users.id

ogrenci_notlar.ogrenci_id → ogrenciler.id
ogrenci_notlar.yazar_admin_id → users.id

odemeler.ogrenci_id → ogrenciler.id
odemeler.kaydeden_admin_id → users.id

sinavlar.sinif_id → siniflar.id

sinav_sonuclari.sinav_id → sinavlar.id
sinav_sonuclari.ogrenci_id → ogrenciler.id

users.ogrenci_id → ogrenciler.id

activity_logs.user_id → users.id
```

---

## COMPUTED FIELDS (Hesaplanan Alanlar)

Bu alanlar API'de hesaplanarak döndürülür:

### ogrenciler tablosu için:
- `kalan_harc_hakki`: 6 - (kullanılan harç sayısı)
- `toplam_devamsizlik`: Devamsızlık kayıtlarından hesaplanır
- `tamamlanan_ders_saati`: Tamamlanan derslerden hesaplanır
- `gerekli_ders_saati`: Program türüne göre toplam gerekli saat
- `tamamlanma_yuzdesi`: (tamamlanan / gerekli) * 100
- `yasadisi_devamsizlik_mi`: Devamsızlık %20'yi aşıyor mu?

### siniflar tablosu için:
- `doluluk_yuzdesi`: (mevcut_ogrenci_sayisi / kontenjan) * 100
- `kalan_kontenjan`: kontenjan - mevcut_ogrenci_sayisi

---

## INDEX STRATEJISI

**Sık Sorgulanan Alanlar:**
- tc_kimlik_no (UNIQUE, sık arama)
- email, cep_tel (login için)
- durum (filtreleme)
- kayit_tarihi, sinav_tarihi (tarih bazlı sorgular)
- program_turu (gruplama)
- sinif_id (join işlemleri)

**Composite Index'ler:**
- (program_turu, durum) - Dashboard sorguları için
- (sinif_id, tarih) - Ders programı sorguları için
- (ogrenci_id, created_at) - Öğrenci geçmişi için

---

## VERİ BÜTÜNLÜĞÜ KURALLARI

1. **Cascade Delete:**
   - Öğrenci silinirse → Tüm ilişkili kayıtlar soft delete
   - Sınıf silinirse → Öğrenciler ilişkisi NULL yapılır (koruma amaçlı)

2. **Validasyonlar:**
   - TC Kimlik No: 11 haneli, numerik
   - E-posta: RFC 5322 standartlarına uygun
   - Cep Tel: 10-11 haneli, numerik
   - Tarihler: Mantıksal kontroller (bitiş > başlangıç)
   - Ödeme: kalan_bedel = toplam_bedel - odenen_bedel

3. **Trigger'lar:**
   - Öğrenci kaydedildiğinde → User tablosuna otomatik kayıt
   - Ödeme kaydedildiğinde → ogrenciler.odenen_bedel güncellenir
   - Sınıfa öğrenci eklendiğinde → siniflar.mevcut_ogrenci_sayisi artırılır

---

## VERİ MİGRASYONU VE SEED

**Başlangıç verileri:**
1. Firmalar listesi (Excel'den import)
2. Sistem ayarları (default değerler)
3. Ders tanımları (program türlerine göre)
4. Program-Ders ilişkileri
5. Super admin kullanıcısı

