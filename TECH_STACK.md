# TEKNOLOJİ STACK VE MİMARİ

## GENEL MİMARİ

```
┌─────────────────────────────────────────────────────────────┐
│                        USER / CLIENT                        │
└───────────────────────┬─────────────────────────────────────┘
                        │
        ┌───────────────┴────────────────┐
        │                                │
┌───────▼────────┐              ┌────────▼────────┐
│   WordPress    │              │  React SPA      │
│   (Mevcut)     │              │  (Frontend)     │
│                │              │                 │
│  - Ana Site    │◄─────────────┤  - Kayıt        │
│  - Link/Button │   iframe/    │  - Dashboard    │
│                │   redirect   │  - Admin        │
└────────────────┘              └────────┬────────┘
                                         │
                                    HTTP/REST
                                         │
                        ┌────────────────▼────────────────┐
                        │   Laravel API (Backend)         │
                        │                                 │
                        │  - RESTful API                  │
                        │  - Authentication (Sanctum)     │
                        │  - Business Logic               │
                        │  - File Storage                 │
                        └────────────┬────────────────────┘
                                     │
                        ┌────────────▼────────────────┐
                        │   MySQL Database            │
                        │                             │
                        │  - Öğrenciler               │
                        │  - Sınıflar                 │
                        │  - Dersler                  │
                        │  - ... (tüm tablolar)       │
                        └─────────────────────────────┘
```

---

## BACKEND STACK

### Laravel 11.x
**Neden Laravel?**
- ✅ Modern PHP framework
- ✅ Güçlü ORM (Eloquent)
- ✅ Built-in API support
- ✅ Kolay authentication (Sanctum)
- ✅ Migration ve seeding
- ✅ Validation
- ✅ File storage
- ✅ Job queue (gelecek için)
- ✅ Türkiye'de yaygın kullanım
- ✅ Shared hosting desteği

**Paketler:**
```json
{
  "require": {
    "php": "^8.2",
    "laravel/framework": "^11.0",
    "laravel/sanctum": "^4.0",
    "laravel/tinker": "^2.9",
    "maatwebsite/excel": "^3.1",
    "intervention/image": "^3.0",
    "spatie/laravel-activitylog": "^4.8",
    "spatie/laravel-query-builder": "^5.8",
    "thephpleague/flysystem-aws-s3-v3": "^3.0"
  },
  "require-dev": {
    "laravel/pint": "^1.13",
    "laravel/sail": "^1.26",
    "fakerphp/faker": "^1.23",
    "mockery/mockery": "^1.6",
    "nunomaduro/collision": "^8.0",
    "phpunit/phpunit": "^11.0"
  }
}
```

---

## FRONTEND STACK

### React 18 + Vite
**Neden React + Vite?**
- ✅ Modern, component-based
- ✅ Virtual DOM (performans)
- ✅ Büyük ekosistem
- ✅ Vite: ultra-fast build
- ✅ HMR (Hot Module Replacement)
- ✅ WordPress'e entegre edilebilir
- ✅ Mobil uyumlu

**Paketler:**
```json
{
  "dependencies": {
    "react": "^18.2.0",
    "react-dom": "^18.2.0",
    "react-router-dom": "^6.21.0",
    "@tanstack/react-query": "^5.17.0",
    "axios": "^1.6.5",
    "zustand": "^4.4.7",
    "react-hook-form": "^7.49.3",
    "zod": "^3.22.4",
    "@headlessui/react": "^1.7.17",
    "@heroicons/react": "^2.1.1",
    "tailwindcss": "^3.4.1",
    "react-dropzone": "^14.2.3",
    "date-fns": "^3.0.6",
    "@tanstack/react-table": "^8.11.3",
    "recharts": "^2.10.3",
    "react-hot-toast": "^2.4.1",
    "clsx": "^2.1.0"
  },
  "devDependencies": {
    "@types/react": "^18.2.48",
    "@types/react-dom": "^18.2.18",
    "@vitejs/plugin-react": "^4.2.1",
    "vite": "^5.0.11",
    "autoprefixer": "^10.4.16",
    "postcss": "^8.4.33",
    "eslint": "^8.56.0",
    "prettier": "^3.1.1"
  }
}
```

---

## DATABASE

### MySQL 8.0
**Neden MySQL?**
- ✅ Yaygın kullanım
- ✅ Shared hosting desteği
- ✅ Laravel native support
- ✅ Güçlü indexing
- ✅ JSON column desteği

**Alternatif:** PostgreSQL (daha gelişmiş özellikler için)

---

## AUTHENTICATION

### Laravel Sanctum
**Özellikler:**
- ✅ API token authentication
- ✅ SPA authentication
- ✅ Cookie-based sessions
- ✅ CSRF protection
- ✅ Token abilities (permissions)

