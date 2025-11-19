<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dosya Kontrol</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #4CAF50; }
        .error { border-left-color: #f44336; }
        h1 { color: #333; }
        code { background: #eee; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>📂 Dosya Konum Kontrolü</h1>

    <div class="box">
        <h2>1. Bu Dosyanın Yolu</h2>
        <p><strong>__FILE__:</strong> <code><?php echo __FILE__; ?></code></p>
        <p><strong>__DIR__:</strong> <code><?php echo __DIR__; ?></code></p>
    </div>

    <div class="box">
        <h2>2. URL Bilgileri</h2>
        <p><strong>Açtığınız URL:</strong> <code><?php echo $_SERVER['REQUEST_URI']; ?></code></p>
        <p><strong>Domain:</strong> <code><?php echo $_SERVER['HTTP_HOST']; ?></code></p>
        <p><strong>SCRIPT_NAME:</strong> <code><?php echo $_SERVER['SCRIPT_NAME']; ?></code></p>
    </div>

    <div class="box">
        <h2>3. PHP Dosyaları Kontrolü</h2>
        <?php
        $files = ['index.php', 'config.php', 'test.php', 'admin/login.php'];
        foreach ($files as $file) {
            $fullPath = __DIR__ . '/' . $file;
            if (file_exists($fullPath)) {
                echo "✅ <code>$file</code> VAR<br>";
            } else {
                echo "❌ <code>$file</code> YOK!<br>";
            }
        }
        ?>
    </div>

    <div class="box">
        <h2>4. Klasör Kontrolü</h2>
        <?php
        $dirs = ['admin', 'assets', 'includes', 'includes/classes'];
        foreach ($dirs as $dir) {
            $fullPath = __DIR__ . '/' . $dir;
            if (is_dir($fullPath)) {
                echo "✅ <code>$dir/</code> klasörü VAR<br>";
            } else {
                echo "❌ <code>$dir/</code> klasörü YOK!<br>";
            }
        }
        ?>
    </div>

    <div class="box">
        <h2>5. index.php Direkt Link</h2>
        <?php
        $indexPath = __DIR__ . '/index.php';
        if (file_exists($indexPath)) {
            $indexUrl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/index.php';
            echo "✅ index.php var! <br>";
            echo "<a href='$indexUrl' style='color:blue; text-decoration:underline;'>$indexUrl</a> - Bu linke tıkla!";
        } else {
            echo "❌ index.php BULUNAMADI!";
        }
        ?>
    </div>

    <div class="box">
        <h2>6. .htaccess Var mı?</h2>
        <?php
        if (file_exists(__DIR__ . '/.htaccess')) {
            echo "⚠️ .htaccess VAR (sil!)";
        } else {
            echo "✅ .htaccess YOK (doğru!)";
        }
        ?>
    </div>

    <div class="box">
        <h2>✅ Sonuç</h2>
        <p>Yukarıdaki bilgileri kontrol edin:</p>
        <ul>
            <li>Tüm dosyalar ✅ ise → config.php'yi düzenleyin</li>
            <li>Dosyalar ❌ ise → Yanlış yere yüklemişsiniz!</li>
        </ul>
    </div>
</body>
</html>
