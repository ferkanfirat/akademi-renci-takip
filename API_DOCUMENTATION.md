# API DOKÜMANTASYONU - ÖZEL GÜVENLİK EĞİTİM SİSTEMİ

## BASE URL
```
Production: https://yourdomain.com/api/v1
Development: http://localhost:8000/api/v1
```

## AUTHENTICATION

### Öğrenci Girişi (OTP Tabanlı)

#### 1. OTP İsteği
```http
POST /auth/ogrenci/otp-request
Content-Type: application/json

{
  "cep_tel": "5551234567",
  "email": "ornek@email.com"
}

Response 200:
{
  "success": true,
  "message": "OTP kodu gönderildi",
  "expires_in": 300
}
```

#### 2. OTP Doğrulama ve Giriş
```http
POST /auth/ogrenci/otp-verify
Content-Type: application/json

{
  "cep_tel": "5551234567",
  "email": "ornek@email.com",
  "code": "123456"
}

Response 200:
{
  "success": true,
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "token_type": "Bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "user_type": "ogrenci",
    "email": "ornek@email.com",
    "ogrenci": {
      "id": 123,
      "tc_kimlik_no": "12345678901",
      "ad_soyad": "Ahmet Yılmaz",
      "program_turu": "T1",
      "durum": "Eğitimde"
    }
  }
}
```

### Admin Girişi (Klasik Username/Password)

```http
POST /auth/admin/login
Content-Type: application/json

{
  "username": "admin@akademi.com",
  "password": "secure_password"
}

Response 200:
{
  "success": true,
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "token_type": "Bearer",
  "expires_in": 7200,
  "user": {
    "id": 1,
    "user_type": "admin",
    "username": "admin",
    "email": "admin@akademi.com",
    "role": "super_admin"
  }
}
```

### Çıkış
```http
POST /auth/logout
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "message": "Çıkış yapıldı"
}
```

### Token Yenileme
```http
POST /auth/refresh
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "token": "new_token_here...",
  "expires_in": 3600
}
```

---

## ÖĞRENCİ KAYIT SÜRECİ

### 1. Program Türlerini Listele
```http
GET /kayit/program-turleri

Response 200:
{
  "success": true,
  "data": [
    {
      "kod": "T1",
      "ad": "Temel Silahlı",
      "aciklama": "İlk kez gelen, silahlı eğitim",
      "silahli": true,
      "ucret": 5000.00,
      "sure_gun": 120
    },
    {
      "kod": "T2",
      "ad": "Temel Silahsız",
      "aciklama": "İlk kez gelen, silahsız eğitim",
      "silahli": false,
      "ucret": 4000.00,
      "sure_gun": 90
    },
    // ... diğer programlar
  ]
}
```

### 2. Sınav Tarihlerini Listele
```http
GET /kayit/sinav-tarihleri?program_turu=T1

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "tarih": "2025-12-15",
      "sinav_yeri": "Ankara Sınav Merkezi",
      "kontenjan": 100,
      "dolu_kontenjan": 45
    },
    // ... diğer tarihler
  ]
}
```

### 3. Firmaları Listele
```http
GET /kayit/firmalar?aktif=true&search=güvenlik

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "firma_adi": "ABC Güvenlik A.Ş.",
      "il": "Ankara",
      "ilce": "Çankaya"
    },
    // ... diğer firmalar
  ]
}
```

### 4. KVKK Metni Al
```http
GET /kayit/kvkk-metni

Response 200:
{
  "success": true,
  "data": {
    "kvkk_metni": "...",
    "aydinlatma_metni": "...",
    "versiyon": "1.0",
    "guncelleme_tarihi": "2025-01-01"
  }
}
```

### 5. Kimlik Fotoğrafı Yükle
```http
POST /kayit/kimlik-fotograf-yukle
Content-Type: multipart/form-data
Authorization: Bearer {token} (Opsiyonel - misafir kayıt için)

{
  "kimlik_fotografi": <file>,
  "session_id": "unique_session_id" // Misafir kayıt için
}

Response 200:
{
  "success": true,
  "data": {
    "dosya_yolu": "/uploads/kimlik/2025/01/abc123.jpg",
    "dosya_url": "https://yourdomain.com/storage/kimlik/2025/01/abc123.jpg",
    "ocr_sonuc": { // Faz 2 için
      "tc_kimlik_no": "12345678901",
      "ad_soyad": "AHMET YILMAZ",
      "dogum_tarihi": "1990-05-15",
      "guven_skoru": 0.95
    }
  }
}
```

