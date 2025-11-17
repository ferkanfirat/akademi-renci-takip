# EKRAN AKIŞLARI VE UI BİLEŞENLERİ

## GENEL MİMARİ

```
WordPress Site (Mevcut)
    │
    ├── Header/Menu
    │   ├── Öğrenci Kayıt (→ React App)
    │   ├── Öğrenci Girişi (→ React App)
    │   └── Admin Girişi (→ React App)
    │
    └── Ana İçerik
```

**React SPA (Single Page Application):**
- WordPress'ten butona tıklandığında yeni sekme veya iframe içinde açılır
- Kendi routing'i ile çalışır
- API üzerinden Laravel backend'e bağlanır

---

## SAYFA YAPISI VE ROUTE'LAR

### Public Routes (Kimlik doğrulama gerektirmeyen)
```
/kayit                          → Öğrenci kayıt sürecine başlangıç
/kayit/program-secimi           → Program türü seçimi (T1/T2/Y1/Y2/T3)
/kayit/kvkk                     → KVKK ve aydınlatma onayı
/kayit/kimlik-fotograf          → Kimlik fotoğrafı yükleme
/kayit/kisisel-bilgiler         → Kişisel bilgiler formu
/kayit/iletisim-bilgileri       → İletişim bilgileri formu
/kayit/odeme-bilgileri          → Ödeme ve fatura bilgileri
/kayit/evrak-durumu             → Evrak durumu
/kayit/ozet                     → Özet ve onay
/kayit/tamamlandi               → Kayıt tamamlandı ekranı

/giris/ogrenci                  → Öğrenci giriş (OTP)
/giris/admin                    → Admin giriş (username/password)
```

### Protected Routes - Öğrenci (Öğrenci rolü gerekli)
```
/ogrenci/dashboard              → Öğrenci dashboard
/ogrenci/profil                 → Profil bilgileri
/ogrenci/ders-programi          → Ders programı
/ogrenci/devamsizlik            → Devamsızlık durumu
/ogrenci/odeme                  → Ödeme durumu
/ogrenci/harc-hakki             → Harç hakkı takibi
/ogrenci/evraklar               → Evrak durumu ve yükleme
/ogrenci/sinav-sonuclari        → Sınav sonuçları
/ogrenci/ayarlar                → Ayarlar
```

### Protected Routes - Admin (Admin rolü gerekli)
```
/admin/dashboard                → Admin dashboard
/admin/ogrenciler               → Öğrenci listesi
/admin/ogrenciler/:id           → Öğrenci detay
/admin/ogrenciler/:id/duzenle   → Öğrenci düzenle
/admin/siniflar                 → Sınıf listesi
/admin/siniflar/yeni            → Yeni sınıf oluştur
/admin/siniflar/:id             → Sınıf detay
/admin/siniflar/:id/program     → Ders programı yönetimi
/admin/dersler                  → Ders tanımları
/admin/egitmenler               → Eğitmen yönetimi
/admin/firmalar                 → Firma yönetimi
/admin/sinavlar                 → Sınav yönetimi
/admin/raporlar                 → Raporlar
/admin/ayarlar                  → Sistem ayarları
```

---

## EKRAN AKIŞI 1: ÖĞRENCİ KAYIT SÜRECİ

### 1.1. Program Seçimi (`/kayit/program-secimi`)

**Amaç:** Kursiyer hangi programa katılacağını seçer.

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  ÖZEL GÜVENLİK EĞİTİM KAYIT SİSTEMİ     │
├─────────────────────────────────────────┤
│                                         │
│  Hangi programa kayıt olmak             │
│  istiyorsunuz?                          │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ ○ T1 - Temel Silahlı             │  │
│  │   İlk kez eğitim alacaklar        │  │
│  │   Ücret: 5.000 TL                 │  │
│  │   Süre: 120 gün                   │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ ○ T2 - Temel Silahsız            │  │
│  │   İlk kez eğitim alacaklar        │  │
│  │   Ücret: 4.000 TL                 │  │
│  │   Süre: 90 gün                    │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ ○ Y1 - Yenileme Silahlı          │  │
│  │   4 yılda bir zorunlu yenileme    │  │
│  │   Ücret: 3.000 TL                 │  │
│  │   Süre: 40 gün                    │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ... (Y2, T3)                           │
│                                         │
│           [İleri →]                     │
└─────────────────────────────────────────┘
```

**Validasyon:**
- Bir program seçilmesi zorunlu

**API Çağrısı:**
- `GET /kayit/program-turleri` (Programları listeler)

---

### 1.2. KVKK Onayı (`/kayit/kvkk`)

**Amaç:** Kullanıcıdan KVKK ve aydınlatma metni onayı alınır.

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  KVKK VE AYDINLATMA METNİ               │
├─────────────────────────────────────────┤
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ [Uzun KVKK metni buraya gelir]    │  │
│  │                                   │  │
│  │ ... scroll edilebilir içerik ...  │  │
│  │                                   │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ☑ Yukarıdaki metni okudum ve          │
│    onaylıyorum.                         │
│                                         │
│  [← Geri]           [İleri →]          │
└─────────────────────────────────────────┘
```

**Validasyon:**
- Checkbox işaretlenmeden ilerlenememeli

**API Çağrısı:**
- `GET /kayit/kvkk-metni`

