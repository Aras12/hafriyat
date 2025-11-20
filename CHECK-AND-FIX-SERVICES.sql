-- KAYSERI EMIR HAFRIYAT - HİZMET İÇERİKLERİNİ KONTROL VE DÜZELTME
-- Bu SQL dosyasını cPanel > phpMyAdmin'de çalıştırın

-- 1. ÖNCE MEVCUT DURUMU KONTROL ET
-- Her hizmetin slug, title, description başlangıcını göster
SELECT
    id,
    slug,
    title,
    LEFT(meta_description, 50) as meta_desc_start,
    LEFT(description, 50) as desc_start,
    LEFT(short_description, 50) as short_desc_start
FROM services
ORDER BY sort_order ASC;

-- 2. HER HİZMETİN DOĞRU İÇERİĞİ OLMALI
-- Aşağıdaki UPDATE komutlarını tek tek çalıştırın

-- EKSKAVATÖR KIRALAMA
UPDATE services SET
    description = '<p>Profesyonel ekskavatör kiralama hizmeti sunuyoruz. İnşaat, kazı ve hafriyat işleriniz için son model ekskavatörler.</p>',
    short_description = 'Profesyonel kazı ve hafriyat',
    meta_description = 'Kayseri\'de ekskavatör kiralama hizmeti. İnşaat, kazı ve hafriyat işleriniz için profesyonel çözümler.',
    features = 'Profesyonel operatör,Son model araçlar,Hızlı servis,Uygun fiyat'
WHERE slug = 'ekskavator';

-- BEKO LODER KIRALAMA
UPDATE services SET
    description = '<p>Beko loder kiralama hizmeti ile hafriyat ve yükleme işlerinizi kolaylaştırın. Deneyimli operatörlerimizle hizmetinizdeyiz.</p>',
    short_description = 'Hafriyat ve yükleme işleri',
    meta_description = 'Kayseri\'de beko loder kiralama hizmeti. Hafriyat ve yükleme işleriniz için profesyonel çözümler.',
    features = 'Deneyimli operatör,Bakımlı araçlar,7/24 hizmet,Uygun fiyat'
WHERE slug = 'bekoloder';

-- MANITOU KIRALAMA
UPDATE services SET
    description = '<p>Manitou forklift kiralama hizmeti sunuyoruz. Yükleme ve taşıma işleriniz için profesyonel çözümler.</p>',
    short_description = 'Yükleme ve taşıma hizmetleri',
    meta_description = 'Manitou forklift kiralama hizmeti Kayseri. Yükleme ve taşıma işleriniz için profesyonel çözümler.',
    features = 'Yüksek kaldırma kapasitesi,Güvenli kullanım,Profesyonel operatör,Bakımlı araçlar'
WHERE slug = 'manitou';

-- KAMYON KIRALAMA
UPDATE services SET
    description = '<p>Kamyon kiralama hizmeti ile nakliye ve hafriyat taşıma işlerinizi güvenle tamamlayın.</p>',
    short_description = 'Nakliye ve hafriyat taşıma',
    meta_description = 'Kayseri\'de kamyon kiralama hizmeti. Nakliye ve hafriyat taşıma işleriniz için profesyonel çözümler.',
    features = 'Geniş araç filosu,Deneyimli sürücüler,Hızlı teslimat,Uygun fiyat'
WHERE slug = 'kamyon';

-- BİNA YIKIM
UPDATE services SET
    description = '<p>Profesyonel bina yıkımı hizmeti sunuyoruz. Güvenli ve hızlı yıkım işlemleri için uzman ekibimizle hizmetinizdeyiz.</p>',
    short_description = 'Güvenli ve hızlı yıkım',
    meta_description = 'Kayseri\'de profesyonel bina yıkımı hizmeti. Güvenli ve hızlı yıkım işlemleri.',
    features = 'Güvenli yıkım,Moloz temizliği,Hızlı iş bitirme,Uygun fiyat'
WHERE slug = 'bina-yikim';

-- TEMEL KAZMA
UPDATE services SET
    description = '<p>Temel kazma ve kazı işlemleri için profesyonel hizmet. İnşaatınızın sağlam temelleri için bize güvenin.</p>',
    short_description = 'Sağlam temeller için profesyonel kazı',
    meta_description = 'Kayseri\'de temel kazma hizmeti. İnşaatınızın sağlam temelleri için profesyonel kazı işlemleri.',
    features = 'Hassas ölçüm,Profesyonel kazı,Hızlı iş bitirme,Kaliteli hizmet'
WHERE slug = 'temel-kazma';

-- ALT YAPI ÇALIŞMALARI
UPDATE services SET
    description = '<p>Alt yapı çalışmaları için profesyonel hizmet. Kanalizasyon, su, elektrik alt yapı işlerinizi güvenle tamamlıyoruz.</p>',
    short_description = 'Kanalizasyon ve su alt yapı',
    meta_description = 'Kayseri\'de alt yapı çalışmaları. Kanalizasyon, su, elektrik alt yapı işleriniz için profesyonel çözümler.',
    features = 'Profesyonel ekip,Kaliteli malzeme,Hızlı kurulum,Garantili hizmet'
WHERE slug = 'altyapi';

-- TAŞ DUVAR
UPDATE services SET
    description = '<p>Estetik ve dayanıklı doğal taş duvar uygulamaları yapıyoruz. İstinat duvarları, bahçe duvarları ve dekoratif taş işçiliği.</p>',
    short_description = 'Doğal taş duvar ve istinat',
    meta_description = 'Kayseri\'de taş duvar uygulamaları. İstinat duvarları, bahçe duvarları ve dekoratif taş işçiliği.',
    features = 'Doğal taş malzeme,Estetik görünüm,Dayanıklı yapı,Profesyonel işçilik'
WHERE slug = 'tas-duvar';

-- 3. GÜNCELLEMEDEN SONRA KONTROL ET
SELECT
    id,
    slug,
    title,
    LEFT(meta_description, 50) as meta_desc,
    LEFT(description, 50) as description,
    features
FROM services
ORDER BY sort_order ASC;

-- 4. EĞER HALA SORUN VARSA, HER HİZMETİN ID'SİNİ KONTROL ET
-- Örnek: Manitou'nun ID'si kaç?
SELECT id, slug, title FROM services WHERE slug = 'manitou';

-- 5. HATA AYIKLAMA: Tüm hizmetlerin detaylı bilgisi
SELECT * FROM services ORDER BY sort_order ASC;