### 6. Yeni Öğrenci Kaydı Oluştur (Tam Kayıt)
```http
POST /kayit/ogrenci-kayit
Content-Type: application/json

{
  // Program Bilgileri
  "program_turu": "T1",
  "sinav_tarihi": "2025-12-15",

  // KVKK
  "kvkk_onay": true,

  // Kişisel Bilgiler
  "tc_kimlik_no": "12345678901",
  "ad_soyad": "Ahmet Yılmaz",
  "dogum_tarihi": "1990-05-15",
  "kan_grubu": "A+",
  "ogg_kimlik_bitis_tarihi": "2029-05-15", // Yalnızca Y1, Y2, T3 için
  "ogrenim_durumu": "Lise",

  // Çalışma Bilgileri
  "halen_calistigi_firma_id": 5,
  "halen_calistigi_proje": "Ankara AVM",
  "proje_ilcesi": "Çankaya",

  // İletişim Bilgileri
  "ikamet_il": "Ankara",
  "ikamet_ilce": "Çankaya",
  "cep_tel": "5551234567",
  "cep_tel2": "5559876543",
  "email": "ahmet@email.com",
  "yakin_ad_soyad": "Mehmet Yılmaz",

  // Ulaşım Kanalları
  "bize_nasil_ulasti": ["Google", "Arkadaş Tavsiyesi"],

  // Evrak
  "kimlik_fotograf_yolu": "/uploads/kimlik/2025/01/abc123.jpg",

  // Ödeme Bilgileri
  "toplam_bedel": 5000.00,
  "odenen_bedel": 2000.00,
  "kalan_odeme_tarihi": "2025-02-15",
  "harc_kurumsal_odeyecek": false,
  "odeme_sekli": "Nakit",

  // Fatura (Opsiyonel)
  "kurumsal_fatura": true,
  "fatura_unvani": "ABC Şirketi Ltd. Şti.",
  "vergi_no": "1234567890",
  "vergi_dairesi": "Çankaya",
  "fatura_adresi": "Ankara, Çankaya",

  // İndirim (Opsiyonel)
  "indirim_uygulandi": true,
  "indirim_aciklama": "%10 erken kayıt indirimi",

  // Kayıt Kanalı
  "kayit_kanali": "Web"
}

Response 201:
{
  "success": true,
  "message": "Kayıt başarıyla oluşturuldu",
  "data": {
    "ogrenci_id": 123,
    "ogrenci_no": "2025-T1-0123",
    "tc_kimlik_no": "12345678901",
    "ad_soyad": "Ahmet Yılmaz",
    "program_turu": "T1",
    "durum": "Kayıt Alındı",
    "login_credentials": {
      "email": "ahmet@email.com",
      "cep_tel": "5551234567",
      "message": "OTP ile giriş yapabilirsiniz"
    }
  }
}
```

---

## ÖĞRENCİ API'LERİ (Öğrenci Rolü İçin)

### Profil Bilgileri
```http
GET /ogrenci/profil
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "id": 123,
    "ogrenci_no": "2025-T1-0123",
    "tc_kimlik_no": "12345678901",
    "ad_soyad": "Ahmet Yılmaz",
    "dogum_tarihi": "1990-05-15",
    "kan_grubu": "A+",
    "program_turu": "T1",
    "program_turu_adi": "Temel Silahlı",
    "durum": "Eğitimde",
    "sinif": {
      "id": 10,
      "sinif_kodu": "411",
      "sinif_adi": "2025 Ocak Temel Silahlı",
      "baslangic_tarihi": "2025-01-15",
      "bitis_tarihi": "2025-05-15"
    },
    "iletisim": {
      "email": "ahmet@email.com",
      "cep_tel": "5551234567",
      "ikamet_il": "Ankara",
      "ikamet_ilce": "Çankaya"
    },
    "kimlik_fotograf_url": "https://...",
    "profil_fotograf_url": "https://...",
    "kayit_tarihi": "2025-01-10T10:30:00Z"
  }
}
```