---

### 1.3. Kimlik Fotoğrafı Yükleme (`/kayit/kimlik-fotograf`)

**Amaç:** T.C. kimlik kartının fotoğrafı yüklenir.

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  KİMLİK FOTOĞRAFI YÜKLEME               │
├─────────────────────────────────────────┤
│                                         │
│  Lütfen T.C. Kimlik kartınızın önünü   │
│  çekip yükleyiniz.                      │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │                                   │  │
│  │     [📷 Fotoğraf Çek]             │  │
│  │     [📁 Dosya Seç]                │  │
│  │                                   │  │
│  │  veya sürükle bırak               │  │
│  │                                   │  │
│  └───────────────────────────────────┘  │
│                                         │
│  Yüklü Fotoğraf:                        │
│  ┌───────────────────────────────────┐  │
│  │ [Önizleme gösterilir]             │  │
│  │                                   │  │
│  └───────────────────────────────────┘  │
│                                         │
│  [← Geri]           [İleri →]          │
└─────────────────────────────────────────┘
```

**Özellikler:**
- Mobil cihazlarda kamera erişimi
- Drag & drop destekli
- Önizleme gösterimi
- Max dosya boyutu: 5MB
- İzin verilen formatlar: JPG, PNG

**API Çağrısı:**
- `POST /kayit/kimlik-fotograf-yukle`

---

### 1.4. Kişisel Bilgiler (`/kayit/kisisel-bilgiler`)

**Amaç:** Kursiyerin kişisel bilgileri girilir.

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  KİŞİSEL BİLGİLER                       │
├─────────────────────────────────────────┤
│                                         │
│  TC Kimlik No *                         │
│  [___________]                          │
│                                         │
│  Ad Soyad *                             │
│  [_________________________]            │
│                                         │
│  Doğum Tarihi *                         │
│  [__/__/____]  (GG/AA/YYYY)             │
│                                         │
│  Kan Grubu                              │
│  [Seçiniz ▼]                            │
│                                         │
│  ─────────────────────────────────────  │
│  ÖĞRENİM DURUMU                         │
│                                         │
│  Öğrenim Durumu                         │
│  [Seçiniz ▼]                            │
│  (İlkokul, Ortaokul, Lise, Üniversite)  │
│                                         │
│  ─────────────────────────────────────  │
│  ÇALIŞMA BİLGİLERİ                      │
│                                         │
│  Halen Çalıştığı Firma                  │
│  [Firma ara veya seç ▼]                 │
│                                         │
│  Halen Çalıştığı Proje                  │
│  [_________________________]            │
│                                         │
│  Proje İlçesi                           │
│  [_________________________]            │
│                                         │
│  [← Geri]           [İleri →]          │
└─────────────────────────────────────────┘
```

**Conditional Fields:**
- Eğer program Y1, Y2, T3 ise:
  ```
  ÖGG Kimlik Bitiş Tarihi *
  [__/__/____]
  ```

**Validasyon:**
- TC Kimlik No: 11 haneli, numerik, algoritma kontrolü
- Ad Soyad: En az 5 karakter
- Doğum Tarihi: 18 yaşından büyük olmalı
- Firma: Listeden seçilmeli

**API Çağrıları:**
- `GET /kayit/firmalar` (Firma listesi)

---

### 1.5. İletişim Bilgileri (`/kayit/iletisim-bilgileri`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  İLETİŞİM BİLGİLERİ                     │
├─────────────────────────────────────────┤
│                                         │
│  İkamet İli *                           │
│  [Seçiniz ▼]                            │
│                                         │
│  İkamet İlçesi *                        │
│  [Seçiniz ▼]                            │
│                                         │
│  Cep Telefonu *                         │
│  [0(___) ___ __ __]                     │
│                                         │
│  Cep Telefonu 2 (Opsiyonel)            │
│  [0(___) ___ __ __]                     │
│                                         │
│  E-posta *                              │
│  [_________________________]            │
│                                         │
│  ─────────────────────────────────────  │
│  ACİL DURUM İLETİŞİM                    │
│                                         │
│  Yakınınızın Adı Soyadı                 │
│  [_________________________]            │
│                                         │
│  ─────────────────────────────────────  │
│  BİZE NASIL ULAŞTINIZ?                  │
│                                         │
│  ☐ Google Arama                         │
│  ☐ Sosyal Medya                         │
│  ☐ Arkadaş Tavsiyesi                    │
│  ☐ Kurum Yönlendirmesi                  │
│  ☐ Diğer                                │
│                                         │
│  [← Geri]           [İleri →]          │
└─────────────────────────────────────────┘
```

**Validasyon:**
- Cep telefonu: 10 haneli, format kontrolü
- E-posta: RFC 5322 standardı
- İl/İlçe: Listeden seçilmeli

**API Çağrıları:**
- `GET /genel/iller` (İl/ilçe listesi)

---

### 1.6. Ödeme Bilgileri (`/kayit/odeme-bilgileri`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  ÖDEME BİLGİLERİ                        │
├─────────────────────────────────────────┤
│                                         │
│  Toplam Kurs Ücreti                     │
│  ┌───────────────────────────────────┐  │
│  │  5.000,00 TL                      │  │
│  └───────────────────────────────────┘  │
│                                         │
│  Ödenen Tutar *                         │
│  [_________] TL                         │
│                                         │
│  Kalan Tutar (Otomatik)                 │
│  ┌───────────────────────────────────┐  │
│  │  3.000,00 TL                      │  │
│  └───────────────────────────────────┘  │
│                                         │
│  Kalan Ödeme Tarihi                     │
│  [__/__/____]                           │
│                                         │
│  Ödeme Şekli *                          │
│  ○ Nakit  ○ Kart  ○ EFT  ○ Şirket      │
│                                         │
│  ─────────────────────────────────────  │
│  HARÇ BİLGİSİ                           │
│                                         │
│  ☐ Harcı kurumum ödeyecek               │
│                                         │
│  ─────────────────────────────────────  │
│  FATURA BİLGİLERİ                       │
│                                         │
│  ☐ Kurumsal fatura istiyorum            │
│                                         │
│  [Açılır alan - kurumsal fatura seçilirse:]│
│  Fatura Ünvanı *                        │
│  [_________________________]            │
│  Vergi No *                             │
│  [__________]                           │
│  Vergi Dairesi *                        │
│  [_________________________]            │
│  Fatura Adresi *                        │
│  [_________________________]            │
│  [_________________________]            │
│                                         │
│  ─────────────────────────────────────  │
│  İNDİRİM                                │
│                                         │
│  ☐ İndirim uygulandı                    │
│  [Açılır alan - indirim seçilirse:]     │
│  İndirim Açıklaması                     │
│  [_________________________]            │
│                                         │
│  [← Geri]           [İleri →]          │
└─────────────────────────────────────────┘
```