**OTP İçin:**
- SMS: Türk operatörlere özel SMS API (Netgsm, İleti Merkezi vb.)
- Email: Laravel Mail + SMTP

---

## UI / STYLING

### Tailwind CSS
**Neden Tailwind?**
- ✅ Utility-first
- ✅ Responsive design
- ✅ Dark mode desteği
- ✅ Küçük bundle size (PurgeCSS ile)
- ✅ Özelleştirilebilir

### Headless UI
**Neden Headless UI?**
- ✅ Accessible components
- ✅ Tailwind ile uyumlu
- ✅ Unstyled, tamamen özelleştirilebilir
- ✅ React desteği

**Alternatif:** Radix UI, shadcn/ui

---

## STATE MANAGEMENT

### Zustand (Client State)
**Neden Zustand?**
- ✅ Minimal API
- ✅ Redux'tan daha basit
- ✅ TypeScript desteği
- ✅ Middleware desteği

### React Query (Server State)
**Neden React Query?**
- ✅ API data fetching
- ✅ Caching
- ✅ Automatic refetching
- ✅ Optimistic updates
- ✅ Error handling

---

## FORM MANAGEMENT

### React Hook Form + Zod
**Neden RHF?**
- ✅ Performant (uncontrolled)
- ✅ Minimal re-renders
- ✅ Kolay validasyon

**Neden Zod?**
- ✅ TypeScript-first schema validation
- ✅ Type inference
- ✅ RHF ile mükemmel entegrasyon

---

## FILE UPLOADS

### Frontend: React Dropzone
- Drag & drop
- Kamera erişimi (mobil)
- File validation
- Preview

### Backend: Laravel Storage
- Local storage
- S3 desteği (gelecek için)
- Public/private disks

---

## DATA TABLE

### TanStack Table (React Table v8)
**Özellikler:**
- ✅ Headless (tamamen özelleştirilebilir)
- ✅ Sorting
- ✅ Filtering
- ✅ Pagination
- ✅ Row selection
- ✅ Virtualization

---

## CHARTS

### Recharts
**Özellikler:**
- ✅ React-native chart library
- ✅ Declarative
- ✅ Responsive
- ✅ Animasyonlar

---

## EXCEL IMPORT/EXPORT

### Backend: Maatwebsite/Laravel-Excel
- Excel okuma/yazma
- CSV desteği
- Toplu import
- Export templates

### Frontend: SheetJS (xlsx)
- Client-side Excel okuma (opsiyonel)

---

## LOGGING & MONITORING

### Activity Log
**Spatie Laravel ActivityLog:**
- Tüm CRUD işlemlerini logla
- User tracking
- Changes tracking

### Error Logging
- Laravel Log
- Sentry (production için önerilir)

---

## TESTING

### Backend
- **PHPUnit:** Unit & Feature tests
- **Laravel Dusk:** Browser tests (opsiyonel)

### Frontend
- **Vitest:** Unit tests
- **React Testing Library:** Component tests
- **Playwright:** E2E tests (opsiyonel)

---

## DEPLOYMENT & DEVOPS

### Development
```bash
# Backend
php artisan serve

# Frontend
npm run dev
```

### Production

**Backend (Laravel):**
- Apache/Nginx
- PHP 8.2+
- Composer
- MySQL 8.0
- .env konfigürasyonu

**Frontend (React):**
- Build: `npm run build`
- Output: `dist/` folder
- Serve: Nginx/Apache static files
- Veya: WordPress içine embed

### Deployment Seçenekleri

**1. Ayrı Subdomain (Önerilen)**
```
api.akademi.com     → Laravel backend
app.akademi.com     → React frontend
www.akademi.com     → WordPress (mevcut)
```

**2. Alt Klasör**
```
akademi.com         → WordPress
akademi.com/api     → Laravel backend
akademi.com/app     → React frontend
```

**3. WordPress Plugin (Gelişmiş)**
- Laravel'i WordPress plugin olarak package
- React'i WordPress içine embed
- Daha karmaşık, ancak tek domain

---

## WORDPRESS ENTEGRASYONU

### Seçenek 1: Link/Redirect (Basit, Önerilen)
WordPress'te butonlar:
```html
<a href="https://app.akademi.com/kayit">Öğrenci Kayıt</a>
<a href="https://app.akademi.com/giris/ogrenci">Öğrenci Girişi</a>
<a href="https://app.akademi.com/giris/admin">Admin Girişi</a>
```

### Seçenek 2: iFrame
WordPress sayfasında React uygulamasını iframe içinde göster:
```html
<iframe src="https://app.akademi.com/kayit"
        style="width:100%; height:100vh; border:none;">
</iframe>
```