### Ödeme Bilgileri
```http
GET /ogrenci/odeme-durumu
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "toplam_bedel": 5000.00,
    "odenen_bedel": 2000.00,
    "kalan_bedel": 3000.00,
    "kalan_odeme_tarihi": "2025-02-15",
    "odeme_gecikme_durumu": false,
    "odeme_gecikme_gun": 0,
    "odemeler": [
      {
        "id": 1,
        "tarih": "2025-01-10T11:00:00Z",
        "tutar": 2000.00,
        "odeme_sekli": "Nakit",
        "odeme_tipi": "Kayıt Ücreti",
        "aciklama": "İlk ödeme"
      }
    ]
  }
}
```

### Harç Hakkı Durumu
```http
GET /ogrenci/harc-hakki
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "toplam_hak": 6,
    "kullanilan_hak": 1,
    "kalan_hak": 5,
    "harclar": [
      {
        "sira": 1,
        "tarih": "2025-01-15",
        "durum": "Kullanıldı",
        "sinav_tarihi": "2025-12-15",
        "sonuc": "Beklemede"
      },
      {
        "sira": 2,
        "tarih": null,
        "durum": "Kullanılmadı",
        "sinav_tarihi": null,
        "sonuc": null
      }
      // ... diğer harçlar
    ]
  }
}
```

### Ders Programı
```http
GET /ogrenci/ders-programi
Authorization: Bearer {token}

Query Params:
- baslangic_tarihi (optional): 2025-01-15
- bitis_tarihi (optional): 2025-01-31

Response 200:
{
  "success": true,
  "data": {
    "sinif": {
      "id": 10,
      "sinif_kodu": "411",
      "sinif_adi": "2025 Ocak Temel Silahlı"
    },
    "program": [
      {
        "id": 100,
        "tarih": "2025-01-15",
        "gun": "Pazartesi",
        "saat_baslangic": "09:00:00",
        "saat_bitis": "12:00:00",
        "ders": {
          "id": 5,
          "ders_adi": "Özel Güvenlik Hukuku",
          "ders_kodu": "OGH101"
        },
        "egitmen": {
          "id": 3,
          "ad_soyad": "Dr. Mehmet Demir"
        },
        "yer": "A Blok Sınıf 101",
        "durum": "Planlandı"
      }
      // ... diğer dersler
    ],
    "ozet": {
      "toplam_ders_saati": 120,
      "tamamlanan_ders_saati": 30,
      "kalan_ders_saati": 90,
      "tamamlanma_yuzdesi": 25
    }
  }
}
```

### Devamsızlık Durumu
```http
GET /ogrenci/devamsizlik
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "toplam_ders": 40,
    "katildi": 38,
    "devamsiz": 2,
    "devamsizlik_yuzdesi": 5,
    "yasadisi_limit": 20,
    "yasadisi_devamsizlik_durumu": false,
    "detay": [
      {
        "id": 1,
        "tarih": "2025-01-20",
        "ders_adi": "Özel Güvenlik Hukuku",
        "devamsiz_mi": true,
        "gecikme_dakika": 0,
        "aciklama": "Mazeretsiz"
      }
      // ... diğer kayıtlar
    ]
  }
}
```

### Sınav Sonuçları
```http
GET /ogrenci/sinav-sonuclari
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "sinav": {
        "id": 10,
        "tarih": "2025-12-15",
        "sinav_yeri": "Ankara Sınav Merkezi",
        "sinav_turu": "Temel Eğitim Sınavı"
      },
      "katildi_mi": true,
      "puan": 85.50,
      "sonuc": "Başarılı",
      "aciklama": "Tebrikler!"
    }
  ]
}
```

### Evrak Yükleme
```http
POST /ogrenci/evrak-yukle
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "evrak_tipi": "temel_saglik_raporu",
  "dosya": <file>,
  "aciklama": "Sağlık raporu"
}

Response 200:
{
  "success": true,
  "message": "Evrak başarıyla yüklendi, admin onayı bekleniyor",
  "data": {
    "id": 15,
    "evrak_tipi": "temel_saglik_raporu",
    "durum": "Yüklendi",
    "dosya_url": "https://..."
  }
}
```

