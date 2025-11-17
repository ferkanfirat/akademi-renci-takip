# Özel Güvenlik Eğitim Merkezi - Öğrenci/Kursiyer Yönetim Sistemi

Modern, API-merkezli öğrenci yönetim sistemi. WordPress entegrasyonlu, web ve mobil uyumlu.

## 🎯 Özellikler

- ✅ **Öğrenci Kayıt Sistemi:** Kapsamlı online kayıt süreci
- ✅ **Program Yönetimi:** T1, T2, Y1, Y2, T3 kurs tipleri
- ✅ **Ders Programı:** Dinamik ders programı yönetimi
- ✅ **Ödeme Takibi:** Taksitli ödeme, harç takibi (6 hak)
- ✅ **Evrak Yönetimi:** Online evrak yükleme ve onaylama
- ✅ **Devamsızlık:** Otomatik devamsızlık takibi
- ✅ **Sınav Sonuçları:** Sınav sonuçları ve değerlendirme
- ✅ **Admin Dashboard:** Kapsamlı yönetim paneli
- ✅ **Raporlar:** Excel export, detaylı raporlar
- ✅ **OTP Girişi:** Güvenli öğrenci girişi (SMS/Email)

## 🏗️ Mimari

```
┌──────────────┐      ┌──────────────┐      ┌──────────────┐
│  WordPress   │─────▶│  React SPA   │─────▶│  Laravel API │
│  (Mevcut)    │      │  (Frontend)  │      │  (Backend)   │
└──────────────┘      └──────────────┘      └──────┬───────┘
                                                    │
                                            ┌───────▼───────┐
                                            │  MySQL DB     │
                                            └───────────────┘
```

## 📁 Proje Yapısı

```
akademi-renci-takip/
├── backend/              # Laravel API
├── frontend/             # React SPA
├── docs/                 # Dokümantasyon
│   ├── DATABASE_SCHEMA.md
│   ├── API_DOCUMENTATION.md
│   ├── UI_FLOWS.md
│   └── TECH_STACK.md
└── README.md
```

## 🚀 Kurulum

### Gereksinimler

**Backend:**
- PHP 8.2+
- Composer
- MySQL 8.0+
- Apache/Nginx

**Frontend:**
- Node.js 18+
- npm veya yarn

### Backend Kurulumu

```bash
# 1. Laravel kurulumu
cd backend
composer create-project laravel/laravel .

# 2. Gerekli paketleri yükle
composer require laravel/sanctum
composer require maatwebsite/excel
composer require intervention/image
composer require spatie/laravel-activitylog
composer require spatie/laravel-query-builder

# 3. .env dosyasını yapılandır
cp .env.example .env
php artisan key:generate

# .env içinde database ayarlarını düzenle:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=akademi_takip
# DB_USERNAME=root
# DB_PASSWORD=

# 4. Database oluştur
mysql -u root -p -e "CREATE DATABASE akademi_takip CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 5. Migration'ları çalıştır
php artisan migrate

# 6. Seed data'yı yükle
php artisan db:seed

# 7. Storage link oluştur
php artisan storage:link

# 8. Sunucuyu başlat
php artisan serve
```

API: http://localhost:8000/api/v1

### Frontend Kurulumu

```bash
# 1. React + Vite kurulumu
cd frontend
npm create vite@latest . -- --template react
npm install

# 2. Gerekli paketleri yükle
npm install react-router-dom @tanstack/react-query axios zustand
npm install react-hook-form zod @hookform/resolvers
npm install @headlessui/react @heroicons/react
npm install tailwindcss postcss autoprefixer
npm install react-dropzone date-fns @tanstack/react-table
npm install recharts react-hot-toast clsx

# 3. Tailwind CSS yapılandır
npx tailwindcss init -p

# 4. .env dosyasını yapılandır
cp .env.example .env

# .env içinde:
# VITE_API_URL=http://localhost:8000/api/v1

# 5. Development server'ı başlat
npm run dev
```