**Hesaplamalar:**
- Kalan Tutar = Toplam Bedel - Ödenen Tutar (Auto-calculate)

**Conditional Fields:**
- Kurumsal fatura: Fatura bilgileri gösterilir
- İndirim: Açıklama alanı gösterilir

---

### 1.7. Evrak Durumu (`/kayit/evrak-durumu`)

**Amaç:** Hangi evrakların gerekli olduğu gösterilir.

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  EVRAK DURUMU                           │
├─────────────────────────────────────────┤
│                                         │
│  Eğitime başlamadan önce aşağıdaki      │
│  evrakları teslim etmeniz gerekiyor:    │
│                                         │
│  Program: T1 - Temel Silahlı            │
│                                         │
│  ☐ Nüfus Cüzdanı Fotokopisi             │
│  ☐ 2 Adet Vesikalık Fotoğraf            │
│  ☐ Sağlık Raporu                        │
│  ☐ Diploma/Öğrenim Belgesi              │
│                                         │
│  ℹ️ Bu evrakları sisteme giriş yaptıktan│
│     sonra online yükleyebilir veya      │
│     okulumuz bürosuna teslim            │
│     edebilirsiniz.                      │
│                                         │
│  [← Geri]           [İleri →]          │
└─────────────────────────────────────────┘
```

**Program Türüne Göre Evraklar:**
- **T1/T2 (Temel):** Nüfus, resim, sağlık, diploma
- **Y1/Y2 (Yenileme):** Nüfus, resim, ÖGG kimlik fotokopisi, sağlık
- **T3 (Geçiş):** Nüfus, resim, ÖGG kimlik fotokopisi, sağlık

---

### 1.8. Özet ve Onay (`/kayit/ozet`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  KAYIT ÖZETİ                            │
├─────────────────────────────────────────┤
│                                         │
│  ✓ Program Bilgisi                      │
│    T1 - Temel Silahlı                   │
│    Sınav Tarihi: 15.12.2025             │
│                                         │
│  ✓ Kişisel Bilgiler                     │
│    Ahmet Yılmaz                         │
│    TC: 12345678901                      │
│    Doğum: 15.05.1990                    │
│                                         │
│  ✓ İletişim Bilgileri                   │
│    Tel: 0555 123 45 67                  │
│    Email: ahmet@email.com               │
│    Adres: Ankara / Çankaya              │
│                                         │
│  ✓ Ödeme Bilgileri                      │
│    Toplam: 5.000 TL                     │
│    Ödenen: 2.000 TL                     │
│    Kalan: 3.000 TL                      │
│                                         │
│  ☑ Verdiğim tüm bilgilerin doğru        │
│    olduğunu beyan ederim.               │
│                                         │
│  [← Geri]     [Kaydı Tamamla ✓]        │
└─────────────────────────────────────────┘
```

**İşlemler:**
- "Kaydı Tamamla" butonuna basıldığında API'ye POST request
- Loading spinner gösterilir
- Başarılı olursa `/kayit/tamamlandi` sayfasına yönlendirilir

**API Çağrısı:**
- `POST /kayit/ogrenci-kayit`

---