### Evrak Durumu
```http
GET /ogrenci/evrak-durumu
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "tum_evraklar_tamam": false,
    "evraklar": [
      {
        "evrak_tipi": "temel_nufus_fotokopi",
        "evrak_adi": "Nüfus Fotokopisi",
        "durum": "Onaylandı",
        "dosya_url": "https://...",
        "yukleme_tarihi": "2025-01-10T10:00:00Z",
        "onay_tarihi": "2025-01-11T14:30:00Z"
      },
      {
        "evrak_tipi": "temel_saglik_raporu",
        "evrak_adi": "Sağlık Raporu",
        "durum": "Eksik",
        "dosya_url": null,
        "yukleme_tarihi": null,
        "onay_tarihi": null
      }
      // ... diğer evraklar
    ]
  }
}
```

---

## ADMIN API'LERİ

### Dashboard İstatistikleri
```http
GET /admin/dashboard
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "aktif_sinif_sayisi": 5,
    "toplam_ogrenci": 450,
    "aktif_ogrenci": 380,
    "bekleyen_evrak": 23,
    "geciken_odeme": 15,
    "yaklasan_sinavlar": 2,
    "yaklasan_yenilemeler": 12,
    "kritik_notlar": 3,
    "bugun_dersler": 8,
    "program_dagilimi": {
      "T1": 150,
      "T2": 100,
      "Y1": 120,
      "Y2": 60,
      "T3": 20
    },
    "durum_dagilimi": {
      "Kayıt Alındı": 50,
      "Eğitimde": 300,
      "Sınavda": 30,
      "Tamamlandı": 70
    }
  }
}
```

### Öğrenci Listesi (Filtreleme + Pagination)
```http
GET /admin/ogrenciler
Authorization: Bearer {token}

Query Params:
- page: 1
- per_page: 20
- program_turu: T1
- durum: Eğitimde
- sinif_id: 10
- search: Ahmet (ad_soyad, tc_kimlik_no, email)
- kayit_baslangic: 2025-01-01
- kayit_bitis: 2025-01-31
- odeme_gecikme: true
- evrak_eksik: true
- sort_by: kayit_tarihi
- sort_order: desc

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 123,
      "ogrenci_no": "2025-T1-0123",
      "tc_kimlik_no": "12345678901",
      "ad_soyad": "Ahmet Yılmaz",
      "program_turu": "T1",
      "durum": "Eğitimde",
      "sinif": {
        "id": 10,
        "sinif_kodu": "411",
        "sinif_adi": "2025 Ocak Temel Silahlı"
      },
      "email": "ahmet@email.com",
      "cep_tel": "5551234567",
      "kayit_tarihi": "2025-01-10T10:30:00Z",
      "toplam_bedel": 5000.00,
      "odenen_bedel": 2000.00,
      "kalan_bedel": 3000.00,
      "evrak_durumu": "Eksik",
      "kritik_not_var": false
    }
    // ... diğer öğrenciler
  ],
  "meta": {
    "current_page": 1,
    "per_page": 20,
    "total": 450,
    "total_pages": 23,
    "from": 1,
    "to": 20
  }
}
```

### Tek Öğrenci Detayı
```http
GET /admin/ogrenciler/{id}
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    // Tüm öğrenci bilgileri (profil + ödeme + harç + evrak + notlar + devamsızlık)
    "id": 123,
    "ogrenci_no": "2025-T1-0123",
    // ... tüm alanlar
    "notlar": [...],
    "odemeler": [...],
    "evraklar": [...],
    "devamsizlik": {...},
    "sinav_sonuclari": [...],
    "activity_logs": [...]
  }
}
```

### Öğrenci Güncelleme
```http
PUT /admin/ogrenciler/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  // Güncellenecek alanlar
  "ad_soyad": "Ahmet Yılmaz",
  "email": "yeni@email.com",
  "durum": "Sınavda",
  "sinif_id": 15,
  // ... diğer alanlar
}

Response 200:
{
  "success": true,
  "message": "Öğrenci bilgileri güncellendi",
  "data": {
    // Güncellenmiş öğrenci bilgileri
  }
}
```

### Öğrenci Silme (Soft Delete)
```http
DELETE /admin/ogrenciler/{id}
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "message": "Öğrenci pasife alındı"
}
```

