<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hizmet İçeriklerini Güncelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; padding: 20px; }
        .container { max-width: 900px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .log-item { padding: 10px; margin: 5px 0; background: #f8f9fa; border-left: 3px solid #007bff; }
        .log-item.success { border-left-color: #28a745; }
        .log-item.error { border-left-color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">🔄 Hizmet İçeriklerini Güncelle</h1>
        <p class="text-muted">Bu sayfa, HTML dosyalarındaki özel içerikleri veritabanına yükler.</p>
        <hr>

        <?php
        if (!isset($_POST['update'])) {
            ?>
            <div class="alert alert-warning">
                <h4>⚠️ DİKKAT</h4>
                <p>Bu işlem tüm hizmetlerin içeriklerini güncelleyecektir. Her hizmetin:</p>
                <ul>
                    <li>Özel açıklama metni</li>
                    <li>Resim yolu</li>
                    <li>HTML içeriği</li>
                </ul>
                <p>veritabanına kaydedilecektir.</p>
            </div>

            <form method="post">
                <button type="submit" name="update" class="btn btn-primary btn-lg">
                    ✅ Evet, Hizmetleri Güncelle
                </button>
                <a href="index.php" class="btn btn-secondary btn-lg">İptal</a>
            </form>
            <?php
        } else {
            require_once 'config.php';
            $db = Database::getInstance();

            // Her hizmetin özel içeriğini tanımla
            $serviceContents = [
                'ekskavator-kiralama' => [
                    'image' => 'assets/img/hizmetler/ekskavator.jpg',
                    'description' => '<h1><i class="fas fa-tractor"></i> Ekskavatör Kiralama Hizmeti</h1>

<p>Kayseri Emir Hafriyat olarak, 25 yıllık tecrübemizle her tonajda ekskavatör kiralama hizmeti sunuyoruz. Modern ve bakımlı ekskavatörlerimiz ile her türlü kazı ve hafriyat işlerinizi güvenle gerçekleştirin.</p>

<h2>Ekskavatör Tonaj Seçenekleri</h2>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="feature-box">
            <h4>20 Ton Ekskavatör</h4>
            <p>Küçük ve orta ölçekli projeler, villa temel kazısı, bahçe düzenlemesi</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="feature-box">
            <h4>30 Ton Ekskavatör</h4>
            <p>Orta ölçekli inşaat projeleri, bina temel kazısı, yol çalışmaları</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="feature-box">
            <h4>35 Ton Ekskavatör</h4>
            <p>Büyük ölçekli hafriyat, fabrika temel kazısı, derin kazı işleri</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="feature-box">
            <h4>40 Ton Ekskavatör</h4>
            <p>Endüstriyel projeler, toplu konut hafriyatı, büyük yol projeleri</p>
        </div>
    </div>
</div>

<h2>Hizmet Detayları</h2>
<ul>
    <li>Deneyimli ve sertifikalı operatörlerimiz</li>
    <li>Saatlik, günlük, haftalık ve aylık kiralama seçenekleri</li>
    <li>Modern ve bakımlı ekipmanlar</li>
    <li>7/24 teknik destek</li>
    <li>Hızlı mobilizasyon</li>
    <li>Uygun fiyatlandırma</li>
    <li>Sigortalı hizmet</li>
    <li>Kayseri ve çevresinde hizmet</li>
</ul>

<h3>Kullanım Alanları</h3>
<p>Ekskavatörlerimiz aşağıdaki alanlarda kullanılabilir:</p>
<ul>
    <li>Bina ve villa temel kazısı</li>
    <li>Yol ve altyapı kazıları</li>
    <li>Kanalizasyon ve drenaj işleri</li>
    <li>Zemin düzenleme ve tesviye</li>
    <li>Moloz yükleme işleri</li>
    <li>Dere ıslahı çalışmaları</li>
    <li>Gölet ve havuz kazıları</li>
</ul>'
                ],

                'beko-loder-kiralama' => [
                    'image' => 'assets/img/hizmetler/bekoloder.jpg',
                    'description' => '<h1><i class="fas fa-truck-pickup"></i> Beko Loder Kiralama</h1>

<p>Beko loder, hem ön kepçe hem de arka kazıcı özelliği ile çok amaçlı kullanıma uygun iş makinesidir. Kayseri Emir Hafriyat olarak deneyimli operatörlerimizle beko loder kiralama hizmeti sunuyoruz.</p>

<h2>Beko Loder Özellikleri</h2>
<p>Beko loderlerimiz modern ve bakımlıdır. Hem kazı hem de yükleme işlemleri için idealdir.</p>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="feature-box">
            <h4>Ön Kepçe</h4>
            <p>Malzeme yükleme, toprak taşıma, tesviye işleri</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="feature-box">
            <h4>Arka Kazıcı</h4>
            <p>Hendek kazısı, temel kazısı, dar alanda çalışma</p>
        </div>
    </div>
</div>

<h2>Hizmet Detayları</h2>
<ul>
    <li>Deneyimli operatör ile birlikte kiralama</li>
    <li>Saatlik ve günlük kiralama seçenekleri</li>
    <li>Dar alanlarda çalışabilme özelliği</li>
    <li>Çok fonksiyonlu kullanım (kazı + yükleme)</li>
    <li>Hızlı mobilizasyon</li>
    <li>Uygun fiyatlandırma</li>
    <li>7/24 teknik destek</li>
    <li>Sigortalı hizmet</li>
</ul>

<h3>Kullanım Alanları</h3>
<ul>
    <li>Küçük ve orta ölçekli temel kazıları</li>
    <li>Su ve elektrik hattı kazıları</li>
    <li>Bahçe düzenleme işleri</li>
    <li>Yol kenarı çalışmaları</li>
    <li>Toprak taşıma ve yükleme</li>
    <li>Hendek ve kanal kazıları</li>
    <li>Zemin tesviyesi</li>
    <li>Moloz temizleme</li>
</ul>'
                ],

                'manitou-teleskopik-forklift' => [
                    'image' => 'assets/img/hizmetler/manitou.jpg',
                    'description' => '<h1><i class="fas fa-forklift"></i> Manitou Teleskopik Forklift Kiralama</h1>

<p>Manitou teleskopik forkliftler, yüksek kaldırma kapasitesi ve geniş kullanım alanı ile inşaat sahalarında vazgeçilmez makinelerdir. Malzeme taşıma ve yükleme işleriniz için ideal çözüm.</p>

<h2>Manitou Özellikleri</h2>
<ul>
    <li>Yüksek kaldırma kapasitesi (6-12 metre)</li>
    <li>Teleskopik uzatma özelliği</li>
    <li>Döner kabin</li>
    <li>4x4 arazi özelliği</li>
    <li>Çok fonksiyonlu bom sistemi</li>
    <li>Güvenli ve stabil çalışma</li>
</ul>

<h3>Kullanım Alanları</h3>
<ul>
    <li>İnşaat malzemesi yükleme</li>
    <li>Yüksek katlara malzeme taşıma</li>
    <li>Prefabrik montaj işleri</li>
    <li>Çatı malzemesi taşıma</li>
    <li>Ağır yük kaldırma</li>
</ul>'
                ],

                'kamyon-kiralama' => [
                    'image' => 'assets/img/hizmetler/kamyon.jpg',
                    'description' => '<h1><i class="fas fa-truck"></i> Kamyon Kiralama Hizmeti</h1>

<p>Moloz nakli ve malzeme taşımacılığı için damperli kamyon kiralama hizmeti. Profesyonel sürücülerimiz ve geniş filomuzla Kayseri ve çevresinde hizmet veriyoruz.</p>

<h2>Kamyon Kiralama Avantajları</h2>
<ul>
    <li>Damperli kamyon filosu</li>
    <li>Profesyonel ve deneyimli sürücüler</li>
    <li>Hızlı ve güvenli taşımacılık</li>
    <li>Saatlik ve günlük kiralama</li>
    <li>Moloz ve hafriyat nakli</li>
    <li>İnşaat malzemesi taşıma</li>
    <li>Toprak ve dolgu taşıma</li>
    <li>Uygun fiyatlandırma</li>
</ul>

<h3>Taşıma Hizmetleri</h3>
<ul>
    <li>Moloz ve hafriyat taşıma</li>
    <li>İnşaat molozları nakli</li>
    <li>Toprak ve kum taşıma</li>
    <li>Dolgu malzemesi nakli</li>
    <li>Çakıl ve agrega taşıma</li>
    <li>Yıkım molozları nakli</li>
</ul>'
                ],

                'bina-yikim' => [
                    'image' => 'assets/img/hizmetler/bina-yikim.jpg',
                    'description' => '<h1><i class="fas fa-home"></i> Profesyonel Bina Yıkım Hizmeti</h1>

<p>Eski ve kullanılamaz haldeki binaların güvenli yıkımı için profesyonel hizmet sunuyoruz. Moloz yükleme, nakliye ve saha temizliği dahil eksiksiz hizmet.</p>

<h2>Bina Yıkım Sürecimiz</h2>
<ul>
    <li>Saha keşfi ve risk analizi</li>
    <li>İzin ve ruhsat işlemleri danışmanlığı</li>
    <li>Güvenli yıkım planlaması</li>
    <li>Profesyonel ekipman kullanımı</li>
    <li>Moloz yükleme ve taşıma</li>
    <li>Saha temizliği</li>
    <li>Çevre düzenlemesi</li>
</ul>

<h3>Yıkım Yapabileceğimiz Yapılar</h3>
<ul>
    <li>1-5 katlı konutlar</li>
    <li>Eski fabrikalar</li>
    <li>Metruk binalar</li>
    <li>İş yerleri</li>
    <li>Bahçe duvarları</li>
    <li>Betonarme yapılar</li>
</ul>

<div class="feature-box">
    <h4>Güvenlik Önlemlerimiz</h4>
    <p>Tüm yıkım işlemlerinde iş güvenliği kurallarına uygun çalışırız. Çevre güvenliği, toz kontrolü ve gürültü yönetimi konularında hassasiyet gösteririz.</p>
</div>'
                ],

                'temel-kazma-dolgu' => [
                    'image' => 'assets/img/hizmetler/temel-kazma.jpg',
                    'description' => '<h1><i class="fas fa-layer-group"></i> Temel Kazma ve Dolgu Hizmeti</h1>

<p>Ev, villa ve fabrika temel kazıları için profesyonel hizmet. Zemin etüdü, kazı, dolgu ve tesviye işlemlerini eksiksiz gerçekleştiriyoruz.</p>

<h2>Hizmet Kapsamımız</h2>
<ul>
    <li>Ev temel kazısı</li>
    <li>Villa temel kazısı</li>
    <li>Fabrika ve endüstriyel yapı temel kazıları</li>
    <li>Zemin düzenleme ve tesviye</li>
    <li>Dolgu ve toprak işleri</li>
    <li>Drenaj sistemi kazıları</li>
    <li>İstinat duvarı temelleri</li>
</ul>

<h3>Temel Kazma Süreci</h3>
<ol>
    <li>Arazi keşfi ve ölçüm</li>
    <li>Zemin analizi</li>
    <li>Kazı planlaması</li>
    <li>Profesyonel kazı işlemi</li>
    <li>Tesviye ve düzenleme</li>
    <li>Dolgu ve sıkıştırma</li>
    <li>Son kontroller</li>
</ol>

<div class="feature-box">
    <h4>Neden Profesyonel Temel Kazısı?</h4>
    <p>Doğru yapılmayan temel kazısı, binanızın ömrünü kısaltır ve güvenlik sorunlarına yol açar. Deneyimli ekibimiz ve modern ekipmanlarımızla güvenli kazı garantisi veriyoruz.</p>
</div>'
                ],

                'alt-yapi-kazilari' => [
                    'image' => 'assets/img/hizmetler/altyapi.jpg',
                    'description' => '<h1><i class="fas fa-road"></i> Alt Yapı Kazı Hizmetleri</h1>

<p>Su, elektrik, doğalgaz ve kanalizasyon alt yapı kazıları için hassas ve profesyonel hizmet. Mevcut hatları koruyarak güvenli kazı yapıyoruz.</p>

<h2>Alt Yapı Hizmetlerimiz</h2>
<ul>
    <li>Su hattı kazısı ve döşeme</li>
    <li>Elektrik hattı kazısı</li>
    <li>Doğalgaz hattı kazısı</li>
    <li>Kanalizasyon kazısı</li>
    <li>Fiber optik hat kazısı</li>
    <li>Drenaj sistemi</li>
    <li>Yol alt yapı çalışmaları</li>
</ul>

<h3>Çalışma Prensiplerimiz</h3>
<ul>
    <li>Hassas kazı teknikleri</li>
    <li>Mevcut hatların korunması</li>
    <li>Güvenlik standartlarına uygunluk</li>
    <li>Hızlı ve düzenli çalışma</li>
    <li>Saha temizliği</li>
    <li>Zemin restorasyonu</li>
</ul>

<div class="feature-box">
    <h4>Güvenli Kazı</h4>
    <p>Alt yapı kazılarında en önemli konu mevcut hatları korumaktır. Deneyimli ekibimiz ve hassas ekipmanlarımızla güvenli kazı garantisi veriyoruz.</p>
</div>'
                ],

                'tas-duvar-istinat-duvari' => [
                    'image' => 'assets/img/hizmetler/tas-duvar.jpg',
                    'description' => '<h1><i class="fas fa-building"></i> Taş Duvar ve Peyzaj Hizmetleri</h1>

<p>Bahçe ve arazi düzenlemesi için taş duvar yapımı ve peyzaj hizmetleri. Estetik ve dayanıklı çözümler.</p>

<h2>Hizmetlerimiz</h2>
<ul>
    <li>İstinat duvarı yapımı</li>
    <li>Bahçe duvarı</li>
    <li>Dekoratif taş duvarlar</li>
    <li>Çevre düzenleme</li>
    <li>Peyzaj işleri</li>
    <li>Taş döşeme</li>
    <li>Toprak işleri</li>
</ul>

<h3>Taş Duvar Çeşitlerimiz</h3>
<ul>
    <li>Doğal taş duvarlar</li>
    <li>Traverten kaplı duvarlar</li>
    <li>Andezit duvarlar</li>
    <li>Gabion (taş sepetli) duvarlar</li>
    <li>Moloz taş duvarlar</li>
</ul>

<div class="feature-box">
    <h4>Dayanıklılık Garantisi</h4>
    <p>Yapımını yaptığımız tüm taş duvarlar statik hesaplarla tasarlanır ve uzun ömürlüdür. Hem estetik hem de fonksiyoneldir.</p>
</div>'
                ]
            ];

            echo '<div id="update-log">';
            echo '<h3>Güncelleme Kaydı:</h3>';

            $successCount = 0;
            $errorCount = 0;

            foreach ($serviceContents as $slug => $data) {
                try {
                    $db->query(
                        "UPDATE services SET
                            image = ?,
                            description = ?,
                            updated_at = NOW()
                        WHERE slug = ?",
                        [$data['image'], $data['description'], $slug]
                    );

                    echo '<div class="log-item success">✓ <strong>' . htmlspecialchars($slug) . '</strong> başarıyla güncellendi</div>';
                    $successCount++;
                } catch (Exception $e) {
                    echo '<div class="log-item error">✗ <strong>' . htmlspecialchars($slug) . '</strong> güncellenemedi: ' . htmlspecialchars($e->getMessage()) . '</div>';
                    $errorCount++;
                }
            }

            echo '</div>';

            echo '<div class="alert alert-success mt-4">';
            echo '<h4>✅ İşlem Tamamlandı!</h4>';
            echo '<p><strong>' . $successCount . '</strong> hizmet başarıyla güncellendi.</p>';
            if ($errorCount > 0) {
                echo '<p class="text-danger"><strong>' . $errorCount . '</strong> hizmette hata oluştu.</p>';
            }
            echo '</div>';

            echo '<div class="mt-4">';
            echo '<h4>Test Linkleri:</h4>';
            echo '<ul>';
            foreach (array_keys($serviceContents) as $slug) {
                $url = 'hizmet-single.php?slug=' . $slug;
                echo '<li><a href="' . $url . '" target="_blank">' . htmlspecialchars($slug) . '</a></li>';
            }
            echo '</ul>';
            echo '</div>';

            echo '<div class="mt-4">';
            echo '<a href="hizmetler.php" class="btn btn-primary">Hizmetler Sayfasına Git</a> ';
            echo '<a href="index.php" class="btn btn-secondary">Ana Sayfaya Dön</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