### 1.9. Kayıt Tamamlandı (`/kayit/tamamlandi`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  ✓ KAYDINIZ TAMAMLANDI                  │
├─────────────────────────────────────────┤
│                                         │
│  Sayın Ahmet Yılmaz,                    │
│                                         │
│  Kaydınız başarıyla alınmıştır.         │
│                                         │
│  Öğrenci Numaranız:                     │
│  ┌───────────────────────────────────┐  │
│  │  2025-T1-0123                     │  │
│  └───────────────────────────────────┘  │
│                                         │
│  Giriş Bilgileriniz:                    │
│  Cep Tel: 0555 123 45 67                │
│  E-posta: ahmet@email.com               │
│                                         │
│  Sisteme giriş yapmak için cep telefonu │
│  veya e-posta adresinizle OTP kodu      │
│  alabilirsiniz.                         │
│                                         │
│  ───────────────────────────────────────│
│                                         │
│  Sonraki Adımlar:                       │
│  1. Evraklarınızı yükleyin              │
│  2. Ödeme taksit planınızı takip edin   │
│  3. Sınıf programınızı görüntüleyin     │
│                                         │
│  [Sisteme Giriş Yap →]                  │
│  [Ana Sayfaya Dön]                      │
└─────────────────────────────────────────┘
```

---

## EKRAN AKIŞI 2: ÖĞRENCİ GİRİŞİ (OTP)

### 2.1. OTP İsteği (`/giris/ogrenci`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  ÖĞRENCİ GİRİŞİ                         │
├─────────────────────────────────────────┤
│                                         │
│  Cep Telefonu *                         │
│  [0(___) ___ __ __]                     │
│                                         │
│  E-posta *                              │
│  [_________________________]            │
│                                         │
│  ℹ️ Telefon ve e-posta kayıt sırasında  │
│     verdiğiniz bilgiler olmalıdır.      │
│                                         │
│           [Kod Gönder]                  │
│                                         │
│  ─────────────────────────────────────  │
│                                         │
│  [← Ana Sayfaya Dön]                    │
└─────────────────────────────────────────┘
```

**İşlem:**
1. Form doldurulur
2. "Kod Gönder" butonuna basılır
3. API çağrısı: `POST /auth/ogrenci/otp-request`
4. Başarılı ise → OTP doğrulama ekranına geçilir

---

### 2.2. OTP Doğrulama

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  DOĞRULAMA KODU                         │
├─────────────────────────────────────────┤
│                                         │
│  Cep telefonunuza ve e-postanıza        │
│  gönderilen 6 haneli kodu giriniz:      │
│                                         │
│  [_] [_] [_] [_] [_] [_]                │
│                                         │
│  Kalan süre: 04:32                      │
│                                         │
│           [Doğrula]                     │
│                                         │
│  Kodu almadınız mı?                     │
│  [Tekrar Gönder]                        │
│                                         │
│  [← Geri]                               │
└─────────────────────────────────────────┘
```

**İşlem:**
1. 6 haneli kod girilir
2. API çağrısı: `POST /auth/ogrenci/otp-verify`
3. Token alınır ve local storage'a kaydedilir
4. `/ogrenci/dashboard` sayfasına yönlendirilir

---

## EKRAN AKIŞI 3: ÖĞRENCİ DASHBOARD

### 3.1. Dashboard Ana Sayfa (`/ogrenci/dashboard`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  🏠 Dashboard  📚 Program  📋 Evrak  💰 │
├─────────────────────────────────────────┤
│                                         │
│  Hoş Geldiniz, Ahmet Yılmaz             │
│  Öğrenci No: 2025-T1-0123               │
│                                         │
│  ┌────────────┬────────────┬──────────┐ │
│  │  Durum     │ Sınıf      │ Program  │ │
│  │  Eğitimde  │ 411        │ T1       │ │
│  └────────────┴────────────┴──────────┘ │
│                                         │
│  ───────────────────────────────────────│
│  HIZLI ERİŞİM                           │
│                                         │
│  ┌─────────────────┐ ┌────────────────┐ │
│  │ 📅 Ders Programı│ │ 💰 Ödeme       │ │
│  │                 │ │                │ │
│  │ Bugün 2 ders    │ │ Kalan: 3.000 TL│ │
│  └─────────────────┘ └────────────────┘ │
│                                         │
│  ┌─────────────────┐ ┌────────────────┐ │
│  │ 📋 Evraklar     │ │ 🎯 Harç Hakkı  │ │
│  │                 │ │                │ │
│  │ 2 eksik         │ │ 5/6 kaldı      │ │
│  └─────────────────┘ └────────────────┘ │
│                                         │
│  ───────────────────────────────────────│
│  YAKLAŞAN ETKİNLİKLER                   │
│                                         │
│  • 20.01.2025 - Özel Güvenlik Hukuku    │
│  • 21.01.2025 - İlk Yardım Eğitimi      │
│  • 15.12.2025 - Temel Eğitim Sınavı     │
│                                         │
│  ───────────────────────────────────────│
│  İLERLEME                               │
│                                         │
│  Ders Tamamlanma: [████░░░░] 30%        │
│  30 / 120 saat                          │
│                                         │
│  Devamsızlık: 2 gün (5%)                │
│  ⚠️ Limit: %20                          │
│                                         │
└─────────────────────────────────────────┘
```

**Navigation Menu (Responsive):**
```
Desktop:
┌──────────────────────────────────────────┐
│ Logo  Dashboard  Program  Evrak  Ödeme   │
│       Harç  Sınav  Profil  🔔  [Çıkış]   │
└──────────────────────────────────────────┘

Mobile:
┌──────────────────────────────────────────┐
│ ☰  Logo                    🔔  [Profil]  │
└──────────────────────────────────────────┘
```

---