Frontend: http://localhost:5173

### Production Build

**Backend:**
```bash
cd backend
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Frontend:**
```bash
cd frontend
npm run build
# dist/ klasörü oluşur, bunu web sunucusunda serve et
```

## 📚 Dokümantasyon

- **[Veritabanı Şeması](DATABASE_SCHEMA.md)** - Tüm tablolar, ilişkiler, alanlar
- **[API Dokümantasyonu](API_DOCUMENTATION.md)** - Tüm endpoint'ler, request/response örnekleri
- **[UI Akışları](UI_FLOWS.md)** - Ekran akışları, bileşenler, wireframe'ler
- **[Teknoloji Stack](TECH_STACK.md)** - Kullanılan teknolojiler, mimari kararlar

## 🔐 Güvenlik

- Laravel Sanctum ile API authentication
- CSRF protection
- XSS prevention
- SQL Injection prevention (Eloquent ORM)
- Rate limiting
- Password hashing (bcrypt)
- HTTPS zorunlu (production)

## 🧪 Test

**Backend:**
```bash
cd backend
php artisan test
```

**Frontend:**
```bash
cd frontend
npm run test
```

## 📊 Database Migration

Tüm migration dosyaları `backend/database/migrations/` klasöründe.

```bash
# Migration oluştur
php artisan make:migration create_tablename_table

# Migration çalıştır
php artisan migrate

# Rollback (geri al)
php artisan migrate:rollback

# Tüm migration'ları sıfırla ve yeniden çalıştır
php artisan migrate:fresh --seed
```

## 🎨 Frontend Components

**Reusable Components:**
- `Button` - Butonlar
- `Input` - Form input'ları
- `Select` - Dropdown'lar
- `FileUpload` - Dosya yükleme (drag & drop, kamera)
- `DataTable` - Sıralanabilir, filtrelenebilir tablo
- `Modal` - Modal dialog'lar
- `Card` - Kartlar
- `Badge` - Durum göstergeleri
- `ProgressBar` - İlerleme çubukları
- `Tabs` - Tab navigasyon

## 🔧 Konfigürasyon

### Backend (.env)
```env
APP_NAME="Akademi Takip"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.akademi.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=akademi_takip
DB_USERNAME=root
DB_PASSWORD=

# SMS API (Netgsm, İleti Merkezi vb.)
SMS_API_KEY=your_api_key
SMS_API_URL=https://api.example.com

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@akademi.com
```

### Frontend (.env)
```env
VITE_API_URL=https://api.akademi.com/api/v1
VITE_APP_NAME="Akademi Öğrenci Takip"
```

## 🚀 Deployment

### Shared Hosting (cPanel)

**Backend:**
1. Composer ile vendor'ları yükle
2. `.env` dosyasını yapılandır
3. `public` klasörünü `public_html/api` olarak yükle
4. Diğer dosyaları `api-backend` gibi bir klasöre yükle
5. `.htaccess` düzenle
6. `php artisan migrate`
7. `php artisan storage:link`

**Frontend:**
1. `npm run build` ile production build al
2. `dist/` içeriğini `public_html/app` dizinine yükle
3. `.htaccess` ile routing düzenle

### VPS/Dedicated Server

**Backend:**
```bash
# Nginx yapılandırması
server {
    listen 80;
    server_name api.akademi.com;
    root /var/www/backend/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

**Frontend:**
```bash
# Nginx yapılandırması
server {
    listen 80;
    server_name app.akademi.com;
    root /var/www/frontend/dist;

    index index.html;

    location / {
        try_files $uri $uri/ /index.html;
    }
}
```

## 📞 Destek

Herhangi bir sorun için:
- Email: destek@akademi.com
- Telefon: +90 312 123 45 67

## 📝 Lisans

Proprietary - Tüm hakları saklıdır.

## 👨‍💻 Geliştirici

Geliştirilme tarihi: Ocak 2025
Versiyon: 1.0.0

