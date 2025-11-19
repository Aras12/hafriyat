<?php
/**
 * Kayseri Emir Hafriyat - Konfigürasyon Dosyası
 * cPanel + MySQL için
 */

// Hata raporlama (canlıya aldığınızda kapatın)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı ayarları - BUNLARI DEĞİŞTİRİN!
define('DB_HOST', 'localhost');
define('DB_NAME', 'VERITABANI_ADINIZ');     // cPanel'de oluşturduğunuz DB adı
define('DB_USER', 'KULLANICI_ADINIZ');      // cPanel DB kullanıcısı
define('DB_PASS', 'SIFRENIZ');              // cPanel DB şifresi
define('DB_CHARSET', 'utf8mb4');

// Site URL - TAM ADRES (SONUNDA / OLMADAN!)
define('SITE_URL', 'https://demosu.gen.tr/hafriyat');
define('BASE_PATH', __DIR__);

// Timezone
date_default_timezone_set('Europe/Istanbul');

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoload
spl_autoload_register(function($class) {
    $file = BASE_PATH . '/includes/classes/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Yardımcı fonksiyonlar
require_once BASE_PATH . '/includes/functions.php';