### Ödeme Kaydet
```http
POST /admin/ogrenciler/{id}/odeme
Authorization: Bearer {token}
Content-Type: application/json

{
  "tutar": 1500.00,
  "odeme_tarihi": "2025-01-20T14:30:00Z",
  "odeme_sekli": "Kart",
  "odeme_tipi": "Taksit",
  "aciklama": "2. taksit ödemesi"
}

Response 200:
{
  "success": true,
  "message": "Ödeme kaydedildi",
  "data": {
    "odeme": {...},
    "guncel_odeme_durumu": {
      "toplam_bedel": 5000.00,
      "odenen_bedel": 3500.00,
      "kalan_bedel": 1500.00
    }
  }
}
```

### Not Ekleme
```http
POST /admin/ogrenciler/{id}/not
Authorization: Bearer {token}
Content-Type: application/json

{
  "icerik": "Öğrenci evraklarını tamamladı",
  "onem_durumu": "Normal",
  "kategori": "Evrak"
}

Response 200:
{
  "success": true,
  "message": "Not eklendi",
  "data": {
    "id": 50,
    "icerik": "Öğrenci evraklarını tamamladı",
    "onem_durumu": "Normal",
    "created_at": "2025-01-20T10:00:00Z"
  }
}
```

### Evrak Onaylama/Reddetme
```http
PATCH /admin/evraklar/{evrak_id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "durum": "Onaylandı", // veya "Reddedildi"
  "ret_nedeni": "Fotoğraf bulanık" // Sadece red durumunda
}

Response 200:
{
  "success": true,
  "message": "Evrak durumu güncellendi"
}
```

### Sınıf Listesi
```http
GET /admin/siniflar
Authorization: Bearer {token}

Query Params:
- program_turu: T1
- durum: Açık
- sort_by: baslangic_tarihi
- sort_order: desc

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 10,
      "sinif_kodu": "411",
      "sinif_adi": "2025 Ocak Temel Silahlı",
      "program_turu": "T1",
      "kontenjan": 50,
      "mevcut_ogrenci_sayisi": 42,
      "doluluk_yuzdesi": 84,
      "kalan_kontenjan": 8,
      "baslangic_tarihi": "2025-01-15",
      "bitis_tarihi": "2025-05-15",
      "durum": "Devam Ediyor",
      "sorumlu_egitmen": {
        "id": 3,
        "ad_soyad": "Dr. Mehmet Demir"
      }
    }
    // ... diğer sınıflar
  ]
}
```

### Sınıf Oluşturma
```http
POST /admin/siniflar
Authorization: Bearer {token}
Content-Type: application/json

{
  "sinif_kodu": "412",
  "sinif_adi": "2025 Şubat Temel Silahlı",
  "program_turu": "T1",
  "kontenjan": 50,
  "baslangic_tarihi": "2025-02-15",
  "bitis_tarihi": "2025-06-15",
  "durum": "Açık",
  "sorumlu_egitmen_id": 3,
  "yer": "Ankara Şube",
  "aciklama": "Şubat dönemi açılan yeni sınıf"
}

Response 201:
{
  "success": true,
  "message": "Sınıf oluşturuldu",
  "data": {
    "id": 11,
    // ... oluşturulan sınıf bilgileri
  }
}
```

### Ders Programı Oluşturma (Toplu)
```http
POST /admin/siniflar/{sinif_id}/ders-programi
Authorization: Bearer {token}
Content-Type: application/json

{
  "dersler": [
    {
      "ders_id": 5,
      "egitmen_id": 3,
      "tarih": "2025-01-15",
      "saat_baslangic": "09:00:00",
      "saat_bitis": "12:00:00",
      "yer": "A Blok Sınıf 101",
      "konu": "Hukuk giriş"
    },
    {
      "ders_id": 6,
      "egitmen_id": 4,
      "tarih": "2025-01-15",
      "saat_baslangic": "13:00:00",
      "saat_bitis": "16:00:00",
      "yer": "A Blok Sınıf 101",
      "konu": "İlk yardım temel bilgiler"
    }
    // ... diğer dersler
  ]
}

Response 201:
{
  "success": true,
  "message": "Ders programı oluşturuldu",
  "data": {
    "eklenen_ders_sayisi": 2
  }
}
```

