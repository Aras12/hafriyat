<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kurulum Testi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f0f0f0; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 10px; }
        .test-box { background: #ecf0f1; padding: 15px; margin: 10px 0; border-left: 4px solid #95a5a6; border-radius: 4px; }
        .test-box.success { background: #d4edda; border-color: #28a745; }
        .test-box.error { background: #f8d7da; border-color: #dc3545; }
        .test-box h3 { margin-top: 0; color: #2c3e50; }
        .ok { color: #28a745; font-weight: bold; }
        .fail { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; }
        code { background: #fff; padding: 2px 6px; border-radius: 3px; border: 1px solid #ddd; font-size: 13px; }
        .btn { display: inline-block; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        .btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Kurulum Testi - Emir Hafriyat</h1>

        <?php
        $errors = 0;
        $warnings = 0;
        ?>

        <!-- PHP Versiyonu -->
        <div class="test-box <?= version_compare(PHP_VERSION, '7.4.0') >= 0 ? 'success' : 'error' ?>">
            <h3>1. PHP Versiyonu</h3>
            <?php if (version_compare(PHP_VERSION, '7.4.0') >= 0): ?>
                <span class="ok">✅ PHP <?= phpversion() ?> (Uygun)</span>
            <?php else: $errors++; ?>
                <span class="fail">❌ PHP <?= phpversion() ?> (Minimum 7.4 gerekli!)</span>
            <?php endif; ?>
        </div>

        <!-- Config Dosyası -->
        <div class="test-box <?= file_exists('config.php') ? 'success' : 'error' ?>">
            <h3>2. Config Dosyası</h3>
            <?php if (file_exists('config.php')): ?>
                <span class="ok">✅ config.php bulundu</span><br>
                <?php
                require_once 'config.php';
                if (defined('SITE_URL')) {
                    echo "<span class='ok'>✅ SITE_URL tanımlı: <code>" . SITE_URL . "</code></span><br>";
                }
                if (defined('DB_NAME') && DB_NAME !== 'VERITABANI_ADINIZ') {
                    echo "<span class='ok'>✅ DB_NAME ayarlanmış: <code>" . DB_NAME . "</code></span><br>";
                } else {
                    echo "<span class='fail'>❌ DB_NAME henüz değiştirilmemiş!</span><br>";
                    $errors++;
                }
                ?>
            <?php else: $errors++; ?>
                <span class="fail">❌ config.php bulunamadı!</span>
            <?php endif; ?>
        </div>

        <!-- Veritabanı Bağlantısı -->
        <div class="test-box">
            <h3>3. Veritabanı Bağlantısı</h3>
            <?php
            try {
                if (class_exists('Database')) {
                    $db = Database::getInstance();
                    echo "<span class='ok'>✅ Veritabanı bağlantısı başarılı!</span><br>";

                    $tables = $db->fetchAll("SHOW TABLES");
                    echo "<span class='ok'>✅ Tablo sayısı: " . count($tables) . "</span><br>";

                    if (count($tables) < 10) {
                        echo "<span class='fail'>⚠️ Eksik tablo! database.sql import edildi mi?</span><br>";
                        $warnings++;
                    }

                    echo "<div style='margin-top:10px'><small>Tablolar: ";
                    foreach ($tables as $table) {
                        echo "<code>" . array_values($table)[0] . "</code> ";
                    }
                    echo "</small></div>";
                } else {
                    echo "<span class='fail'>❌ Database sınıfı bulunamadı!</span>";
                    $errors++;
                }
            } catch (Exception $e) {
                echo "<span class='fail'>❌ Veritabanı bağlantı hatası:</span><br>";
                echo "<code>" . $e->getMessage() . "</code><br>";
                echo "<small>Config.php'deki DB bilgilerini kontrol edin!</small>";
                $errors++;
            }
            ?>
        </div>

        <!-- Dosya Yapısı -->
        <div class="test-box">
            <h3>4. Dosya Yapısı</h3>
            <?php
            $requiredFiles = [
                'index.php' => 'Ana sayfa',
                'admin/login.php' => 'Admin giriş',
                'admin/index.php' => 'Admin dashboard',
                'includes/functions.php' => 'Yardımcı fonksiyonlar',
                'includes/header.php' => 'Site header',
                'includes/footer.php' => 'Site footer',
                'includes/classes/Database.php' => 'Database sınıfı',
            ];

            foreach ($requiredFiles as $file => $desc) {
                if (file_exists($file)) {
                    echo "<span class='ok'>✅ $desc</span> <code>$file</code><br>";
                } else {
                    echo "<span class='fail'>❌ Eksik: $desc</span> <code>$file</code><br>";
                    $errors++;
                }
            }
            ?>
        </div>

        <!-- Klasör İzinleri -->
        <div class="test-box">
            <h3>5. Klasör İzinleri</h3>
            <?php
            $writableDirs = [
                'assets/img/slider',
                'assets/img/hizmetler',
                'assets/img/blog',
                'assets/img/galeri',
            ];

            foreach ($writableDirs as $dir) {
                if (is_dir($dir)) {
                    if (is_writable($dir)) {
                        echo "<span class='ok'>✅ Yazılabilir:</span> <code>$dir</code><br>";
                    } else {
                        echo "<span class='fail'>⚠️ Yazılamıyor:</span> <code>$dir</code> (chmod 755 yapın)<br>";
                        $warnings++;
                    }
                } else {
                    echo "<span class='fail'>❌ Klasör yok:</span> <code>$dir</code><br>";
                    $errors++;
                }
            }
            ?>
        </div>

        <!-- URL Kontrol -->
        <div class="test-box">
            <h3>6. URL Kontrolü</h3>
            <p><strong>Mevcut URL:</strong> <code><?= $_SERVER['REQUEST_URI'] ?></code></p>
            <p><strong>Domain:</strong> <code><?= $_SERVER['HTTP_HOST'] ?></code></p>
            <p><strong>SITE_URL:</strong> <code><?= defined('SITE_URL') ? SITE_URL : 'Tanımlı değil!' ?></code></p>
            <?php
            $expectedUrl = 'https://' . $_SERVER['HTTP_HOST'];
            if (defined('SITE_URL') && SITE_URL === $expectedUrl) {
                echo "<span class='ok'>✅ SITE_URL domaininizle eşleşiyor!</span>";
            } else {
                echo "<span class='info'>ℹ️ SITE_URL: <code>" . (defined('SITE_URL') ? SITE_URL : 'yok') . "</code><br>";
                echo "Beklenen: <code>$expectedUrl</code></span>";
            }
            ?>
        </div>

        <!-- Sonuç -->
        <div class="test-box <?= $errors === 0 ? 'success' : 'error' ?>" style="margin-top: 20px; font-size: 18px; font-weight: bold;">
            <?php if ($errors === 0): ?>
                ✅ KURULUM TAMAM! Site hazır!
            <?php else: ?>
                ❌ <?= $errors ?> HATA VAR! Yukarıdaki hataları düzeltin.
            <?php endif; ?>

            <?php if ($warnings > 0): ?>
                <br><span style="color: #ff9800;">⚠️ <?= $warnings ?> uyarı var (kritik değil)</span>
            <?php endif; ?>
        </div>

        <!-- Test Linkleri -->
        <div style="margin-top: 20px; padding: 20px; background: #e8f4f8; border-radius: 5px;">
            <h3>📋 Test Linkleri:</h3>
            <a href="index.php" class="btn">Ana Sayfa</a>
            <a href="admin/login.php" class="btn">Admin Panel</a>
            <a href="hakkimizda.php" class="btn">Hakkımızda</a>
            <a href="blog.php" class="btn">Blog</a>

            <p style="margin-top: 15px; font-size: 14px; color: #666;">
                <strong>Admin Giriş:</strong> Kullanıcı: <code>admin</code> / Şifre: <code>admin123</code>
            </p>
        </div>

        <div style="margin-top: 20px; text-align: center; color: #999; font-size: 12px;">
            Test Zamanı: <?= date('d.m.Y H:i:s') ?>
        </div>
    </div>
</body>
</html>