### 3.2. Ders Programı (`/ogrenci/ders-programi`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  DERS PROGRAMI                          │
├─────────────────────────────────────────┤
│                                         │
│  Sınıf: 411 - 2025 Ocak Temel Silahlı   │
│                                         │
│  Tarih Aralığı:                         │
│  [15.01.2025 ▼] - [31.01.2025 ▼]        │
│  [Filtrele]                             │
│                                         │
│  ───────────────────────────────────────│
│                                         │
│  📅 Pazartesi, 15 Ocak 2025              │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ 09:00 - 12:00                     │  │
│  │ Özel Güvenlik Hukuku              │  │
│  │ Eğitmen: Dr. Mehmet Demir         │  │
│  │ Yer: A Blok Sınıf 101             │  │
│  │ Durum: ✓ Tamamlandı               │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ 13:00 - 16:00                     │  │
│  │ İlk Yardım                        │  │
│  │ Eğitmen: Uzm. Ayşe Kaya           │  │
│  │ Yer: A Blok Sınıf 101             │  │
│  │ Durum: ⏱ Planlandı                │  │
│  └───────────────────────────────────┘  │
│                                         │
│  📅 Salı, 16 Ocak 2025                   │
│  ... (diğer dersler)                    │
│                                         │
│  ───────────────────────────────────────│
│  ÖZET                                   │
│                                         │
│  Toplam Ders Saati: 120 saat            │
│  Tamamlanan: 30 saat (25%)              │
│  Kalan: 90 saat                         │
│                                         │
└─────────────────────────────────────────┘
```

---

### 3.3. Ödeme Durumu (`/ogrenci/odeme`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  ÖDEME DURUMU                           │
├─────────────────────────────────────────┤
│                                         │
│  ÖZET                                   │
│                                         │
│  ┌─────────────┬──────────────────────┐ │
│  │ Toplam      │ 5.000,00 TL          │ │
│  │ Ödenen      │ 2.000,00 TL          │ │
│  │ Kalan       │ 3.000,00 TL          │ │
│  └─────────────┴──────────────────────┘ │
│                                         │
│  ⚠️ Son ödeme tarihi: 15.02.2025        │
│     (26 gün kaldı)                      │
│                                         │
│  ───────────────────────────────────────│
│  ÖDEME GEÇMİŞİ                          │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ 10.01.2025  14:30                 │  │
│  │ Kayıt Ücreti                      │  │
│  │ 2.000,00 TL (Nakit)               │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ───────────────────────────────────────│
│                                         │
│  ℹ️ Ödeme yapmak için lütfen okulumuz   │
│     bürosuna başvurunuz veya banka      │
│     hesap numaramıza EFT yapabilirsiniz.│
│                                         │
│  [Banka Bilgilerini Göster]             │
│                                         │
└─────────────────────────────────────────┘
```

---

### 3.4. Evrak Durumu (`/ogrenci/evraklar`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  EVRAK DURUMU                           │
├─────────────────────────────────────────┤
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ ✓ Nüfus Cüzdanı Fotokopisi        │  │
│  │   Durum: Onaylandı                │  │
│  │   Tarih: 11.01.2025               │  │
│  │   [Görüntüle]                     │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ ⏱ Vesikalık Fotoğraf (2 adet)    │  │
│  │   Durum: Yüklendi (Onay bekliyor) │  │
│  │   Tarih: 12.01.2025               │  │
│  │   [Görüntüle]                     │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ ❌ Sağlık Raporu                  │  │
│  │   Durum: Eksik                    │  │
│  │   [📤 Yükle]                      │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ ⚠️ Diploma/Öğrenim Belgesi        │  │
│  │   Durum: Reddedildi               │  │
│  │   Neden: Fotoğraf bulanık          │  │
│  │   [📤 Tekrar Yükle]               │  │
│  └───────────────────────────────────┘  │
│                                         │
└─────────────────────────────────────────┘
```

**Evrak Yükleme Modal:**
```
┌─────────────────────────────────────────┐
│  EVRAK YÜKLE                            │
├─────────────────────────────────────────┤
│                                         │
│  Evrak: Sağlık Raporu                   │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │                                   │  │
│  │     [📷 Fotoğraf Çek]             │  │
│  │     [📁 Dosya Seç]                │  │
│  │                                   │  │
│  │  veya sürükle bırak               │  │
│  │                                   │  │
│  └───────────────────────────────────┘  │
│                                         │
│  Açıklama (Opsiyonel)                   │
│  [_________________________]            │
│                                         │
│  [İptal]              [Yükle]          │
└─────────────────────────────────────────┘
```

---

### 3.5. Harç Hakkı Takibi (`/ogrenci/harc-hakki`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  HARÇ HAKKI TAKİBİ                      │
├─────────────────────────────────────────┤
│                                         │
│  GENEL DURUM                            │
│                                         │
│  ┌─────────────┬──────────────────────┐ │
│  │ Toplam Hak  │ 6                    │ │
│  │ Kullanılan  │ 1                    │ │
│  │ Kalan       │ 5                    │ │
│  └─────────────┴──────────────────────┘ │
│                                         │
│  İlerleme: [█░░░░░] 1/6                 │
│                                         │
│  ───────────────────────────────────────│
│  HARÇ DETAYLARI                         │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ 1. HARÇ                           │  │
│  │ Tarih: 15.01.2025                 │  │
│  │ Durum: ✓ Kullanıldı               │  │
│  │ Sınav: 15.12.2025                 │  │
│  │ Sonuç: ⏱ Beklemede                │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌───────────────────────────────────┐  │
│  │ 2. HARÇ                           │  │
│  │ Durum: Kullanılmadı               │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ... (3-6 arasındaki harçlar)           │
│                                         │
│  ℹ️ Her sınava girmek için bir harç     │
│     hakkı kullanılır. Toplam 6 hakkınız │
│     bulunmaktadır.                      │
│                                         │
└─────────────────────────────────────────┘
```