### Ders Programını Excel'den İçe Aktarma
```http
POST /admin/siniflar/{sinif_id}/ders-programi/import
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "excel_file": <file>
}

Response 200:
{
  "success": true,
  "message": "Ders programı içe aktarıldı",
  "data": {
    "toplam_satir": 120,
    "basarili": 118,
    "hatali": 2,
    "hatalar": [
      {
        "satir": 15,
        "hata": "Eğitmen bulunamadı"
      }
    ]
  }
}
```

### Devamsızlık Kaydet
```http
POST /admin/devamsizlik
Authorization: Bearer {token}
Content-Type: application/json

{
  "ders_programi_id": 100,
  "ogrenci_id": 123,
  "devamsiz_mi": true,
  "gecikme_dakika": 0,
  "aciklama": "Mazeretsiz"
}

Response 200:
{
  "success": true,
  "message": "Devamsızlık kaydedildi"
}
```

### Toplu Devamsızlık Kaydet (Ders Bazlı)
```http
POST /admin/devamsizlik/toplu
Authorization: Bearer {token}
Content-Type: application/json

{
  "ders_programi_id": 100,
  "devamsizliklar": [
    {
      "ogrenci_id": 123,
      "devamsiz_mi": true
    },
    {
      "ogrenci_id": 124,
      "devamsiz_mi": false,
      "gecikme_dakika": 15
    }
    // ... sınıftaki tüm öğrenciler
  ]
}

Response 200:
{
  "success": true,
  "message": "Devamsızlıklar kaydedildi",
  "data": {
    "kaydedilen": 42
  }
}
```

### Sınav Sonucu Kaydet
```http
POST /admin/sinav-sonuclari
Authorization: Bearer {token}
Content-Type: application/json

{
  "sinav_id": 10,
  "ogrenci_id": 123,
  "puan": 85.50,
  "sonuc": "Başarılı",
  "katildi_mi": true
}

Response 200:
{
  "success": true,
  "message": "Sınav sonucu kaydedildi"
}
```

### Toplu Sınav Sonucu İçe Aktarma
```http
POST /admin/sinav-sonuclari/import
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "sinav_id": 10,
  "excel_file": <file>
}

Response 200:
{
  "success": true,
  "message": "Sınav sonuçları içe aktarıldı",
  "data": {
    "toplam": 45,
    "basarili": 43,
    "hatali": 2
  }
}
```

### Raporlar

#### Öğrenci Listesi Raporu (Excel)
```http
GET /admin/raporlar/ogrenci-listesi
Authorization: Bearer {token}

Query Params: (Yukarıdaki filtreler)

Response: Excel dosyası (application/vnd.ms-excel)
```

#### Ödeme Raporu
```http
GET /admin/raporlar/odeme-raporu
Authorization: Bearer {token}

Query Params:
- baslangic_tarihi: 2025-01-01
- bitis_tarihi: 2025-01-31
- program_turu: T1

Response: Excel dosyası
```

#### Devamsızlık Raporu
```http
GET /admin/raporlar/devamsizlik-raporu
Authorization: Bearer {token}

Query Params:
- sinif_id: 10
- baslangic_tarihi: 2025-01-01
- bitis_tarihi: 2025-01-31

Response: Excel dosyası
```

---

## ORTAK API'LER

### İl/İlçe Listesi
```http
GET /genel/iller

Response 200:
{
  "success": true,
  "data": [
    {
      "il_adi": "Ankara",
      "ilceler": ["Çankaya", "Keçiören", "Mamak", ...]
    },
    // ... diğer iller
  ]
}
```

### Dersler Listesi
```http
GET /genel/dersler
Authorization: Bearer {token}

Query Params:
- program_turu: T1
- aktif: true

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 5,
      "ders_kodu": "OGH101",
      "ders_adi": "Özel Güvenlik Hukuku",
      "silahli_mi": true,
      "teorik_saat": 20,
      "uygulama_saat": 5,
      "toplam_saat": 25
    }
    // ... diğer dersler
  ]
}
```

