<?php
/**
 * KAYSERI EMIR HAFRIYAT - HİZMET İÇERİKLERİNİ DÜZELTME ARACI
 * Bu dosyayı tarayıcıda açın: https://adanaotokokusu.com.tr/fix-service-descriptions.php
 */

require_once 'config.php';
$db = Database::getInstance();

// Güvenlik: Sadece belirli IP'lerden erişime izin ver (isteğe bağlı)
// $allowedIPs = ['123.456.789.0']; // Kendi IP'nizi buraya ekleyin
// if (!in_array($_SERVER['REMOTE_ADDR'], $allowedIPs)) {
//     die('Erişim engellendi!');
// }

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hizmet İçeriklerini Düzelt</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #d32f2f; border-bottom: 3px solid #d32f2f; padding-bottom: 10px; }
        h2 { color: #1976d2; margin-top: 30px; }
        .status { padding: 15px; margin: 10px 0; border-radius: 5px; }
        .success { background: #e8f5e9; border-left: 4px solid #4caf50; color: #2e7d32; }
        .error { background: #ffebee; border-left: 4px solid #f44336; color: #c62828; }
        .info { background: #e3f2fd; border-left: 4px solid #2196f3; color: #1565c0; }
        .warning { background: #fff3e0; border-left: 4px solid #ff9800; color: #e65100; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background: #1976d2; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px 5px; background: #d32f2f; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .btn:hover { background: #b71c1c; }
        .btn-success { background: #4caf50; }
        .btn-success:hover { background: #388e3c; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
        .badge-ok { background: #4caf50; color: white; }
        .badge-error { background: #f44336; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Hizmet İçeriklerini Düzeltme Aracı</h1>

        <?php
        // 1. MEVCUT DURUMU KONTROL ET
        echo "<h2>📊 Mevcut Durum Kontrolü</h2>";

        $services = $db->fetchAll("SELECT id, slug, title, LEFT(meta_description, 60) as meta_desc, LEFT(description, 60) as desc_text FROM services ORDER BY sort_order ASC");

        if ($services) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Slug</th><th>Başlık</th><th>Meta Description</th><th>Description</th><th>Durum</th></tr>';

            foreach ($services as $svc) {
                $metaMatch = stripos($svc['meta_desc'], $svc['title']) !== false;
                $descMatch = stripos($svc['desc_text'], $svc['title']) !== false;
                $status = ($metaMatch && $descMatch) ? '<span class="badge badge-ok">✓ DOĞRU</span>' : '<span class="badge badge-error">✗ YANLIŞ</span>';

                echo "<tr>";
                echo "<td>{$svc['id']}</td>";
                echo "<td><code>{$svc['slug']}</code></td>";
                echo "<td>{$svc['title']}</td>";
                echo "<td>{$svc['meta_desc']}...</td>";
                echo "<td>" . strip_tags($svc['desc_text']) . "...</td>";
                echo "<td>$status</td>";
                echo "</tr>";
            }

            echo '</table>';
        }

        // 2. DÜZELTME İŞLEMİ
        if (isset($_GET['fix']) && $_GET['fix'] == 'yes') {
            echo "<h2>🔄 Düzeltme İşlemi Başlatıldı</h2>";

            $fixes = [
                [
                    'slug' => 'ekskavator',
                    'description' => '<p>Profesyonel ekskavatör kiralama hizmeti sunuyoruz. İnşaat, kazı ve hafriyat işleriniz için son model ekskavatörler.</p>',
                    'short_description' => 'Profesyonel kazı ve hafriyat',
                    'meta_description' => 'Kayseri\'de ekskavatör kiralama hizmeti. İnşaat, kazı ve hafriyat işleriniz için profesyonel çözümler.',
                    'features' => 'Profesyonel operatör,Son model araçlar,Hızlı servis,Uygun fiyat'
                ],
                [
                    'slug' => 'bekoloder',
                    'description' => '<p>Beko loder kiralama hizmeti ile hafriyat ve yükleme işlerinizi kolaylaştırın. Deneyimli operatörlerimizle hizmetinizdeyiz.</p>',
                    'short_description' => 'Hafriyat ve yükleme işleri',
                    'meta_description' => 'Kayseri\'de beko loder kiralama hizmeti. Hafriyat ve yükleme işleriniz için profesyonel çözümler.',
                    'features' => 'Deneyimli operatör,Bakımlı araçlar,7/24 hizmet,Uygun fiyat'
                ],
                [
                    'slug' => 'manitou',
                    'description' => '<p>Manitou forklift kiralama hizmeti sunuyoruz. Yükleme ve taşıma işleriniz için profesyonel çözümler.</p>',
                    'short_description' => 'Yükleme ve taşıma hizmetleri',
                    'meta_description' => 'Manitou forklift kiralama hizmeti Kayseri. Yükleme ve taşıma işleriniz için profesyonel çözümler.',
                    'features' => 'Yüksek kaldırma kapasitesi,Güvenli kullanım,Profesyonel operatör,Bakımlı araçlar'
                ],
                [
                    'slug' => 'kamyon',
                    'description' => '<p>Kamyon kiralama hizmeti ile nakliye ve hafriyat taşıma işlerinizi güvenle tamamlayın.</p>',
                    'short_description' => 'Nakliye ve hafriyat taşıma',
                    'meta_description' => 'Kayseri\'de kamyon kiralama hizmeti. Nakliye ve hafriyat taşıma işleriniz için profesyonel çözümler.',
                    'features' => 'Geniş araç filosu,Deneyimli sürücüler,Hızlı teslimat,Uygun fiyat'
                ],
                [
                    'slug' => 'bina-yikim',
                    'description' => '<p>Profesyonel bina yıkımı hizmeti sunuyoruz. Güvenli ve hızlı yıkım işlemleri için uzman ekibimizle hizmetinizdeyiz.</p>',
                    'short_description' => 'Güvenli ve hızlı yıkım',
                    'meta_description' => 'Kayseri\'de profesyonel bina yıkımı hizmeti. Güvenli ve hızlı yıkım işlemleri.',
                    'features' => 'Güvenli yıkım,Moloz temizliği,Hızlı iş bitirme,Uygun fiyat'
                ],
                [
                    'slug' => 'temel-kazma',
                    'description' => '<p>Temel kazma ve kazı işlemleri için profesyonel hizmet. İnşaatınızın sağlam temelleri için bize güvenin.</p>',
                    'short_description' => 'Sağlam temeller için profesyonel kazı',
                    'meta_description' => 'Kayseri\'de temel kazma hizmeti. İnşaatınızın sağlam temelleri için profesyonel kazı işlemleri.',
                    'features' => 'Hassas ölçüm,Profesyonel kazı,Hızlı iş bitirme,Kaliteli hizmet'
                ],
                [
                    'slug' => 'altyapi',
                    'description' => '<p>Alt yapı çalışmaları için profesyonel hizmet. Kanalizasyon, su, elektrik alt yapı işlerinizi güvenle tamamlıyoruz.</p>',
                    'short_description' => 'Kanalizasyon ve su alt yapı',
                    'meta_description' => 'Kayseri\'de alt yapı çalışmaları. Kanalizasyon, su, elektrik alt yapı işleriniz için profesyonel çözümler.',
                    'features' => 'Profesyonel ekip,Kaliteli malzeme,Hızlı kurulum,Garantili hizmet'
                ],
                [
                    'slug' => 'tas-duvar',
                    'description' => '<p>Estetik ve dayanıklı doğal taş duvar uygulamaları yapıyoruz. İstinat duvarları, bahçe duvarları ve dekoratif taş işçiliği.</p>',
                    'short_description' => 'Doğal taş duvar ve istinat',
                    'meta_description' => 'Kayseri\'de taş duvar uygulamaları. İstinat duvarları, bahçe duvarları ve dekoratif taş işçiliği.',
                    'features' => 'Doğal taş malzeme,Estetik görünüm,Dayanıklı yapı,Profesyonel işçilik'
                ]
            ];

            $updated = 0;
            $errors = 0;

            foreach ($fixes as $fix) {
                try {
                    $result = $db->execute(
                        "UPDATE services SET
                            description = ?,
                            short_description = ?,
                            meta_description = ?,
                            features = ?
                        WHERE slug = ?",
                        [
                            $fix['description'],
                            $fix['short_description'],
                            $fix['meta_description'],
                            $fix['features'],
                            $fix['slug']
                        ]
                    );

                    if ($result) {
                        echo "<div class='status success'>✓ <strong>{$fix['slug']}</strong> güncellendi</div>";
                        $updated++;
                    } else {
                        echo "<div class='status error'>✗ <strong>{$fix['slug']}</strong> güncellenemedi</div>";
                        $errors++;
                    }
                } catch (Exception $e) {
                    echo "<div class='status error'>✗ <strong>{$fix['slug']}</strong> hata: " . $e->getMessage() . "</div>";
                    $errors++;
                }
            }

            echo "<div class='status info'>";
            echo "<strong>Özet:</strong><br>";
            echo "✓ Güncellenen: $updated<br>";
            echo "✗ Hata: $errors<br>";
            echo "</div>";

            echo "<a href='?view=result' class='btn btn-success'>Sonuçları Gör</a>";

        } else {
            // Düzeltme butonu
            echo "<h2>⚙️ İşlem</h2>";
            echo "<div class='status warning'>";
            echo "<strong>DİKKAT:</strong> Bu işlem tüm hizmetlerin açıklama alanlarını güncelleyecektir.<br>";
            echo "Devam etmek için aşağıdaki butona tıklayın.";
            echo "</div>";
            echo "<a href='?fix=yes' class='btn' onclick='return confirm(\"Tüm hizmet içeriklerini güncellemek istediğinizden emin misiniz?\")'>🔧 Hizmetleri Düzelt</a>";
        }

        // 3. SONUÇ GÖRÜNTÜLEME
        if (isset($_GET['view']) && $_GET['view'] == 'result') {
            echo "<h2>✅ Güncelleme Sonrası Durum</h2>";

            $services = $db->fetchAll("SELECT id, slug, title, meta_description, description, features FROM services ORDER BY sort_order ASC");

            foreach ($services as $svc) {
                echo "<div class='status success'>";
                echo "<strong>{$svc['title']}</strong> (Slug: <code>{$svc['slug']}</code>)<br>";
                echo "<small>Meta: {$svc['meta_description']}</small><br>";
                echo "<small>Açıklama: " . strip_tags($svc['description']) . "</small><br>";
                echo "<small>Özellikler: {$svc['features']}</small>";
                echo "</div>";
            }
        }
        ?>

        <hr>
        <p><strong>Not:</strong> İşlem tamamlandıktan sonra bu dosyayı sunucudan silin!</p>
        <p><code>rm fix-service-descriptions.php</code></p>
    </div>
</body>
</html>
