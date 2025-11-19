/**
 * ============================================
 * KAYSERİ EMİR HAFRİYAT - HIZLI KURULUM
 * ============================================
 *
 * Bu dosyadaki ayarları sunucunuza göre düzenleyin.
 * Daha sonra dosya adını config.php olarak değiştirin.
 */

<?php

// ============================================
// 1. VERİTABANI AYARLARI (MUTLAKA DEĞİŞTİRİN!)
// ============================================
define('DB_HOST', 'localhost');              // Genellikle 'localhost' olur
define('DB_NAME', 'emirhafriyat_db');        // Veritabanı adınız
define('DB_USER', 'root');                   // Veritabanı kullanıcı adı
define('DB_PASS', '');                       // Veritabanı şifresi
define('DB_CHARSET', 'utf8mb4');

// ============================================
// 2. SİTE URL (MUTLAKA DEĞİŞTİRİN!)
// ============================================
// Sitenizi nereye kurdunuz? (sonunda / OLMADAN)
//
// Örnekler:
// Ana dizin:    https://kayseriemirhafriyat.com.tr
// Alt klasör:   https://demosu.gen.tr/hafriyat
// Alt klasör 2: https://siteniz.com/emirhafriyat

define('SITE_URL', 'https://demosu.gen.tr/hafriyat');

// ============================================
// 3. HATA RAPORLAMA (Production'da kapatın)
// ============================================
// Test ederken açık tutun, canlıya aldığınızda kapatın
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Canlıya aldığınızda bu satırları kullanın:
// error_reporting(0);
// ini_set('display_errors', 0);

// ============================================
// 4. DİĞER AYARLAR (Değiştirmeyin)
// ============================================
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

/**
 * ============================================
 * KURULUM KONTROL LİSTESİ
 * ============================================
 *
 * ✅ 1. Veritabanı oluşturdunuz mu?
 * ✅ 2. database.sql dosyasını import ettiniz mi?
 * ✅ 3. DB_NAME, DB_USER, DB_PASS ayarladınız mı?
 * ✅ 4. SITE_URL doğru mu? (test.php ile kontrol edin)
 * ✅ 5. .htaccess dosyası yüklendi mi?
 * ✅ 6. assets/img/ klasörü yazılabilir mi? (chmod 755)
 *
 * Test için: https://siteniz.com/test.php
 * Admin: https://siteniz.com/admin/ (admin / admin123)
 *
 * Sorun mu var? KURULUM.txt dosyasını okuyun!
 */
?>
