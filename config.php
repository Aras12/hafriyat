<?php
/**
 * Kayseri Emir Hafriyat - Konfigürasyon Dosyası
 */

// Hata raporlama (Test için açık, canlıya aldığınızda kapatın)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı ayarları - SİZİN BİLGİLERİNİZ
define('DB_HOST', 'localhost');
define('DB_NAME', 'emirhafriyat_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ============================================
// SİTE URL AYARI - DURUMUNUZA GÖRE SEÇİN!
// ============================================

// DURUM 1: Addon domain ROOT'ta (https://demosu.gen.tr)
// define('SITE_URL', 'https://demosu.gen.tr');

// DURUM 2: Alt klasörde (https://demosu.gen.tr/hafriyat)
define('SITE_URL', 'https://demosu.gen.tr/hafriyat');

// DURUM 3: Başka bir addon domain (https://kayseriemirhafriyat.com.tr)
// define('SITE_URL', 'https://kayseriemirhafriyat.com.tr');

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
