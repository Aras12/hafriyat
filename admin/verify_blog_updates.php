<?php
/**
 * Blog Güncelleme Doğrulama Scripti
 *
 * Bu script, blog_content_updates.sql çalıştırıldıktan sonra
 * güncellemelerin başarılı olup olmadığını kontrol eder.
 */

// Config dosyasını dahil et
require_once __DIR__ . '/config/config.php';

// HTML Header
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Güncelleme Doğrulama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-success { color: #28a745; }
        .status-warning { color: #ffc107; }
        .status-error { color: #dc3545; }
        .content-preview {
            max-height: 200px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">📋 Blog İçerik Güncelleme Doğrulama</h1>

        <?php
        try {
            // Veritabanı bağlantısı kontrolü
            $conn = getDBConnection();
            echo '<div class="alert alert-success">✅ Veritabanı bağlantısı başarılı</div>';

            // Güncellenmesi gereken blog yazıları
            $expected_blogs = [
                'ekskavator-secimi' => [
                    'title' => 'Doğru Ekskavatör Seçimi Nasıl Yapılır?',
                    'min_length' => 2000
                ],
                'temel-kazisi-dikkat-edilenler' => [
                    'title' => 'Temel Kazısında Dikkat Edilmesi Gerekenler',
                    'min_length' => 7000
                ],
                'bina-yikim-guvenlik' => [
                    'title' => 'Bina Yıkımında Güvenlik Önlemleri',
                    'min_length' => 12000
                ],
                'hafriyat-nedir-ne-zaman-gerekli' => [
                    'title' => 'Hafriyat Nedir ve Ne Zaman Gereklidir?',
                    'min_length' => 7000
                ]
            ];

            echo '<h2 class="mt-4 mb-3">Blog Yazıları Durumu</h2>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-hover">';
            echo '<thead class="table-dark">';
            echo '<tr>';
            echo '<th>Slug</th>';
            echo '<th>Başlık</th>';
            echo '<th>İçerik Uzunluğu</th>';
            echo '<th>Özet</th>';
            echo '<th>Meta Başlık</th>';
            echo '<th>Durum</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $all_success = true;

            foreach ($expected_blogs as $slug => $expected) {
                $stmt = $conn->prepare("SELECT * FROM blog WHERE slug = ?");
                $stmt->execute([$slug]);
                $blog = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($blog) {
                    $content_length = strlen($blog['content']);
                    $is_updated = $content_length >= $expected['min_length'];
                    $status_class = $is_updated ? 'status-success' : 'status-error';
                    $status_text = $is_updated ? '✅ Güncellendi' : '❌ Eski İçerik';

                    if (!$is_updated) {
                        $all_success = false;
                    }

                    echo '<tr>';
                    echo '<td><code>' . htmlspecialchars($blog['slug']) . '</code></td>';
                    echo '<td>' . htmlspecialchars($blog['title']) . '</td>';
                    echo '<td class="' . $status_class . '">' . number_format($content_length) . ' karakter';
                    echo '<br><small>(Beklenen: ' . number_format($expected['min_length']) . '+)</small></td>';
                    echo '<td>' . (strlen($blog['excerpt']) > 0 ? '✅ Var (' . strlen($blog['excerpt']) . ')' : '❌ Yok') . '</td>';
                    echo '<td>' . (strlen($blog['meta_title']) > 0 ? '✅ Var' : '❌ Yok') . '</td>';
                    echo '<td class="' . $status_class . '"><strong>' . $status_text . '</strong></td>';
                    echo '</tr>';

                    // İçerik önizlemesi
                    echo '<tr>';
                    echo '<td colspan="6">';
                    echo '<details>';
                    echo '<summary>İçerik Önizlemesi (ilk 500 karakter)</summary>';
                    echo '<div class="content-preview">';
                    echo htmlspecialchars(substr($blog['content'], 0, 500)) . '...';
                    echo '</div>';
                    echo '</details>';
                    echo '</td>';
                    echo '</tr>';
                } else {
                    echo '<tr class="table-danger">';
                    echo '<td><code>' . htmlspecialchars($slug) . '</code></td>';
                    echo '<td colspan="5" class="status-error">❌ Blog yazısı bulunamadı!</td>';
                    echo '</tr>';
                    $all_success = false;
                }
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            // Genel Durum
            echo '<div class="mt-4 p-4 rounded ' . ($all_success ? 'alert-success' : 'alert-warning') . '">';
            echo '<h3>' . ($all_success ? '✅ Tüm Güncellemeler Başarılı!' : '⚠️ Bazı Güncellemeler Eksik') . '</h3>';

            if (!$all_success) {
                echo '<p class="mb-0">Lütfen <code>blog_content_updates.sql</code> dosyasını çalıştırın.</p>';
                echo '<p class="mb-0 mt-2"><strong>Nasıl Çalıştırılır?</strong></p>';
                echo '<ol>';
                echo '<li>phpMyAdmin\'e giriş yapın</li>';
                echo '<li>SQL sekmesine tıklayın</li>';
                echo '<li>SQL dosyasının içeriğini kopyalayıp yapıştırın</li>';
                echo '<li>Çalıştır butonuna basın</li>';
                echo '</ol>';
            } else {
                echo '<p class="mb-0">Blog içerikleri başarıyla güncellendi. Artık blog sayfalarını ziyaret edebilirsiniz.</p>';
            }
            echo '</div>';

            // İstatistikler
            echo '<h2 class="mt-5 mb-3">📊 İçerik İstatistikleri</h2>';
            echo '<div class="row">';

            $stmt = $conn->query("
                SELECT
                    COUNT(*) as total_blogs,
                    SUM(LENGTH(content)) as total_content_length,
                    AVG(LENGTH(content)) as avg_content_length,
                    SUM(views) as total_views
                FROM blog
                WHERE slug IN (
                    'ekskavator-secimi',
                    'temel-kazisi-dikkat-edilenler',
                    'bina-yikim-guvenlik',
                    'hafriyat-nedir-ne-zaman-gerekli'
                )
            ");
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);

            echo '<div class="col-md-3">';
            echo '<div class="card">';
            echo '<div class="card-body text-center">';
            echo '<h5 class="card-title">Toplam Blog</h5>';
            echo '<p class="display-4">' . $stats['total_blogs'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="col-md-3">';
            echo '<div class="card">';
            echo '<div class="card-body text-center">';
            echo '<h5 class="card-title">Toplam İçerik</h5>';
            echo '<p class="display-6">' . number_format($stats['total_content_length']) . ' karakter</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="col-md-3">';
            echo '<div class="card">';
            echo '<div class="card-body text-center">';
            echo '<h5 class="card-title">Ortalama Uzunluk</h5>';
            echo '<p class="display-6">' . number_format($stats['avg_content_length']) . ' karakter</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="col-md-3">';
            echo '<div class="card">';
            echo '<div class="card-body text-center">';
            echo '<h5 class="card-title">Toplam Görüntülenme</h5>';
            echo '<p class="display-6">' . number_format($stats['total_views']) . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '</div>';

            // Test Linkleri
            echo '<h2 class="mt-5 mb-3">🔗 Blog Sayfalarını Test Et</h2>';
            echo '<div class="list-group">';

            foreach ($expected_blogs as $slug => $expected) {
                $url = '../blog-detay.php?slug=' . $slug;
                echo '<a href="' . $url . '" class="list-group-item list-group-item-action" target="_blank">';
                echo '<div class="d-flex w-100 justify-content-between">';
                echo '<h5 class="mb-1">' . htmlspecialchars($expected['title']) . '</h5>';
                echo '<small>→ Aç</small>';
                echo '</div>';
                echo '<p class="mb-1"><code>' . $url . '</code></p>';
                echo '</a>';
            }

            echo '</div>';

        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">';
            echo '<h4>❌ Veritabanı Hatası</h4>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
        }
        ?>

        <div class="mt-5 p-3 bg-light rounded">
            <h4>📝 Notlar</h4>
            <ul>
                <li>SQL dosyası: <code>/home/user/hafriyat/admin/blog_content_updates.sql</code></li>
                <li>README: <code>/home/user/hafriyat/admin/BLOG_UPDATE_README.md</code></li>
                <li>Bu sayfa: <code>/home/user/hafriyat/admin/verify_blog_updates.php</code></li>
            </ul>
        </div>

        <div class="mt-3 text-center">
            <button onclick="location.reload()" class="btn btn-primary">🔄 Sayfayı Yenile</button>
            <a href="index.php" class="btn btn-secondary">← Admin Panele Dön</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
