-- =================================================================
-- VERİTABANI DÜZELTME SQL KODLARI
-- Tüm hizmetlerin doğru image ve description verilerini geri yükler
-- =================================================================

-- KULLANIM:
-- 1. phpMyAdmin'e girin
-- 2. Veritabanınızı seçin
-- 3. SQL sekmesine gidin
-- 4. Aşağıdaki kodları yapıştırıp çalıştırın

-- =================================================================

-- 1. EKSKAVATÖR
UPDATE services SET
  description = '<p>Kayseri\'de profesyonel ekskavatör kiralama hizmeti sunuyoruz. 20-40 ton kapasiteli modern ekskavatörlerimizle her türlü hafriyat işinizi güvenle gerçekleştiriyoruz.</p><p>Deneyimli operatörlerimiz ve düzenli bakımı yapılan makinelerimizle işlerinizi zamanında teslim ediyoruz.</p>',
  image = 'assets/img/hizmetler/ekskavator.jpg'
WHERE slug = 'ekskavator';

-- 2. BEKO LODER
UPDATE services SET
  description = '<p>Beko loderlerimiz hem kazma hem de yükleme işlemlerinde kullanılabilir. Dar alanlarda çalışmaya uygun, çok yönlü makinelerimiz her türlü ihtiyacınıza cevap verir.</p>',
  image = 'assets/img/hizmetler/bekoloder.jpg'
WHERE slug = 'bekoloder';

-- 3. MANITOU
UPDATE services SET
  description = '<p>Manitou forkliftlerimiz ile malzeme taşıma ve yükleme işlerinizi kolaylaştırıyoruz. İnşaat sahalarında vazgeçilmez ekipmanlarımızla hizmetinizdeyiz.</p>',
  image = 'assets/img/hizmetler/manitou.jpg'
WHERE slug = 'manitou';

-- 4. KAMYON
UPDATE services SET
  description = '<p>10-30 ton kapasiteli kamyonlarımız ile hafriyat, moloz ve inşaat malzemesi taşıma hizmetleri sunuyoruz. Profesyonel sürücülerimiz ile güvenli nakliye garantisi.</p>',
  image = 'assets/img/hizmetler/kamyon.jpg'
WHERE slug = 'kamyon';

-- 5. BİNA YIKIM
UPDATE services SET
  description = '<p>Profesyonel ekibimiz ve modern ekipmanlarımızla bina yıkım işlemlerini güvenli bir şekilde gerçekleştiriyoruz. Tüm yasal izinler ve güvenlik önlemleri tarafımızdan sağlanır.</p>',
  image = 'assets/img/hizmetler/bina-yikim.jpg'
WHERE slug = 'bina-yikim';

-- 6. TEMEL KAZMA
UPDATE services SET
  description = '<p>Binaların en önemli kısmı olan temel kazı işlemlerini özenle gerçekleştiriyoruz. Zemin etüdü ve statik hesaplamalara uygun kazı yapıyoruz.</p>',
  image = 'assets/img/hizmetler/temel-kazma.jpg'
WHERE slug = 'temel-kazma';

-- 7. ALT YAPI
UPDATE services SET
  description = '<p>Kanalizasyon, su, elektrik ve doğalgaz altyapı çalışmalarında uzmanız. Belediye standartlarına uygun, kaliteli işçilik garantisi.</p>',
  image = 'assets/img/hizmetler/altyapi.jpg'
WHERE slug = 'altyapi';

-- 8. TAŞ DUVAR
UPDATE services SET
  description = '<p>Estetik ve dayanıklı doğal taş duvar uygulamaları yapıyoruz. İstinat duvarları, bahçe duvarları ve dekoratif taş işçiliği.</p>',
  image = 'assets/img/hizmetler/tas-duvar.jpg'
WHERE slug = 'tas-duvar';

-- =================================================================
-- KONTROL: Tüm hizmetleri görmek için
-- =================================================================

SELECT id, title, slug,
  SUBSTRING(description, 1, 50) as desc_preview,
  image
FROM services
ORDER BY sort_order;

-- =================================================================
-- İŞLEM TAMAMLANDI!
-- Şimdi siteyi kontrol edin: /hizmet/ekskavator, /hizmet/bekoloder vb.
-- =================================================================
