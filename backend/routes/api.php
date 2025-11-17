<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Health check
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'Özel Güvenlik Eğitim API çalışıyor!',
            'version' => '1.0.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    });

    // Program türlerini listele
    Route::get('/kayit/program-turleri', function () {
        return response()->json([
            'success' => true,
            'data' => [
                [
                    'kod' => 'T1',
                    'ad' => 'Temel Silahlı',
                    'aciklama' => 'İlk kez gelen, silahlı eğitim',
                    'silahli' => true,
                    'ucret' => 5000.00,
                    'sure_gun' => 120,
                ],
                [
                    'kod' => 'T2',
                    'ad' => 'Temel Silahsız',
                    'aciklama' => 'İlk kez gelen, silahsız eğitim',
                    'silahli' => false,
                    'ucret' => 4000.00,
                    'sure_gun' => 90,
                ],
                [
                    'kod' => 'Y1',
                    'ad' => 'Yenileme Silahlı',
                    'aciklama' => '4 yılda bir zorunlu yenileme, silahlı',
                    'silahli' => true,
                    'ucret' => 3000.00,
                    'sure_gun' => 40,
                ],
                [
                    'kod' => 'Y2',
                    'ad' => 'Yenileme Silahsız',
                    'aciklama' => '4 yılda bir zorunlu yenileme, silahsız',
                    'silahli' => false,
                    'ucret' => 2500.00,
                    'sure_gun' => 40,
                ],
                [
                    'kod' => 'T3',
                    'ad' => 'Silahsızdan Silahlıya Geçiş',
                    'aciklama' => 'Geçiş eğitimi',
                    'silahli' => true,
                    'ucret' => 2000.00,
                    'sure_gun' => 30,
                ],
            ],
        ]);
    });

    // KVKK metni
    Route::get('/kayit/kvkk-metni', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'kvkk_metni' => 'KVKK Aydınlatma Metni: Kişisel verileriniz 6698 sayılı KVKK kapsamında işlenmektedir...',
                'aydinlatma_metni' => 'Aydınlatma Metni: Kurumumuz tarafından toplanan kişisel verileriniz...',
                'versiyon' => '1.0',
                'guncelleme_tarihi' => '2025-01-01',
            ],
        ]);
    });

    // İller listesi
    Route::get('/genel/iller', function () {
        return response()->json([
            'success' => true,
            'data' => [
                [
                    'il_adi' => 'Ankara',
                    'ilceler' => ['Çankaya', 'Keçiören', 'Yenimahalle', 'Mamak', 'Etimesgut'],
                ],
                [
                    'il_adi' => 'İstanbul',
                    'ilceler' => ['Kadıköy', 'Beşiktaş', 'Şişli', 'Üsküdar', 'Beyoğlu'],
                ],
                [
                    'il_adi' => 'İzmir',
                    'ilceler' => ['Konak', 'Karşıyaka', 'Bornova', 'Buca', 'Bayraklı'],
                ],
            ],
        ]);
    });

    // Sistem bilgisi
    Route::get('/info', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'app_name' => config('app.name'),
                'version' => '1.0.0',
                'laravel_version' => app()->version(),
                'php_version' => PHP_VERSION,
                'timezone' => config('app.timezone'),
                'environment' => config('app.env'),
                'debug_mode' => config('app.debug'),
                'migrations_ready' => '17 tablo migration dosyası hazır',
                'database_status' => 'Yapılandırma bekleniyor',
                'endpoints' => [
                    'GET /api/v1/health' => 'Health check',
                    'GET /api/v1/kayit/program-turleri' => 'Program türlerini listele',
                    'GET /api/v1/kayit/kvkk-metni' => 'KVKK metni',
                    'GET /api/v1/genel/iller' => 'İl/ilçe listesi',
                    'GET /api/v1/info' => 'Sistem bilgisi',
                ],
                'next_steps' => [
                    '1. Database yapılandırması (MySQL/PostgreSQL)',
                    '2. Migration\'ları çalıştır: php artisan migrate',
                    '3. Seed data ekle',
                    '4. Controller\'ları implement et',
                    '5. Frontend entegrasyonu',
                ],
            ],
        ]);
    });

});
