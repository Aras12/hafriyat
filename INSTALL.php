<?php
/**
 * KAYSERI EMİR HAFRİYAT - OTOMATİK KURULUM
 * Bu dosyayı tarayıcıda bir kez çalıştırın: http://localhost/hafriyat/INSTALL.php
 */

require_once 'config.php';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Kurulum</title>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px}";
echo ".success{color:green;background:#d4edda;padding:10px;margin:10px 0;border-radius:5px}";
echo ".error{color:red;background:#f8d7da;padding:10px;margin:10px 0;border-radius:5px}";
echo "h1{color:#333}pre{background:#f5f5f5;padding:10px;overflow:auto}</style></head><body>";
echo "<h1>🚜 Kayseri Emir Hafriyat - Otomatik Kurulum</h1>";

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Veritabanı oluştur
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE " . DB_NAME);
    echo "<div class='success'>✅ Veritabanı oluşturuldu: " . DB_NAME . "</div>";

    // Tabloları oluştur
    $pdo->exec("DROP TABLE IF EXISTS services");
    $pdo->exec("CREATE TABLE services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        short_description TEXT,
        description TEXT,
        icon VARCHAR(100),
        image VARCHAR(255),
        features TEXT,
        tab_category VARCHAR(50),
        sort_order INT DEFAULT 0,
        status TINYINT DEFAULT 1,
        meta_title VARCHAR(255),
        meta_description TEXT,
        meta_keywords VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<div class='success'>✅ services tablosu oluşturuldu</div>";

    $pdo->exec("DROP TABLE IF EXISTS service_tabs");
    $pdo->exec("CREATE TABLE service_tabs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tab_key VARCHAR(50) NOT NULL UNIQUE,
        tab_name VARCHAR(100) NOT NULL,
        sort_order INT DEFAULT 0,
        status TINYINT DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<div class='success'>✅ service_tabs tablosu oluşturuldu</div>";

    $pdo->exec("DROP TABLE IF EXISTS pages");
    $pdo->exec("CREATE TABLE pages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        page_key VARCHAR(50) NOT NULL UNIQUE,
        title VARCHAR(255) NOT NULL,
        content TEXT,
        meta_title VARCHAR(255),
        meta_description TEXT,
        meta_keywords VARCHAR(255),
        status TINYINT DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<div class='success'>✅ pages tablosu oluşturuldu</div>";

    $pdo->exec("DROP TABLE IF EXISTS site_meta");
    $pdo->exec("CREATE TABLE site_meta (
        id INT AUTO_INCREMENT PRIMARY KEY,
        meta_key VARCHAR(100) NOT NULL UNIQUE,
        meta_value TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<div class='success'>✅ site_meta tablosu oluşturuldu</div>";

    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255),
        full_name VARCHAR(255),
        status TINYINT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "<div class='success'>✅ users tablosu oluşturuldu</div>";

    // Admin kullanıcı ekle
    $adminPass = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO users (username, password, email, full_name) VALUES ('admin', '$adminPass', 'admin@emirhafriyat.com', 'Admin')");
    echo "<div class='success'>✅ Admin kullanıcı oluşturuldu (admin / admin123)</div>";

    // Service tabs ekle
    $pdo->exec("INSERT INTO service_tabs (tab_key, tab_name, sort_order) VALUES
        ('makine-kiralama', 'Makine Kiralama', 1),
        ('hafriyat-hizmetleri', 'Hafriyat Hizmetleri', 2),
        ('insaat-hizmetleri', 'İnşaat Hizmetleri', 3)");
    echo "<div class='success'>✅ Hizmet kategorileri eklendi</div>";

    // Hizmetleri ekle - HER BİRİ FARKLI İÇERİKLE!
    $services = [
        [
            'title' => 'Ekskavatör Kiralama',
            'slug' => 'ekskavator',
            'short_description' => 'Profesyonel kazı ve hafriyat işleri için ekskavatör kiralama',
            'description' => '<h3>Kayseri\'de Profesyonel Ekskavatör Kiralama</h3><p>20-40 ton kapasiteli modern ekskavatörlerimizle her türlü hafriyat işinizi güvenle gerçekleştiriyoruz. Deneyimli operatörlerimiz ve düzenli bakımı yapılan makinelerimizle projelerinizi zamanında teslim ediyoruz.</p><p>İnşaat, kazı, temel açma ve hafriyat işleriniz için profesyonel çözümler sunuyoruz.</p>',
            'features' => 'Profesyonel operatör,20-40 ton kapasite,Günlük kiralama,Uygun fiyat',
            'icon' => 'fas fa-truck-pickup',
            'tab' => 'makine-kiralama',
            'order' => 1
        ],
        [
            'title' => 'Beko Loder Kiralama',
            'slug' => 'bekoloder',
            'short_description' => 'Kazı ve yükleme işleri için beko loder kiralama hizmeti',
            'description' => '<h3>Beko Loder Kiralama Hizmeti</h3><p>Hem kazma hem de yükleme işlemlerinde kullanılabilir beko loderlerimiz, dar alanlarda çalışmaya uygundur. Çok yönlü makinelerimiz her türlü ihtiyacınıza cevap verir.</p><p>Peyzaj düzenleme, yol yapımı, temel kazısı ve malzeme yükleme işlerinde tercih edilen makinelerimiz ile hizmetinizdeyiz.</p>',
            'features' => 'Çok yönlü kullanım,Dar alan çalışması,Deneyimli operatör,Hızlı hizmet',
            'icon' => 'fas fa-tractor',
            'tab' => 'makine-kiralama',
            'order' => 2
        ],
        [
            'title' => 'Manitou Forklift Kiralama',
            'slug' => 'manitou',
            'short_description' => 'Yükleme ve taşıma işleri için manitou forklift kiralama',
            'description' => '<h3>Manitou Forklift Kiralama</h3><p>Manitou forkliftlerimiz ile malzeme taşıma ve yükleme işlerinizi kolaylaştırıyoruz. İnşaat sahalarında vazgeçilmez ekipmanlarımızla hizmetinizdeyiz.</p><p>Yüksek kaldırma kapasitesi ve geniş çalışma alanı ile malzeme taşıma işlerinizi güvenle gerçekleştiriyoruz.</p>',
            'features' => 'Yüksek kaldırma,Güvenli çalışma,Profesyonel operatör,Bakımlı araçlar',
            'icon' => 'fas fa-forklift',
            'tab' => 'makine-kiralama',
            'order' => 3
        ],
        [
            'title' => 'Kamyon Kiralama',
            'slug' => 'kamyon',
            'short_description' => 'Hafriyat ve malzeme taşıma için kamyon kiralama',
            'description' => '<h3>Kamyon Kiralama Hizmeti</h3><p>10-30 ton kapasiteli kamyonlarımız ile hafriyat, moloz ve inşaat malzemesi taşıma hizmetleri sunuyoruz. Profesyonel sürücülerimiz ile güvenli nakliye garantisi veriyoruz.</p><p>Toprak, moloz, kum, çakıl ve her türlü inşaat malzemesi taşıma işleriniz için bize güvenebilirsiniz.</p>',
            'features' => 'Geniş filo,Profesyonel sürücü,Güvenli taşıma,Uygun fiyat',
            'icon' => 'fas fa-truck',
            'tab' => 'makine-kiralama',
            'order' => 4
        ],
        [
            'title' => 'Bina Yıkımı',
            'slug' => 'bina-yikim',
            'short_description' => 'Güvenli ve profesyonel bina yıkım hizmetleri',
            'description' => '<h3>Profesyonel Bina Yıkım Hizmeti</h3><p>Profesyonel ekibimiz ve modern ekipmanlarımızla bina yıkım işlemlerini güvenli bir şekilde gerçekleştiriyoruz. Tüm yasal izinler ve güvenlik önlemleri tarafımızdan sağlanır.</p><p>Kontrollü yıkım, moloz temizliği ve alan düzenleme işlemleri dahil komple hizmet sunuyoruz.</p>',
            'features' => 'Güvenli yıkım,Moloz temizliği,Yasal izinler,Sigortalı çalışma',
            'icon' => 'fas fa-hard-hat',
            'tab' => 'hafriyat-hizmetleri',
            'order' => 5
        ],
        [
            'title' => 'Temel Kazma',
            'slug' => 'temel-kazma',
            'short_description' => 'Bina temeli için profesyonel kazı hizmetleri',
            'description' => '<h3>Profesyonel Temel Kazı Hizmeti</h3><p>Binaların en önemli kısmı olan temel kazı işlemlerini özenle gerçekleştiriyoruz. Zemin etüdü ve statik hesaplamalara uygun hassas kazı yapıyoruz.</p><p>İnşaatınızın sağlam temeller üzerine oturması için gerekli tüm kazı işlemlerini gerçekleştiriyoruz.</p>',
            'features' => 'Hassas ölçüm,Zemin analizi,Statik uyum,Hızlı iş bitirme',
            'icon' => 'fas fa-dig',
            'tab' => 'hafriyat-hizmetleri',
            'order' => 6
        ],
        [
            'title' => 'Altyapı Çalışmaları',
            'slug' => 'altyapi',
            'short_description' => 'Kanalizasyon, su ve elektrik altyapı işleri',
            'description' => '<h3>Altyapı Çalışmaları</h3><p>Kanalizasyon, su, elektrik ve doğalgaz altyapı çalışmalarında uzmanız. Belediye standartlarına uygun, kaliteli işçilik garantisi sunuyoruz.</p><p>Kazı, boru döşeme, test ve devreye alma işlemlerini eksiksiz gerçekleştiriyoruz.</p>',
            'features' => 'Belediye standartları,Kaliteli malzeme,Profesyonel ekip,Garanti belgesi',
            'icon' => 'fas fa-tools',
            'tab' => 'insaat-hizmetleri',
            'order' => 7
        ],
        [
            'title' => 'Taş Duvar Yapımı',
            'slug' => 'tas-duvar',
            'short_description' => 'Doğal taş duvar ve istinat duvarı yapımı',
            'description' => '<h3>Taş Duvar ve İstinat Duvarı</h3><p>Estetik ve dayanıklı doğal taş duvar uygulamaları yapıyoruz. İstinat duvarları, bahçe duvarları ve dekoratif taş işçiliği konusunda uzmanız.</p><p>Doğal taş malzemeler kullanarak hem estetik hem de dayanıklı duvarlar inşa ediyoruz.</p>',
            'features' => 'Doğal taş,Estetik görünüm,Uzun ömürlü,Profesyonel işçilik',
            'icon' => 'fas fa-th-large',
            'tab' => 'insaat-hizmetleri',
            'order' => 8
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO services (title, slug, short_description, description, features, icon, tab_category, sort_order, status, meta_title, meta_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?)");

    foreach ($services as $svc) {
        $meta_title = $svc['title'] . ' | Kayseri Emir Hafriyat';
        $meta_desc = $svc['short_description'] . ' - Kayseri\'de profesyonel hafriyat hizmetleri.';

        $stmt->execute([
            $svc['title'],
            $svc['slug'],
            $svc['short_description'],
            $svc['description'],
            $svc['features'],
            $svc['icon'],
            $svc['tab'],
            $svc['order'],
            $meta_title,
            $meta_desc
        ]);
    }
    echo "<div class='success'>✅ " . count($services) . " hizmet eklendi (HER BİRİ FARKLI İÇERİKLE!)</div>";

    // Site meta bilgileri
    $pdo->exec("INSERT INTO site_meta (meta_key, meta_value) VALUES
        ('company_name', 'Kayseri Emir Hafriyat'),
        ('company_phone', '0531 702 35 38'),
        ('company_email', 'info@emirhafriyat.com'),
        ('company_address', 'Kayseri'),
        ('facebook_url', '#'),
        ('instagram_url', '#'),
        ('twitter_url', '#'),
        ('youtube_url', '#')");
    echo "<div class='success'>✅ Site ayarları eklendi</div>";

    // Sayfalar
    $pdo->exec("INSERT INTO pages (page_key, title, content, meta_title, meta_description, status) VALUES
        ('hizmetler', 'Hizmetlerimiz', '<p>Profesyonel hafriyat ve iş makinesi kiralama hizmetleri</p>', 'Hizmetlerimiz | Kayseri Emir Hafriyat', 'Profesyonel hafriyat, kazı, yıkım ve iş makinesi kiralama hizmetleri', 1),
        ('hakkimizda', 'Hakkımızda', '<p>Kayseri Emir Hafriyat olarak...</p>', 'Hakkımızda | Kayseri Emir Hafriyat', 'Kayseri Emir Hafriyat hakkında', 1),
        ('iletisim', 'İletişim', '<p>Bize ulaşın</p>', 'İletişim | Kayseri Emir Hafriyat', 'İletişim bilgileri', 1)");
    echo "<div class='success'>✅ Sayfalar eklendi</div>";

    echo "<hr><div class='success'>";
    echo "<h2>🎉 KURULUM TAMAMLANDI!</h2>";
    echo "<p><strong>Admin Girişi:</strong> <a href='admin/'>Admin Paneli</a></p>";
    echo "<p><strong>Kullanıcı Adı:</strong> admin</p>";
    echo "<p><strong>Şifre:</strong> admin123</p>";
    echo "<hr>";
    echo "<p><strong>Ana Sayfa:</strong> <a href='index.php'>Siteyi Görüntüle</a></p>";
    echo "<p><strong>Hizmetler:</strong> <a href='hizmetler.php'>Hizmetler Sayfası</a></p>";
    echo "<hr>";
    echo "<p>⚠️ <strong>GÜVENLİK UYARISI:</strong> Kurulum tamamlandıktan sonra bu dosyayı (INSTALL.php) silin!</p>";
    echo "</div>";

    echo "<h3>Hizmet Kontrol:</h3><pre>";
    $check = $pdo->query("SELECT id, title, slug, LEFT(description, 80) as desc_preview FROM services ORDER BY sort_order");
    foreach ($check as $row) {
        echo "✓ [{$row['id']}] {$row['title']} ({$row['slug']})\n";
        echo "  → " . strip_tags($row['desc_preview']) . "...\n\n";
    }
    echo "</pre>";

} catch (Exception $e) {
    echo "<div class='error'>❌ HATA: " . $e->getMessage() . "</div>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "</body></html>";
