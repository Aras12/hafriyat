<?php
/**
 * Test Dosyası - Kurulum Kontrolü
 * URL: https://demosu.gen.tr/hafriyat/test.php
 */

echo "<h1>🔍 Kayseri Emir Hafriyat - Kurulum Testi</h1>";
echo "<hr>";

// PHP Versiyonu
echo "<h2>✅ PHP Versiyonu</h2>";
echo "PHP: " . phpversion() . "<br>";
echo "Gerekli: PHP 7.4+<br>";
echo "<hr>";

// Veritabanı Bağlantısı Testi
echo "<h2>🔌 Veritabanı Bağlantısı</h2>";
try {
    require_once 'config.php';
    $db = Database::getInstance();
    echo "✅ Veritabanı bağlantısı BAŞARILI!<br>";

    // Tabloları kontrol et
    $tables = $db->fetchAll("SHOW TABLES");
    echo "✅ Toplam tablo sayısı: " . count($tables) . "<br>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>" . array_values($table)[0] . "</li>";
    }
    echo "</ul>";

} catch (Exception $e) {
    echo "❌ Veritabanı HATASI: " . $e->getMessage() . "<br>";
    echo "<br><strong>Çözüm:</strong> config.php dosyasındaki veritabanı bilgilerini kontrol edin.<br>";
}

echo "<hr>";

// Dosya İzinleri
echo "<h2>📁 Dosya İzinleri</h2>";
$dirs = [
    'assets/img/',
    'assets/img/slider/',
    'assets/img/hizmetler/',
    'assets/img/blog/',
    'assets/img/galeri/',
    'assets/img/projeler/'
];

foreach ($dirs as $dir) {
    if (is_writable($dir)) {
        echo "✅ $dir - Yazılabilir<br>";
    } else {
        echo "❌ $dir - Yazılamaz (chmod 755 yapın)<br>";
    }
}

echo "<hr>";

// URL Testi
echo "<h2>🔗 URL Yapılandırması</h2>";
echo "SITE_URL: " . SITE_URL . "<br>";
echo "BASE_PATH: " . BASE_PATH . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";

echo "<hr>";
echo "<h2>📝 Sonraki Adımlar</h2>";
echo "<ol>";
echo "<li>Eğer tüm testler başarılı ise, <a href='" . SITE_URL . "'>Ana Sayfayı</a> ziyaret edin</li>";
echo "<li><a href='" . SITE_URL . "/admin/'>Admin Panele</a> giriş yapın (admin / admin123)</li>";
echo "<li>Bu test dosyasını silin (güvenlik için)</li>";
echo "</ol>";

echo "<hr>";
echo "<small>Test Zamanı: " . date('Y-m-d H:i:s') . "</small>";
?>
