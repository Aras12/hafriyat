<?php
/**
 * SERVICES CONTENT FIX SCRIPT
 * Tüm hizmetlerin doğru image ve description verilerini geri yükler
 */

require_once 'config.php';
$db = Database::getInstance();

echo "=== HİZMETLER İÇERİK DÜZELTME SCRIPT ===\n\n";

// Doğru veriler (database.sql'den)
$correctData = [
    'ekskavator' => [
        'description' => '<p>Kayseri\'de profesyonel ekskavatör kiralama hizmeti sunuyoruz. 20-40 ton kapasiteli modern ekskavatörlerimizle her türlü hafriyat işinizi güvenle gerçekleştiriyoruz.</p><p>Deneyimli operatörlerimiz ve düzenli bakımı yapılan makinelerimizle işlerinizi zamanında teslim ediyoruz.</p>',
        'image' => 'assets/img/hizmetler/ekskavator.jpg'
    ],
    'bekoloder' => [
        'description' => '<p>Beko loderlerimiz hem kazma hem de yükleme işlemlerinde kullanılabilir. Dar alanlarda çalışmaya uygun, çok yönlü makinelerimiz her türlü ihtiyacınıza cevap verir.</p>',
        'image' => 'assets/img/hizmetler/bekoloder.jpg'
    ],
    'manitou' => [
        'description' => '<p>Manitou forkliftlerimiz ile malzeme taşıma ve yükleme işlerinizi kolaylaştırıyoruz. İnşaat sahalarında vazgeçilmez ekipmanlarımızla hizmetinizdeyiz.</p>',
        'image' => 'assets/img/hizmetler/manitou.jpg'
    ],
    'kamyon' => [
        'description' => '<p>10-30 ton kapasiteli kamyonlarımız ile hafriyat, moloz ve inşaat malzemesi taşıma hizmetleri sunuyoruz. Profesyonel sürücülerimiz ile güvenli nakliye garantisi.</p>',
        'image' => 'assets/img/hizmetler/kamyon.jpg'
    ],
    'bina-yikim' => [
        'description' => '<p>Profesyonel ekibimiz ve modern ekipmanlarımızla bina yıkım işlemlerini güvenli bir şekilde gerçekleştiriyoruz. Tüm yasal izinler ve güvenlik önlemleri tarafımızdan sağlanır.</p>',
        'image' => 'assets/img/hizmetler/bina-yikim.jpg'
    ],
    'temel-kazma' => [
        'description' => '<p>Binaların en önemli kısmı olan temel kazı işlemlerini özenle gerçekleştiriyoruz. Zemin etüdü ve statik hesaplamalara uygun kazı yapıyoruz.</p>',
        'image' => 'assets/img/hizmetler/temel-kazma.jpg'
    ],
    'altyapi' => [
        'description' => '<p>Kanalizasyon, su, elektrik ve doğalgaz altyapı çalışmalarında uzmanız. Belediye standartlarına uygun, kaliteli işçilik garantisi.</p>',
        'image' => 'assets/img/hizmetler/altyapi.jpg'
    ],
    'tas-duvar' => [
        'description' => '<p>Estetik ve dayanıklı doğal taş duvar uygulamaları yapıyoruz. İstinat duvarları, bahçe duvarları ve dekoratif taş işçiliği.</p>',
        'image' => 'assets/img/hizmetler/tas-duvar.jpg'
    ]
];

// Her hizmeti güncelle
$updated = 0;
$errors = 0;

foreach ($correctData as $slug => $data) {
    echo "Güncelleniyor: $slug ... ";

    $sql = "UPDATE services SET description = ?, image = ? WHERE slug = ?";

    try {
        if ($db->execute($sql, [$data['description'], $data['image'], $slug])) {
            echo "✅ BAŞARILI\n";
            $updated++;
        } else {
            echo "❌ HATA\n";
            $errors++;
        }
    } catch (Exception $e) {
        echo "❌ HATA: " . $e->getMessage() . "\n";
        $errors++;
    }
}

echo "\n=== SONUÇ ===\n";
echo "✅ Güncellenen: $updated\n";
echo "❌ Hatalı: $errors\n";
echo "\n✅ İşlem tamamlandı! Şimdi siteyi kontrol edin.\n";
