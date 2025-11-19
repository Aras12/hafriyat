<?php
/**
 * Kayseri Emir Hafriyat - Konfigürasyon Dosyası
 * Bu dosyayı sunucunuza göre düzenleyin
 */

// Hata raporlama (Production'da kapatılmalı)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı ayarları
define('DB_HOST', 'localhost');
define('DB_NAME', 'emirhafriyat_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Site ayarları
define('SITE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));
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
