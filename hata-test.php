<?php
/**
 * HATA TEST SAYFASI
 * URL: https://demosu.gen.tr/hafriyat/hata-test.php
 */

// Tüm hataları göster
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h1>🔍 Hata Testi</h1>";
echo "<hr>";

// 1. PHP Versiyonu
echo "<h2>1. PHP Versiyonu</h2>";
echo "PHP: " . phpversion() . "<br>";
echo "Minimum Gerekli: 7.4<br>";
if (version_compare(PHP_VERSION, '7.4.0') >= 0) {
    echo "✅ PHP versiyonu uygun<br>";
} else {
    echo "❌ PHP versiyonu çok eski!<br>";
}
echo "<hr>";

// 2. Dosya Yolları
echo "<h2>2. Dosya Yolları</h2>";
echo "__FILE__: " . __FILE__ . "<br>";
echo "__DIR__: " . __DIR__ . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<hr>";

// 3. Config Test
echo "<h2>3. Config Dosyası</h2>";
$configPath = __DIR__ . '/config.php';
if (file_exists($configPath)) {
    echo "✅ config.php dosyası var<br>";
    echo "Yol: $configPath<br>";

    try {
        require_once $configPath;
        echo "✅ config.php yüklendi<br>";

        if (defined('SITE_URL')) {
            echo "✅ SITE_URL tanımlı: " . SITE_URL . "<br>";
        } else {
            echo "❌ SITE_URL tanımlı değil!<br>";
        }

        if (defined('BASE_PATH')) {
            echo "✅ BASE_PATH tanımlı: " . BASE_PATH . "<br>";
        } else {
            echo "❌ BASE_PATH tanımlı değil!<br>";
        }

    } catch (Exception $e) {
        echo "❌ config.php yüklenirken hata: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ config.php dosyası bulunamadı!<br>";
}
echo "<hr>";

// 4. Database Sınıfı
echo "<h2>4. Database Sınıfı</h2>";
$dbClassPath = __DIR__ . '/includes/classes/Database.php';
if (file_exists($dbClassPath)) {
    echo "✅ Database.php var<br>";

    try {
        if (class_exists('Database')) {
            echo "✅ Database sınıfı yüklü<br>";

            // Bağlantı testi
            try {
                $db = Database::getInstance();
                echo "✅ Veritabanı bağlantısı BAŞARILI!<br>";

                // Tablo sayısı
                $tables = $db->fetchAll("SHOW TABLES");
                echo "✅ Tablo sayısı: " . count($tables) . "<br>";

            } catch (Exception $e) {
                echo "❌ Veritabanı bağlantı hatası: " . $e->getMessage() . "<br>";
                echo "<br><strong>Çözüm:</strong> config.php'deki DB bilgilerini kontrol edin<br>";
            }

        } else {
            echo "❌ Database sınıfı yüklenemedi<br>";
        }
    } catch (Exception $e) {
        echo "❌ Hata: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Database.php dosyası bulunamadı!<br>";
}
echo "<hr>";

// 5. Functions
echo "<h2>5. Functions Dosyası</h2>";
$functionsPath = __DIR__ . '/includes/functions.php';
if (file_exists($functionsPath)) {
    echo "✅ functions.php var<br>";

    if (function_exists('siteUrl')) {
        echo "✅ siteUrl() fonksiyonu tanımlı<br>";
        try {
            $testUrl = siteUrl('test');
            echo "Test URL: " . $testUrl . "<br>";
        } catch (Exception $e) {
            echo "❌ siteUrl() hatası: " . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "❌ functions.php bulunamadı!<br>";
}
echo "<hr>";

// 6. Klasör İzinleri
echo "<h2>6. Klasör İzinleri</h2>";
$dirs = ['assets/img', 'assets/img/slider', 'assets/img/hizmetler'];
foreach ($dirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    if (is_dir($fullPath)) {
        if (is_writable($fullPath)) {
            echo "✅ $dir - Yazılabilir<br>";
        } else {
            echo "⚠️ $dir - Yazılamıyor (chmod 755 yapın)<br>";
        }
    } else {
        echo "❌ $dir - Klasör yok!<br>";
    }
}
echo "<hr>";

// 7. index.php Test
echo "<h2>7. index.php Test</h2>";
$indexPath = __DIR__ . '/index.php';
if (file_exists($indexPath)) {
    echo "✅ index.php var<br>";
    echo "<a href='index.php' target='_blank'>index.php'yi aç (doğrudan)</a><br>";
} else {
    echo "❌ index.php yok!<br>";
}
echo "<hr>";

// 8. .htaccess
echo "<h2>8. .htaccess</h2>";
$htaccessPath = __DIR__ . '/.htaccess';
if (file_exists($htaccessPath)) {
    echo "✅ .htaccess var<br>";
    echo "<small>İçerik (ilk 10 satır):</small><pre>";
    $lines = file($htaccessPath);
    echo htmlspecialchars(implode('', array_slice($lines, 0, 10)));
    echo "</pre>";
} else {
    echo "❌ .htaccess yok!<br>";
}
echo "<hr>";

echo "<h2>✅ Sonraki Adımlar</h2>";
echo "<ol>";
echo "<li>Yukarıdaki ❌ işaretli hataları düzeltin</li>";
echo "<li><a href='index.php'>index.php</a> (doğrudan) çalışıyor mu test edin</li>";
echo "<li>Çalışıyorsa .htaccess sorunudur</li>";
echo "<li>Çalışmıyorsa PHP/config sorunudur</li>";
echo "</ol>";

echo "<hr>";
echo "<p><small>Test Zamanı: " . date('Y-m-d H:i:s') . "</small></p>";
?>
