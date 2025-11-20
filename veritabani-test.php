<?php
/**
 * VERİTABANI BAĞLANTI TESTİ
 * Bu dosyayı tarayıcıda açın: https://adanaotokokusu.com.tr/veritabani-test.php
 */

echo "<h1>Veritabanı Test Sonuçları</h1>";
echo "<hr>";

// Config.php'yi yükle
require_once 'config.php';

echo "<h2>1. Config Ayarları:</h2>";
echo "<pre>";
echo "DB_HOST: " . DB_HOST . "\n";
echo "DB_NAME: " . DB_NAME . "\n";
echo "DB_USER: " . DB_USER . "\n";
echo "DB_PASS: " . str_repeat('*', strlen(DB_PASS)) . " (" . strlen(DB_PASS) . " karakter)\n";
echo "</pre>";

// Placeholder kontrolü
if (DB_NAME === 'VERITABANI_ADINIZ' || DB_USER === 'KULLANICI_ADINIZ') {
    echo "<h2 style='color:red'>❌ HATA: Config.php henüz düzenlenmemiş!</h2>";
    echo "<p>Lütfen <strong>config.php</strong> dosyasını açın ve veritabanı bilgilerini girin:</p>";
    echo "<ol>";
    echo "<li>cPanel'e giriş yapın</li>";
    echo "<li>MySQL Databases bölümünü bulun</li>";
    echo "<li>Veritabanı adı, kullanıcı adı ve şifresini not edin</li>";
    echo "<li>config.php dosyasındaki DB_NAME, DB_USER, DB_PASS değerlerini güncelleyin</li>";
    echo "</ol>";
    exit;
}

echo "<h2>2. Veritabanı Bağlantı Testi:</h2>";

try {
    $db = Database::getInstance();
    echo "<p style='color:green;font-weight:bold'>✅ Bağlantı BAŞARILI!</p>";

    // Tabloları kontrol et
    echo "<h2>3. Tablo Kontrolü:</h2>";
    $tables = $db->fetchAll("SHOW TABLES");

    if (empty($tables)) {
        echo "<p style='color:red'>❌ HATA: Veritabanında tablo yok!</p>";
        echo "<p>database.sql dosyasını phpMyAdmin'den import etmeniz gerekiyor.</p>";
    } else {
        echo "<p style='color:green'>✅ " . count($tables) . " tablo bulundu:</p>";
        echo "<ul>";
        foreach ($tables as $table) {
            $tableName = array_values($table)[0];
            echo "<li>$tableName</li>";
        }
        echo "</ul>";

        // Hizmetler tablosunu kontrol et
        echo "<h2>4. Hizmetler Tablosu:</h2>";
        $services = $db->fetchAll("SELECT id, title, slug, image FROM services");

        if (empty($services)) {
            echo "<p style='color:orange'>⚠️ Hizmetler tablosu BOŞ!</p>";
            echo "<p>database.sql'i import edin veya admin panelden hizmet ekleyin.</p>";
        } else {
            echo "<p style='color:green'>✅ " . count($services) . " hizmet bulundu:</p>";
            echo "<table border='1' cellpadding='10' style='border-collapse:collapse'>";
            echo "<tr><th>ID</th><th>Başlık</th><th>Slug</th><th>Resim</th></tr>";
            foreach ($services as $service) {
                echo "<tr>";
                echo "<td>" . $service['id'] . "</td>";
                echo "<td>" . htmlspecialchars($service['title']) . "</td>";
                echo "<td>" . htmlspecialchars($service['slug']) . "</td>";
                echo "<td>" . ($service['image'] ?: '<em>Yok</em>') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    echo "<hr>";
    echo "<h2 style='color:green'>✅ Test Tamamlandı!</h2>";
    echo "<p><strong>Sonuç:</strong> Veritabanı bağlantısı çalışıyor!</p>";

} catch (Exception $e) {
    echo "<p style='color:red;font-weight:bold'>❌ BAĞLANTI BAŞARISIZ!</p>";
    echo "<p><strong>Hata:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<h3>Olası Çözümler:</h3>";
    echo "<ol>";
    echo "<li>config.php dosyasındaki veritabanı bilgilerini kontrol edin</li>";
    echo "<li>cPanel'den veritabanı ve kullanıcının oluşturulduğundan emin olun</li>";
    echo "<li>Kullanıcıya veritabanı üzerinde tam yetki verildiğinden emin olun</li>";
    echo "<li>Sunucu loglarını kontrol edin</li>";
    echo "</ol>";
}
?>