### Seçenek 3: WordPress Plugin
Custom plugin oluştur:
- Laravel API'yi call eden PHP kod
- React build'i plugin içine embed
- WordPress admin panelinden yönetim

**Öneri:** Seçenek 1 (Link/Redirect) - En basit ve bakımı kolay

---

## GÜVENLİK

### Backend
- ✅ Laravel Sanctum (API tokens)
- ✅ CSRF protection
- ✅ SQL Injection prevention (Eloquent ORM)
- ✅ XSS prevention (Blade/escape)
- ✅ Rate limiting
- ✅ Password hashing (bcrypt)
- ✅ HTTPS zorunlu (production)
- ✅ CORS configuration

### Frontend
- ✅ Token storage (httpOnly cookie veya localStorage)
- ✅ XSS prevention (React default escape)
- ✅ Input sanitization
- ✅ HTTPS

### Database
- ✅ Encrypted sensitive data (önerilir)
- ✅ Regular backups
- ✅ Secure credentials (.env)

---

## PERFORMANS

### Backend
- ✅ Eloquent eager loading (N+1 problem)
- ✅ Query optimization
- ✅ Redis cache (opsiyonel)
- ✅ Job queue (ağır işlemler için)
- ✅ API response caching

### Frontend
- ✅ Code splitting (React.lazy)
- ✅ Image optimization (WebP)
- ✅ Lazy loading
- ✅ React Query caching
- ✅ Debouncing (search, filters)
- ✅ Virtualization (long lists)

### Database
- ✅ Indexing (foreign keys, search fields)
- ✅ Query optimization
- ✅ Pagination

---

## SCALABILITY

**Horizontal Scaling:**
- Load balancer (gelecek için)
- Multiple backend instances
- Shared storage (S3)
- Redis session store

**Vertical Scaling:**
- Daha güçlü sunucu
- Database optimization
- Caching

---

## BACKUP & RECOVERY

- ✅ Daily database backup
- ✅ File storage backup
- ✅ Version control (Git)
- ✅ Migration rollback strategy

---

## VERSIONING

- **API:** `/api/v1/...` (future-proof)
- **Git:** Feature branches, semantic versioning
- **Database:** Migrations (reversible)

---

## DOCUMENTATION

- ✅ API: Postman collection / OpenAPI (Swagger)
- ✅ Code: Inline comments
- ✅ Database: ER Diagrams
- ✅ User: Screen recordings / PDF guides

---

## GELIŞTIRME ORTAMI

### Backend (Laravel)
```bash
# Gereksinimler
PHP 8.2+
Composer
MySQL 8.0
Node.js 18+ (Asset compilation için)

# Kurulum
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

### Frontend (React)
```bash
# Gereksinimler
Node.js 18+
npm veya yarn