### Eğitmenler Listesi
```http
GET /genel/egitmenler
Authorization: Bearer {token}

Query Params:
- aktif: true
- brans: Hukuk

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 3,
      "ad_soyad": "Dr. Mehmet Demir",
      "branslar": ["Hukuk", "İnsan Hakları"],
      "uzmanlik_alani": "Özel Güvenlik Hukuku"
    }
    // ... diğer eğitmenler
  ]
}
```

### Sistem Ayarları
```http
GET /genel/sistem-ayarlari
Authorization: Bearer {token} (Admin için)

Response 200:
{
  "success": true,
  "data": {
    "kvkk_metni": "...",
    "aydinlatma_metni": "...",
    "kurs_ucretleri": {
      "T1": 5000.00,
      "T2": 4000.00,
      "Y1": 3000.00,
      "Y2": 2500.00,
      "T3": 2000.00
    },
    "iletisim": {
      "telefon": "+90 312 123 45 67",
      "email": "info@akademi.com",
      "adres": "..."
    }
  }
}
```

---

## HATA KODLARI VE RESPONSE YAPISI

### Başarılı Response
```json
{
  "success": true,
  "message": "İşlem başarılı",
  "data": { ... }
}
```

### Hata Response
```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Gönderilen veriler geçersiz",
    "details": {
      "tc_kimlik_no": ["TC Kimlik No 11 haneli olmalıdır"],
      "email": ["Geçerli bir e-posta adresi giriniz"]
    }
  }
}
```

### HTTP Durum Kodları
- `200 OK`: Başarılı istek
- `201 Created`: Kaynak başarıyla oluşturuldu
- `400 Bad Request`: Geçersiz istek
- `401 Unauthorized`: Kimlik doğrulama gerekli
- `403 Forbidden`: Yetkisiz erişim
- `404 Not Found`: Kaynak bulunamadı
- `422 Unprocessable Entity`: Validasyon hatası
- `500 Internal Server Error`: Sunucu hatası

### Hata Kodları
- `VALIDATION_ERROR`: Validasyon hatası
- `AUTHENTICATION_FAILED`: Kimlik doğrulama başarısız
- `UNAUTHORIZED`: Yetkisiz erişim
- `NOT_FOUND`: Kaynak bulunamadı
- `DUPLICATE_ENTRY`: Aynı kayıt zaten mevcut
- `BUSINESS_LOGIC_ERROR`: İş mantığı hatası
- `SERVER_ERROR`: Sunucu hatası

---

## PAGINATION

Tüm liste endpoint'leri pagination destekler:

```http
GET /admin/ogrenciler?page=2&per_page=50

Response:
{
  "success": true,
  "data": [...],
  "meta": {
    "current_page": 2,
    "per_page": 50,
    "total": 450,
    "total_pages": 9,
    "from": 51,
    "to": 100
  },
  "links": {
    "first": "/admin/ogrenciler?page=1&per_page=50",
    "prev": "/admin/ogrenciler?page=1&per_page=50",
    "next": "/admin/ogrenciler?page=3&per_page=50",
    "last": "/admin/ogrenciler?page=9&per_page=50"
  }
}
```

---

## RATE LIMITING

- OTP istekleri: 3 istek / 10 dakika (IP başına)
- Genel API: 60 istek / dakika (kullanıcı başına)
- Admin API: 120 istek / dakika (admin başına)

Rate limit aşıldığında:
```json
HTTP 429 Too Many Requests
{
  "success": false,
  "error": {
    "code": "RATE_LIMIT_EXCEEDED",
    "message": "Çok fazla istek gönderildi. Lütfen 60 saniye bekleyiniz.",
    "retry_after": 60
  }
}
```

---

## WEBHOOK'LAR (Opsiyonel - Gelecek)

Admin tarafından belirli olaylar için webhook URL'leri tanımlanabilir:

**Olaylar:**
- `ogrenci.kayit`: Yeni öğrenci kaydı
- `ogrenci.durum_degisikligi`: Öğrenci durumu değişti
- `odeme.alindi`: Ödeme alındı
- `sinav.sonuc`: Sınav sonucu girildi

**Webhook Payload:**
```json
{
  "event": "ogrenci.kayit",
  "timestamp": "2025-01-20T10:30:00Z",
  "data": {
    "ogrenci_id": 123,
    "ad_soyad": "Ahmet Yılmaz",
    "program_turu": "T1"
  }
}
```

