<?php
/**
 * Emir Hafriyat - Konfigürasyon
 * SADECE İŞARETLİ SATIRLARI DEĞİŞTİRİN!
 */

// Hata gösterimi (Test için açık, canlıda kapatın)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ═══════════════════════════════════════════════════════════════
// VERİTABANI AYARLARI
// ═══════════════════════════════════════════════════════════════
define('DB_HOST', 'localhost');
define('DB_NAME', 'emirhafriyat');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_CHARSET', 'utf8mb4');

// ═══════════════════════════════════════════════════════════════
// SİTE URL
// ═══════════════════════════════════════════════════════════════
define('SITE_URL', 'http://localhost/hafriyat');  // Sunucuya yüklerken değiştir

// ═══════════════════════════════════════════════════════════════
// DİĞER AYARLAR - DOKUNMAYIN!
// ═══════════════════════════════════════════════════════════════
define('BASE_PATH', __DIR__);
date_default_timezone_set('Europe/Istanbul');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function($class) {
    $file = BASE_PATH . '/includes/classes/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once BASE_PATH . '/includes/functions.php';