# Kurulum
npm install
cp .env.example .env
npm run dev
```

### Docker (Opsiyonel)
**Laravel Sail:**
```bash
# Docker-based development
./vendor/bin/sail up
./vendor/bin/sail artisan migrate
```

---

## PROJE YAPISI

### Backend (Laravel)
```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── Auth/
│   │   │   │   │   ├── OgrenciAuthController.php
│   │   │   │   │   └── AdminAuthController.php
│   │   │   │   ├── Ogrenci/
│   │   │   │   │   ├── ProfilController.php
│   │   │   │   │   ├── DersProgramiController.php
│   │   │   │   │   ├── OdemeController.php
│   │   │   │   │   └── EvrakController.php
│   │   │   │   ├── Admin/
│   │   │   │   │   ├── DashboardController.php
│   │   │   │   │   ├── OgrenciController.php
│   │   │   │   │   ├── SinifController.php
│   │   │   │   │   ├── DersProgramiController.php
│   │   │   │   │   └── RaporController.php
│   │   │   │   ├── Kayit/
│   │   │   │   │   └── KayitController.php
│   │   │   │   └── Genel/
│   │   │   │       └── GenelController.php
│   │   ├── Middleware/
│   │   │   ├── CheckRole.php
│   │   │   └── LogActivity.php
│   │   ├── Requests/
│   │   │   ├── OgrenciKayitRequest.php
│   │   │   └── ...
│   │   └── Resources/
│   │       ├── OgrenciResource.php
│   │       └── ...
│   ├── Models/
│   │   ├── Ogrenci.php
│   │   ├── Sinif.php
│   │   ├── Ders.php
│   │   ├── Egitmen.php
│   │   ├── Firma.php
│   │   ├── User.php
│   │   └── ...
│   ├── Services/
│   │   ├── OtpService.php
│   │   ├── SmsService.php
│   │   ├── ExcelService.php
│   │   └── ...
│   └── Observers/
│       └── OgrenciObserver.php
├── database/
│   ├── migrations/
│   │   ├── 2025_01_01_000001_create_ogrenciler_table.php
│   │   ├── 2025_01_01_000002_create_siniflar_table.php
│   │   └── ...
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── FirmaSeeder.php
│   │   ├── DersSeeder.php
│   │   └── AdminUserSeeder.php
│   └── factories/
│       └── OgrenciFactory.php
├── routes/
│   ├── api.php
│   └── web.php
├── storage/
│   ├── app/
│   │   ├── public/
│   │   │   ├── kimlik/
│   │   │   ├── evrak/
│   │   │   └── profil/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env.example
├── composer.json
└── artisan
```

### Frontend (React)
```
frontend/
├── public/
│   ├── index.html
│   └── favicon.ico
├── src/
│   ├── api/
│   │   ├── client.js
│   │   ├── auth.js
│   │   ├── ogrenci.js
│   │   ├── admin.js
│   │   └── kayit.js
│   ├── components/
│   │   ├── common/
│   │   │   ├── Button.jsx
│   │   │   ├── Input.jsx
│   │   │   ├── Select.jsx
│   │   │   ├── FileUpload.jsx
│   │   │   ├── DataTable.jsx
│   │   │   ├── Modal.jsx
│   │   │   ├── Card.jsx
│   │   │   ├── Badge.jsx
│   │   │   ├── ProgressBar.jsx
│   │   │   └── Tabs.jsx
│   │   ├── layout/
│   │   │   ├── Header.jsx
│   │   │   ├── Sidebar.jsx
│   │   │   ├── Footer.jsx
│   │   │   └── Layout.jsx
│   │   ├── kayit/
│   │   │   ├── ProgramSecimi.jsx
│   │   │   ├── KVKKOnay.jsx
│   │   │   ├── KimlikFotograf.jsx
│   │   │   ├── KisiselBilgiler.jsx
│   │   │   ├── IletisimBilgileri.jsx
│   │   │   ├── OdemeBilgileri.jsx
│   │   │   ├── EvrakDurumu.jsx
│   │   │   └── Ozet.jsx
│   │   ├── ogrenci/
│   │   │   ├── Dashboard.jsx
│   │   │   ├── Profil.jsx
│   │   │   ├── DersProgrami.jsx
│   │   │   ├── OdemeDurumu.jsx
│   │   │   ├── HarcHakki.jsx
│   │   │   └── EvrakYukleme.jsx
│   │   └── admin/
│   │       ├── Dashboard.jsx
│   │       ├── OgrenciListesi.jsx
│   │       ├── OgrenciDetay.jsx
│   │       ├── SinifYonetimi.jsx
│   │       └── DersProgramiYonetimi.jsx
│   ├── pages/
│   │   ├── kayit/
│   │   │   ├── KayitPage.jsx
│   │   │   └── KayitTamamlandi.jsx
│   │   ├── giris/
│   │   │   ├── OgrenciGiris.jsx
│   │   │   └── AdminGiris.jsx
│   │   ├── ogrenci/
│   │   │   └── OgrenciDashboard.jsx
│   │   └── admin/
│   │       └── AdminDashboard.jsx
│   ├── hooks/
│   │   ├── useAuth.js
│   │   ├── useOgrenci.js
│   │   └── useDebounce.js
│   ├── store/
│   │   ├── authStore.js
│   │   └── uiStore.js
│   ├── utils/
│   │   ├── validation.js
│   │   ├── formatters.js
│   │   └── constants.js
│   ├── styles/
│   │   └── index.css
│   ├── App.jsx
│   ├── main.jsx
│   └── routes.jsx
├── .env.example
├── package.json
├── vite.config.js
├── tailwind.config.js
└── index.html
```

---

## DEVELOPMENT WORKFLOW

1. **Feature Branch**
   ```bash
   git checkout -b feature/ogrenci-kayit
   ```

2. **Backend Development**
   ```bash
   # Migration oluştur
   php artisan make:migration create_ogrenciler_table

   # Model & Controller
   php artisan make:model Ogrenci -mcr

   # Request validation
   php artisan make:request OgrenciKayitRequest
   ```

3. **Frontend Development**
   ```bash
   # Component oluştur
   # React Query hook
   # Form integration
   ```

4. **Testing**
   ```bash
   # Backend
   php artisan test

   # Frontend
   npm run test
   ```

5. **Commit & Push**
   ```bash
   git add .
   git commit -m "feat: öğrenci kayıt formu"
   git push origin feature/ogrenci-kayit
   ```

---

## SONUÇ

Bu stack ile:
- ✅ Modern, ölçeklenebilir mimari
- ✅ Kolay bakım ve geliştirme
- ✅ WordPress entegrasyonu
- ✅ Mobil uyumlu
- ✅ Güvenli
- ✅ Performanslı
- ✅ Türkiye'deki hosting firmalarıyla uyumlu