---

## EKRAN AKIŞI 4: ADMIN DASHBOARD

### 4.1. Admin Giriş (`/giris/admin`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────┐
│  ADMİN GİRİŞİ                           │
├─────────────────────────────────────────┤
│                                         │
│  Kullanıcı Adı *                        │
│  [_________________________]            │
│                                         │
│  Şifre *                                │
│  [_________________________] 👁         │
│                                         │
│  ☐ Beni Hatırla                         │
│                                         │
│           [Giriş Yap]                   │
│                                         │
│  [Şifremi Unuttum]                      │
│                                         │
└─────────────────────────────────────────┘
```

---

### 4.2. Admin Dashboard (`/admin/dashboard`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────────────────────┐
│ 🏢 Logo  Dashboard  Öğrenciler  Sınıflar  Raporlar  ⚙️  │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ADMİN DASHBOARD                   👤 Admin User [Çıkış]│
│                                                         │
│  ┌──────────┬──────────┬──────────┬──────────────────┐  │
│  │ Toplam   │ Aktif    │ Bekleyen │ Geciken          │  │
│  │ Öğrenci  │ Sınıf    │ Evrak    │ Ödeme            │  │
│  │ 450      │ 5        │ 23       │ 15               │  │
│  └──────────┴──────────┴──────────┴──────────────────┘  │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  PROGRAM DAĞILIMI                                       │
│                                                         │
│  T1: ████████░░ 150 (33%)                               │
│  T2: ██████░░░░ 100 (22%)                               │
│  Y1: ███████░░░ 120 (27%)                               │
│  Y2: ████░░░░░░  60 (13%)                               │
│  T3: ██░░░░░░░░  20 (5%)                                │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  HIZLI ERİŞİM                                           │
│                                                         │
│  ┌────────────────┐ ┌────────────────┐ ┌─────────────┐ │
│  │ 📋 Bekleyen    │ │ 💰 Geciken     │ │ ⚠️ Kritik   │ │
│  │    Evraklar    │ │    Ödemeler    │ │    Notlar   │ │
│  │                │ │                │ │             │ │
│  │    23 adet     │ │    15 adet     │ │    3 adet   │ │
│  └────────────────┘ └────────────────┘ └─────────────┘ │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  BUGÜNÜN DERSLERİ                                       │
│                                                         │
│  • 09:00 - Sınıf 411 - Özel Güvenlik Hukuku             │
│  • 13:00 - Sınıf 411 - İlk Yardım                       │
│  • 09:00 - Sınıf 910 - Yenileme Eğitimi                │
│  ... (5 ders daha)                                      │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  YAKLAŞAN SINAVLAR                                      │
│                                                         │
│  • 15.12.2025 - Temel Eğitim (45 öğrenci)               │
│  • 20.12.2025 - Yenileme Eğitim (30 öğrenci)            │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  YAKLAŞAN YENİLEMELER (ÖGG Bitiş Tarihi)                │
│                                                         │
│  • Ahmet Yılmaz - 30.01.2025 (10 gün kaldı)             │
│  • Mehmet Demir - 15.02.2025 (26 gün kaldı)             │
│  ... (10 kişi daha)                                     │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

### 4.3. Öğrenci Listesi (`/admin/ogrenciler`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────────────────────┐
│  ÖĞRENCİ YÖNETİMİ                                       │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  [+ Yeni Öğrenci]                        [Export Excel] │
│                                                         │
│  Filtrele:                                              │
│  Program: [Tümü ▼]  Durum: [Tümü ▼]  Sınıf: [Tümü ▼]   │
│  Ara: [_______________] 🔍                              │
│                                                         │
│  ☐ Evrak eksik olanlar  ☐ Ödeme gecikmiş olanlar        │
│                                                         │
│  ───────────────────────────────────────────────────────│
│                                                         │
│  Toplam: 450 öğrenci  |  Sayfa: 1 / 23                  │
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ No      Ad Soyad      Program  Sınıf  Durum   Aksiyon│
│  ├──────────────────────────────────────────────────┤   │
│  │ 0123    Ahmet Yılmaz  T1       411    Eğitimde [Detay]│
│  │ 0124    Mehmet Demir  T2       412    Kayıt    [Detay]│
│  │ 0125    Ayşe Kaya     Y1       910    Sınavda  [Detay]│
│  │ ...                                              │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
│  [◀ Önceki]  1 2 3 ... 23  [Sonraki ▶]                  │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

**Tablo Özellikleri:**
- Sıralama (her sütuna tıklayarak)
- Filtreleme (çoklu)
- Arama (ad, TC, email)
- Pagination
- Toplu işlemler (checkbox ile seçim)
- Excel export

---

### 4.4. Öğrenci Detay (`/admin/ogrenciler/:id`)

**UI Bileşenleri (Tab yapısı):**
```
┌─────────────────────────────────────────────────────────┐
│  [← Geri]  AHMET YILMAZ (#2025-T1-0123)      [Düzenle]  │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  [Genel] [Ödeme] [Evrak] [Devamsızlık] [Notlar] [Sınav]│
│  ═══════                                                │
│                                                         │
│  GENEL BİLGİLER                                         │
│                                                         │
│  ┌─────────────────────────────────┐                    │
│  │ [Profil Fotoğrafı]              │                    │
│  └─────────────────────────────────┘                    │
│                                                         │
│  Öğrenci No:       2025-T1-0123                         │
│  TC Kimlik No:     12345678901                          │
│  Ad Soyad:         Ahmet Yılmaz                         │
│  Doğum Tarihi:     15.05.1990 (34 yaş)                  │
│  Kan Grubu:        A+                                   │
│                                                         │
│  Program:          T1 - Temel Silahlı                   │
│  Sınıf:            411 - 2025 Ocak Temel Silahlı        │
│  Durum:            🟢 Eğitimde                          │
│                                                         │
│  Kayıt Tarihi:     10.01.2025 14:30                     │
│  Kayıt Kanalı:     Web                                  │
│  Sınav Tarihi:     15.12.2025                           │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  İLETİŞİM BİLGİLERİ                                     │
│                                                         │
│  Cep Tel:          0555 123 45 67                       │
│  Cep Tel 2:        0555 987 65 43                       │
│  E-posta:          ahmet@email.com                      │
│  Adres:            Ankara / Çankaya                     │
│                                                         │
│  Yakın:            Mehmet Yılmaz                        │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  ÇALIŞMA BİLGİLERİ                                      │
│                                                         │
│  Firma:            ABC Güvenlik A.Ş.                    │
│  Proje:            Ankara AVM                           │
│  Proje İlçesi:     Çankaya                              │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  ADMİN NOTLARI                          [+ Not Ekle]    │
│                                                         │
│  12.01.2025 10:30 - Admin User                          │
│  "Evrakları tamamladı, onaylandı." [Normal]            │
│                                                         │
│  10.01.2025 15:00 - Admin User                          │
│  "İlk kayıt ödeme alındı." [Normal]                     │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

**Ödeme Tab:**
```
┌─────────────────────────────────────────────────────────┐
│  ÖDEME BİLGİLERİ                          [+ Ödeme Ekle]│
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ÖZET                                                   │
│                                                         │
│  Toplam Bedel:     5.000,00 TL                          │
│  Ödenen Bedel:     2.000,00 TL                          │
│  Kalan Bedel:      3.000,00 TL                          │
│                                                         │
│  Son Ödeme:        15.02.2025  ⚠️ (26 gün kaldı)        │
│                                                         │
│  Harç Kurumsal:    Hayır                                │
│  Kurumsal Fatura:  Evet                                 │
│  İndirim:          Evet (%10 erken kayıt)               │
│                                                         │
│  ───────────────────────────────────────────────────────│
│  ÖDEME GEÇMİŞİ                                          │
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ Tarih         Tutar        Şekil   Tip    Kaydeden│   │
│  ├──────────────────────────────────────────────────┤   │
│  │ 10.01.2025    2.000,00 TL  Nakit   Kayıt  Admin  │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

**Evrak Tab:**
```
┌─────────────────────────────────────────────────────────┐
│  EVRAK DURUMU                                           │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ ✓ Nüfus Cüzdanı Fotokopisi                       │   │
│  │   Durum: Onaylandı                               │   │
│  │   Tarih: 11.01.2025  Onay: 11.01.2025 (Admin)    │   │
│  │   [Görüntüle] [İndir]                            │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ ⏱ Vesikalık Fotoğraf                             │   │
│  │   Durum: Yüklendi (Onay bekliyor)                │   │
│  │   Tarih: 12.01.2025                              │   │
│  │   [Görüntüle] [Onayla] [Reddet]                  │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ ❌ Sağlık Raporu                                 │   │
│  │   Durum: Eksik                                   │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

### 4.5. Sınıf Yönetimi (`/admin/siniflar`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────────────────────┐
│  SINIF YÖNETİMİ                                         │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  [+ Yeni Sınıf Oluştur]                                 │
│                                                         │
│  Filtrele:                                              │
│  Program: [Tümü ▼]  Durum: [Tümü ▼]                     │
│                                                         │
│  ───────────────────────────────────────────────────────│
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ 411 - 2025 Ocak Temel Silahlı              [▼]  │   │
│  │                                                  │   │
│  │ Program: T1  |  Durum: 🟢 Devam Ediyor           │   │
│  │ Kontenjan: 42/50 (84% dolu)                      │   │
│  │ Tarih: 15.01.2025 - 15.05.2025                   │   │
│  │ Sorumlu: Dr. Mehmet Demir                        │   │
│  │                                                  │   │
│  │ [Öğrencileri Gör] [Ders Programı] [Düzenle]     │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ 910 - 2025 Ocak Yenileme Silahlı           [▼]  │   │
│  │                                                  │   │
│  │ Program: Y1  |  Durum: 🟡 Açık                   │   │
│  │ Kontenjan: 15/30 (50% dolu)                      │   │
│  │ Tarih: 01.02.2025 - 15.03.2025                   │   │
│  │ Sorumlu: Uzm. Ayşe Kaya                          │   │
│  │                                                  │   │
│  │ [Öğrencileri Gör] [Ders Programı] [Düzenle]     │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

### 4.6. Ders Programı Yönetimi (`/admin/siniflar/:id/program`)

**UI Bileşenleri:**
```
┌─────────────────────────────────────────────────────────┐
│  [← Geri]  DERS PROGRAMI - Sınıf 411                    │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  [+ Ders Ekle]  [📤 Excel İçe Aktar]  [📥 Excel İndir]  │
│                                                         │
│  Tarih Aralığı:                                         │
│  [15.01.2025 ▼] - [31.01.2025 ▼]  [Filtrele]           │
│                                                         │
│  ───────────────────────────────────────────────────────│
│                                                         │
│  📅 Pazartesi, 15 Ocak 2025                              │
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ 09:00 - 12:00                              [✏️][🗑]│   │
│  │ Özel Güvenlik Hukuku                             │   │
│  │ Eğitmen: Dr. Mehmet Demir                        │   │
│  │ Yer: A Blok Sınıf 101                            │   │
│  │ Durum: ✓ Tamamlandı                              │   │
│  │ [Devamsızlık Kaydet]                             │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ 13:00 - 16:00                              [✏️][🗑]│   │
│  │ İlk Yardım                                       │   │
│  │ Eğitmen: Uzm. Ayşe Kaya                          │   │
│  │ Yer: A Blok Sınıf 101                            │   │
│  │ Durum: ⏱ Planlandı                               │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
│  ... (diğer günler)                                     │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

**Devamsızlık Kaydetme Modal:**
```
┌─────────────────────────────────────────────────────────┐
│  DEVAMSIZLIK KAYDET                                     │
│  Ders: Özel Güvenlik Hukuku - 15.01.2025 09:00         │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │ Ad Soyad          Katılım    Gecikme (dk)        │   │
│  ├──────────────────────────────────────────────────┤   │
│  │ ☑ Ahmet Yılmaz    ○ Var ● Yok   [__]            │   │
│  │ ☑ Mehmet Demir    ● Var ○ Yok   [15]            │   │
│  │ ☑ Ayşe Kaya       ● Var ○ Yok   [__]            │   │
│  │ ... (42 öğrenci)                                 │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
│  [Tümünü İşaretle] [Tümünü Kaldır]                      │
│                                                         │
│  [İptal]                              [Kaydet]          │
└─────────────────────────────────────────────────────────┘
```

---

## UI KOMPONENTLERİ (React)

### Reusable Components

1. **FormInput**
   - Text, number, email, tel, date vb.
   - Validasyon mesajları
   - Label, placeholder, required indicator

2. **FormSelect**
   - Dropdown select
   - Searchable dropdown (firmalar, iller için)
   - Multi-select

3. **FileUpload**
   - Drag & drop
   - Kamera desteği (mobil)
   - Önizleme
   - Progress bar

4. **DataTable**
   - Sıralama
   - Filtreleme
   - Pagination
   - Checkbox selection
   - Export

5. **Card**
   - Dashboard kartları
   - İstatistik gösterimi

6. **Modal**
   - Genel modal
   - Confirmation modal
   - Form modal

7. **Tabs**
   - Öğrenci detay tabs
   - Admin panel tabs

8. **ProgressBar**
   - Ders tamamlanma
   - Doluluk oranı

9. **Badge**
   - Durum göstergesi (Eğitimde, Sınavda vb.)
   - Önem göstergesi (Normal, Kritik)

10. **DatePicker**
    - Tarih seçimi
    - Range picker

---

## RESPONSIVE TASARIM

### Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

### Mobile Optimizations
- Hamburger menu
- Collapsible sections
- Touch-friendly buttons (min 44x44px)
- Swipeable tabs
- Bottom navigation bar (öğrenci app için)

---

## RENK PALETİ VE TEma

### Renk Şeması (Öneri)
```
Primary:       #1E3A8A (Koyu Mavi - Güvenlik teması)
Secondary:     #10B981 (Yeşil - Başarı)
Warning:       #F59E0B (Turuncu - Uyarı)
Danger:        #EF4444 (Kırmızı - Hata/Red)
Info:          #3B82F6 (Açık Mavi - Bilgi)
Gray:          #6B7280 (Gri - Neutral)

Background:    #F9FAFB
Text:          #111827
Border:        #E5E7EB
```

### Durum Renkleri
- Kayıt Alındı: Blue
- Eğitimde: Green
- Sınavda: Orange
- Tamamlandı: Dark Green
- Pasif: Gray
- Reddedildi: Red

---

## PERFORMANS OPTİMİZASYONLARI

1. **Lazy Loading**
   - Route-based code splitting
   - Image lazy loading

2. **Caching**
   - API response caching (firmalar, iller vb.)
   - Service worker (offline support)

3. **Virtualization**
   - Uzun listeler için (react-window)

4. **Debouncing**
   - Arama input'ları
   - Filtreler

---

## ERİŞİLEBİLİRLİK (A11Y)

- ARIA labels
- Keyboard navigation
- Screen reader support
- Yüksek kontrast mod
- Font size ayarları

