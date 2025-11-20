-- Kayseri Emir Hafriyat - Veritabanı Yapısı
-- MySQL Database Schema

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+03:00";

-- --------------------------------------------------------

-- Tablo yapısı: admin_users
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin kullanıcısı (Kullanıcı: admin, Şifre: admin123)
INSERT INTO `admin_users` (`username`, `password`, `email`, `full_name`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'info@kayseriemirhafriyat.com.tr', 'Admin');

-- --------------------------------------------------------

-- Tablo yapısı: settings
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `setting_type` varchar(50) DEFAULT 'text',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ayarlar
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`) VALUES
('site_title', 'Emir Hafriyat - Kayseri', 'text'),
('site_logo', 'assets/img/logo.png', 'text'),
('site_favicon', 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚛</text></svg>', 'text'),
('company_phone', '0531 702 35 38', 'text'),
('company_email', 'info@kayseriemirhafriyat.com.tr', 'text'),
('company_address', 'Yeşilyurt Mah. 3232 Sokak No:21, Melikgazi/Kayseri', 'text'),
('company_experience', '25', 'text'),
('smtp_host', '', 'text'),
('smtp_port', '587', 'text'),
('smtp_username', '', 'text'),
('smtp_password', '', 'text'),
('smtp_encryption', 'tls', 'text'),
('meta_home_title', 'Kayseri Hafriyat - Emir Hafriyat | Ekskavatör, Beko Loder, Kamyon Kiralama', 'text'),
('meta_home_description', 'Kayseri\'de 25 yıllık tecrübesiyle hafriyat ve nakliyat hizmetleri. Ekskavatör, beko loder, manitou, kamyon kiralama. Profesyonel ve güvenilir çözümler.', 'text'),
('meta_home_keywords', 'kayseri hafriyat, ekskavatör kiralama, beko loder, kamyon kiralama, bina yıkımı, temel kazma, alt yapı', 'text');

-- --------------------------------------------------------

-- Tablo yapısı: sliders
CREATE TABLE `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Slider verileri
INSERT INTO `sliders` (`title`, `description`, `image`, `button_text`, `button_link`, `sort_order`, `status`) VALUES
('Profesyonel Hafriyat Hizmetleri', 'Kayseri\'de 25 yıllık tecrübemizle kaliteli ve güvenilir hafriyat çözümleri sunuyoruz.', 'assets/img/slider/slide1.jpg', 'Hizmetlerimiz', 'hizmetler.html', 1, 1),
('Modern İş Makineleri', 'Son model ekskavatör, beko loder ve kamyonlarımızla projelerinizi zamanında teslim ediyoruz.', 'assets/img/slider/slide2.jpg', 'Makinelerimiz', 'hizmetler.html', 2, 1),
('Güvenli ve Hızlı Çözümler', 'Deneyimli ekibimiz ve modern ekipmanlarımızla işlerinizi güvenle tamamlıyoruz.', 'assets/img/slider/slide3.jpg', 'İletişime Geçin', 'iletisim.html', 3, 1);

-- --------------------------------------------------------

-- Tablo yapısı: services
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `short_description` text,
  `description` text NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `features` text,
  `tab_category` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `meta_title` varchar(200) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Hizmetler
INSERT INTO `services` (`title`, `slug`, `short_description`, `description`, `icon`, `image`, `features`, `tab_category`, `sort_order`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
('Ekskavatör Kiralama', 'ekskavator', '20-40 ton kapasiteli modern ekskavatörler', '<p>Kayseri\'de profesyonel ekskavatör kiralama hizmeti sunuyoruz. 20-40 ton kapasiteli modern ekskavatörlerimizle her türlü hafriyat işinizi güvenle gerçekleştiriyoruz.</p><p>Deneyimli operatörlerimiz ve düzenli bakımı yapılan makinelerimizle işlerinizi zamanında teslim ediyoruz.</p>', 'fas fa-truck-monster', 'assets/img/hizmetler/ekskavator.jpg', 'Modern ekipman,Deneyimli operatör,7/24 hizmet,Uygun fiyat', 'is_makineleri', 1, 'Kayseri Ekskavatör Kiralama | 20-40 Ton | Emir Hafriyat', 'Kayseri\'de 20-40 ton kapasiteli ekskavatör kiralama hizmeti. Profesyonel operatör ve modern ekipmanlarla güvenli hafriyat çözümleri.', 'kayseri ekskavatör, ekskavatör kiralama, hafriyat makinesi'),

('Beko Loder Kiralama', 'bekoloder', 'Çok amaçlı kullanım için ideal', '<p>Beko loderlerimiz hem kazma hem de yükleme işlemlerinde kullanılabilir. Dar alanlarda çalışmaya uygun, çok yönlü makinelerimiz her türlü ihtiyacınıza cevap verir.</p>', 'fas fa-truck-loading', 'assets/img/hizmetler/bekoloder.jpg', 'Çok amaçlı kullanım,Dar alanda çalışabilir,Ekonomik,Hızlı servis', 'is_makineleri', 2, 'Kayseri Beko Loder Kiralama | Emir Hafriyat', 'Kayseri beko loder kiralama hizmeti. Kazı ve yükleme işleriniz için profesyonel çözümler. Uygun fiyat, kaliteli hizmet.', 'beko loder, beko kiralama, kayseri iş makinesi'),

('Manitou Kiralama', 'manitou', 'Yükleme ve taşıma işleri', '<p>Manitou forkliftlerimiz ile malzeme taşıma ve yükleme işlerinizi kolaylaştırıyoruz. İnşaat sahalarında vazgeçilmez ekipmanlarımızla hizmetinizdeyiz.</p>', 'fas fa-forklift', 'assets/img/hizmetler/manitou.jpg', 'Yüksek kaldırma kapasitesi,Güvenli kullanım,Profesyonel operatör,Bakımlı araçlar', 'is_makineleri', 3, 'Kayseri Manitou Kiralama | Forklift | Emir Hafriyat', 'Manitou forklift kiralama hizmeti Kayseri. Yükleme ve taşıma işleriniz için profesyonel çözümler.', 'manitou kiralama, forklift, kayseri taşıma'),

('Kamyon Kiralama', 'kamyon', 'Moloz ve hafriyat taşıma', '<p>10-30 ton kapasiteli kamyonlarımız ile hafriyat, moloz ve inşaat malzemesi taşıma hizmetleri sunuyoruz. Profesyonel sürücülerimiz ile güvenli nakliye garantisi.</p>', 'fas fa-truck', 'assets/img/hizmetler/kamyon.jpg', 'Farklı tonajlar,Sigortalı taşıma,Deneyimli sürücü,Zamanında teslimat', 'is_makineleri', 4, 'Kayseri Kamyon Kiralama | Hafriyat Taşıma | Emir Hafriyat', 'Kayseri hafriyat ve moloz taşıma kamyonu kiralama. 10-30 ton kapasiteli kamyonlarla profesyonel nakliye hizmeti.', 'kamyon kiralama, hafriyat taşıma, moloz taşıma'),

('Bina Yıkımı', 'bina-yikim', 'Güvenli ve kontrollü yıkım', '<p>Profesyonel ekibimiz ve modern ekipmanlarımızla bina yıkım işlemlerini güvenli bir şekilde gerçekleştiriyoruz. Tüm yasal izinler ve güvenlik önlemleri tarafımızdan sağlanır.</p>', 'fas fa-hammer', 'assets/img/hizmetler/bina-yikim.jpg', 'Güvenli yıkım,Yasal izinler,Moloz temizliği,Sigortalı hizmet', 'insaat', 5, 'Kayseri Bina Yıkımı | Kontrollü Yıkım | Emir Hafriyat', 'Kayseri\'de profesyonel bina yıkımı hizmeti. Güvenli, yasal izinli ve sigortalı yıkım işlemleri.', 'bina yıkımı, yıkım işleri, kayseri yıkım'),

('Temel Kazma', 'temel-kazma', 'Sağlam temeller için profesyonel kazı', '<p>Binaların en önemli kısmı olan temel kazı işlemlerini özenle gerçekleştiriyoruz. Zemin etüdü ve statik hesaplamalara uygun kazı yapıyoruz.</p>', 'fas fa-hard-hat', 'assets/img/hizmetler/temel-kazma.jpg', 'Zemin analizi,Statik uygunluk,Hassas çalışma,Deneyimli ekip', 'insaat', 6, 'Kayseri Temel Kazma | Profesyonel Kazı | Emir Hafriyat', 'Kayseri temel kazma hizmeti. Zemin analizli, statik uygun profesyonel kazı işlemleri.', 'temel kazma, kazı işleri, temel hafriyat'),

('Alt Yapı Çalışmaları', 'altyapi', 'Kanalizasyon ve elektrik altyapısı', '<p>Kanalizasyon, su, elektrik ve doğalgaz altyapı çalışmalarında uzmanız. Belediye standartlarına uygun, kaliteli işçilik garantisi.</p>', 'fas fa-road', 'assets/img/hizmetler/altyapi.jpg', 'Belediye standartları,Kaliteli malzeme,Hızlı iş bitirme,Garanti belgeli', 'altyapi', 7, 'Kayseri Altyapı Çalışmaları | Kanalizasyon | Emir Hafriyat', 'Kayseri altyapı çalışmaları. Kanalizasyon, su, elektrik altyapı hizmetleri. Belediye onaylı işler.', 'altyapı, kanalizasyon, kayseri altyapı'),

('Taş Duvar', 'tas-duvar', 'Doğal taş duvar ve istinat', '<p>Estetik ve dayanıklı doğal taş duvar uygulamaları yapıyoruz. İstinat duvarları, bahçe duvarları ve dekoratif taş işçiliği.</p>', 'fas fa-mountain', 'assets/img/hizmetler/tas-duvar.jpg', 'Doğal taş,Estetik görünüm,Uzun ömürlü,Profesyonel işçilik', 'altyapi', 8, 'Kayseri Taş Duvar | İstinat Duvarı | Emir Hafriyat', 'Kayseri doğal taş duvar ve istinat duvarı hizmeti. Estetik ve dayanıklı taş işçiliği.', 'taş duvar, istinat duvarı, kayseri taş');

-- --------------------------------------------------------

-- Tablo yapısı: service_tabs
CREATE TABLE `service_tabs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tab_name` varchar(100) NOT NULL,
  `tab_key` varchar(50) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tab_key` (`tab_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tab kategorileri
INSERT INTO `service_tabs` (`tab_name`, `tab_key`, `icon`, `sort_order`) VALUES
('İş Makineleri', 'is_makineleri', 'fas fa-truck-monster', 1),
('İnşaat Hizmetleri', 'insaat', 'fas fa-hard-hat', 2),
('Alt Yapı', 'altyapi', 'fas fa-road', 3);

-- --------------------------------------------------------

-- Tablo yapısı: faqs
CREATE TABLE `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SSS
INSERT INTO `faqs` (`question`, `answer`, `sort_order`) VALUES
('Hangi bölgelere hizmet veriyorsunuz?', 'Kayseri merkez ve tüm ilçelerinde hizmet vermekteyiz. Komşu illere de özel projeler için hizmet sağlayabiliyoruz.', 1),
('Ekskavatör kiralama fiyatları nasıl belirleniyor?', 'Fiyatlarımız çalışma süresine, işin türüne ve makine kapasitesine göre değişmektedir. Detaylı fiyat teklifi için bizi arayabilirsiniz.', 2),
('Operatör dahil mi kiralama yapıyorsunuz?', 'Evet, tüm makinelerimiz deneyimli ve sertifikalı operatörler ile birlikte kiralanmaktadır.', 3),
('Acil durumlarda hizmet veriyor musunuz?', 'Evet, 7/24 acil servis hizmeti sunmaktayız. Acil durumlar için bizi arayabilirsiniz.', 4),
('Sigorta ve ruhsat durumu nasıl?', 'Tüm makinelerimiz sigortalı ve gerekli tüm ruhsatlar mevcuttur. Güvenli çalışma garantisi veriyoruz.', 5);

-- --------------------------------------------------------

-- Tablo yapısı: testimonials
CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `client_company` varchar(150) DEFAULT NULL,
  `comment` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Yorumlar
INSERT INTO `testimonials` (`client_name`, `client_company`, `comment`, `rating`, `sort_order`) VALUES
('Ahmet Yılmaz', 'Yılmaz İnşaat', 'Emir Hafriyat ile çalışmak gerçekten keyifliydi. Profesyonel ekip, zamanında teslimat ve kaliteli hizmet. Teşekkürler!', 5, 1),
('Mehmet Kaya', 'Kaya Yapı', 'Yıllardır birlikte çalıştığımız güvenilir bir firma. Modern makineleri ve deneyimli personeli ile işlerimizi sorunsuz hallediyor.', 5, 2),
('Fatma Demir', 'Demir Müteahhitlik', 'Taş duvar işinde çok memnun kaldık. Hem estetik hem de sağlam bir iş çıktı. Herkese tavsiye ederim.', 5, 3);

-- --------------------------------------------------------

-- Tablo yapısı: blog
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `excerpt` text,
  `content` text NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT 'Admin',
  `views` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `meta_title` varchar(200) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Blog yazıları
INSERT INTO `blog` (`title`, `slug`, `excerpt`, `content`, `featured_image`, `category`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
('Doğru Ekskavatör Seçimi Nasıl Yapılır?', 'ekskavator-secimi', 'İnşaat ve hafriyat işlerinde doğru ekskavatör seçimi projenizin başarısı için kritik öneme sahiptir.', '<p>İnşaat ve hafriyat işlerinde doğru ekskavatör seçimi projenizin başarısı için kritik öneme sahiptir...</p>', 'assets/img/blog/ekskavator.jpg', 'Hafriyat', 'Doğru Ekskavatör Seçimi Nasıl Yapılır? | Emir Hafriyat Blog', 'İnşaat ve hafriyat işlerinde doğru ekskavatör seçimi için kapsamlı rehber. Tonaj, kova seçimi, operatör eğitimi hakkında bilgiler.', 'ekskavatör seçimi, hafriyat makinesi, iş makinesi'),

('Temel Kazısında Dikkat Edilmesi Gerekenler', 'temel-kazisi-dikkat-edilenler', 'Bina inşaatının en kritik aşamalarından biri olan temel kazısı, yapının ömrünü ve güvenliğini doğrudan etkiler.', '<p>Bina inşaatının en kritik aşamalarından biri olan temel kazısı, yapının ömrünü ve güvenliğini doğrudan etkiler...</p>', 'assets/img/blog/temel-kazisi.jpg', 'İnşaat', 'Temel Kazısında Dikkat Edilmesi Gerekenler | Blog', 'Temel kazısında dikkat edilmesi gereken önemli noktalar. Zemin etüdü, kazı derinliği, güvenlik önlemleri hakkında detaylı bilgi.', 'temel kazısı, kazı işleri, inşaat temeli'),

('Bina Yıkımında Güvenlik Önlemleri', 'bina-yikim-guvenlik', 'Bina yıkımı, ciddi güvenlik riskleri barındıran karmaşık bir işlemdir.', '<p>Bina yıkımı, ciddi güvenlik riskleri barındıran karmaşık bir işlemdir...</p>', 'assets/img/blog/bina-yikim.jpg', 'Güvenlik', 'Bina Yıkımında Güvenlik Önlemleri | Emir Hafriyat', 'Bina yıkımında alınması gereken güvenlik önlemleri. Yasal izinler, ekipman kontrolü ve iş güvenliği hakkında bilgiler.', 'bina yıkımı, yıkım güvenliği, iş güvenliği'),

('Hafriyat Nedir ve Ne Zaman Gereklidir?', 'hafriyat-nedir-ne-zaman-gerekli', 'Hafriyat, toprak kazma ve taşıma işlemlerinin genel adıdır.', '<p>Hafriyat, toprak kazma ve taşıma işlemlerinin genel adıdır. İnşaat projelerinin temel aşamasıdır...</p>', 'assets/img/blog/hafriyat.jpg', 'Hafriyat', 'Hafriyat Nedir ve Ne Zaman Gereklidir? | Blog', 'Hafriyat işleri hakkında kapsamlı bilgi. Ne zaman gereklidir, nasıl yapılır, hangi makineler kullanılır?', 'hafriyat nedir, kazı işleri, toprak hafriyatı');

-- --------------------------------------------------------

-- Tablo yapısı: gallery
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Galeri
INSERT INTO `gallery` (`title`, `description`, `image`, `category`, `sort_order`) VALUES
('Ekskavatör Çalışması', 'Temel kazı projemizden görüntüler', 'assets/img/galeri/galeri1.jpg', 'Hafriyat', 1),
('Bina Yıkımı', 'Kontrollü yıkım işlemi', 'assets/img/galeri/galeri2.jpg', 'Yıkım', 2),
('Taş Duvar', 'İstinat duvarı uygulaması', 'assets/img/galeri/galeri3.jpg', 'Duvar', 3),
('Kamyon Çalışması', 'Hafriyat taşıma', 'assets/img/galeri/galeri4.jpg', 'Nakliye', 4);

-- --------------------------------------------------------

-- Tablo yapısı: projects
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `location` varchar(200) DEFAULT NULL,
  `client` varchar(150) DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Projeler
INSERT INTO `projects` (`title`, `description`, `location`, `client`, `completion_date`, `image`, `category`, `sort_order`) VALUES
('Konut Projesi Temel Kazısı', '5 katlı konut projesi için temel kazı çalışması', 'Melikgazi, Kayseri', 'Yılmaz İnşaat', '2024-10-15', 'assets/img/projeler/proje1.jpg', 'Konut', 1),
('Fabrika Alt Yapısı', 'Sanayi tesisi altyapı çalışması', 'OSB, Kayseri', 'Demir Sanayi', '2024-09-20', 'assets/img/projeler/proje2.jpg', 'Sanayi', 2),
('Plaza Yıkımı', 'Eski plaza binası kontrollü yıkım', 'Kocasinan, Kayseri', 'Kaya Müteahhitlik', '2024-11-01', 'assets/img/projeler/proje3.jpg', 'Yıkım', 3),
('Taş Duvar İstinat', 'Bahçe istinat duvarı projesi', 'Talas, Kayseri', 'Özel Müşteri', '2024-08-10', 'assets/img/projeler/proje4.jpg', 'Duvar', 4),
('Kanalizasyon Hattı', 'Mahalle kanalizasyon yenileme', 'Hacılar, Kayseri', 'Belediye', '2024-07-05', 'assets/img/projeler/proje5.jpg', 'Altyapı', 5),
('AVM Temel Kazısı', 'Alışveriş merkezi temel kazı', 'Kocasinan, Kayseri', 'Mega İnşaat', '2024-06-15', 'assets/img/projeler/proje6.jpg', 'Ticari', 6);

-- --------------------------------------------------------

-- Tablo yapısı: pages
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_key` varchar(100) NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `content` text,
  `meta_title` varchar(200) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_key` (`page_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sayfalar
INSERT INTO `pages` (`page_key`, `page_title`, `content`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
('hakkimizda', 'Hakkımızda', '<p>Kayseri Emir Hafriyat olarak 25 yıldır sektörde hizmet vermekteyiz...</p>', 'Hakkımızda | Emir Hafriyat', 'Kayseri Emir Hafriyat hakkında bilgi. 25 yıllık deneyim, modern ekipman ve profesyonel ekip.', 'hakkımızda, emir hafriyat, kayseri'),
('iletisim', 'İletişim', '', 'İletişim | Emir Hafriyat', 'Kayseri Emir Hafriyat iletişim bilgileri. Adres, telefon, e-posta.', 'iletişim, telefon, adres'),
('hizmetler', 'Hizmetlerimiz', '', 'Hizmetlerimiz | Emir Hafriyat', 'Kayseri\'de hafriyat ve nakliyat hizmetlerimiz. Ekskavatör, beko loder, kamyon kiralama ve daha fazlası.', 'hizmetler, hafriyat, nakliyat'),
('galeri', 'Galeri', '', 'Galeri | Projelerimizden Görüntüler', 'Emir Hafriyat proje galerisi. Gerçekleştirdiğimiz hafriyat, yıkım ve inşaat projelerinden fotoğraflar.', 'galeri, projeler, fotoğraflar'),
('projeler', 'Projelerimiz', '', 'Projelerimiz | Emir Hafriyat', 'Tamamladığımız başarılı projeler. Konut, sanayi, altyapı projeleri.', 'projeler, referanslar, işler'),
('blog', 'Blog', '', 'Blog | Hafriyat ve İnşaat Makaleleri', 'Hafriyat, inşaat ve iş makineleri hakkında güncel bilgiler ve makaleler.', 'blog, makaleler, hafriyat');

-- --------------------------------------------------------

-- Tablo yapısı: contact_messages
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- ============================================================
-- BLOG İÇERİK GÜNCELLEMELERİ
-- Kayseri Emir Hafriyat - Blog Yazıları Tam İçerik
-- Not: UPDATE'ler INSERT'lerden sonra çalışacak
-- ============================================================

-- 1. Doğru Ekskavatör Seçimi Nasıl Yapılır?
UPDATE `blog` SET
  `content` = '<img src="assets/img/blog/blog1.jpg" alt="Ekskavatör Seçimi" class="img-fluid rounded mb-4">

<div class="mb-4">
    <span class="blog-date"><i class="fas fa-calendar"></i> 15 Kasım 2024</span>
    <span class="ms-3"><i class="fas fa-user"></i> Kayseri Emir Hafriyat</span>
</div>

<h1>Doğru Ekskavatör Seçimi Nasıl Yapılır?</h1>

<p>İnşaat ve hafriyat projelerinde en kritik kararlardan biri, projeniz için doğru ekskavatör tonajını seçmektir. Yanlış seçim hem maliyetleri artırır hem de iş verimliliğini düşürür. Bu yazımızda, projenize en uygun ekskavatörü nasıl seçeceğinizi detaylı olarak anlatıyoruz.</p>

<h2>Proje Büyüklüğüne Göre Tonaj Seçimi</h2>

<h3>20 Ton Ekskavatör - Küçük Ölçekli Projeler</h3>
<p>Villa ve ev temel kazıları, bahçe düzenleme işleri için idealdir. Dar alanlarda rahatça çalışabilir. Yakıt tüketimi düşüktür ve küçük projeler için maliyet etkindir.</p>

<h3>30 Ton Ekskavatör - Orta Ölçekli Projeler</h3>
<p>Apartman ve küçük iş merkezi temel kazıları için uygundur. Yol çalışmaları ve orta derinlikte kazılar için tercih edilir.</p>

<h3>35-40 Ton Ekskavatör - Büyük Projeler</h3>
<p>Fabrika, AVM ve toplu konut projeleri için gereklidir. Derin kazı işlerinde ve büyük hafriyatlarda kullanılır.</p>

<h2>Dikkat Edilmesi Gereken Faktörler</h2>
<ul>
    <li><strong>Kazı Derinliği:</strong> Proje ne kadar derin kazı gerektiriyorsa o kadar büyük tonaj gerekir</li>
    <li><strong>Zemin Yapısı:</strong> Kayalık ve sert zeminler için daha güçlü makineler şarttır</li>
    <li><strong>Çalışma Alanı:</strong> Dar alanlarda küçük tonajlı makineler daha pratiktir</li>
    <li><strong>Proje Süresi:</strong> Uzun süreli projeler için aylık kiralama daha ekonomiktir</li>
    <li><strong>Bütçe:</strong> Tonajla birlikte kiralama maliyeti de artar</li>
</ul>

<h2>Operatör Tecrübesi</h2>
<p>Doğru makineyi seçmek kadar, deneyimli bir operatörle çalışmak da önemlidir. Kayseri Emir Hafriyat olarak, 25 yıllık tecrübemiz ve uzman operatör kadromuzla projelerinizde yanınızdayız.</p>

<div class="price-box">
    <h3>Ücretsiz Danışmanlık</h3>
    <p>Projeniz için hangi tonajın uygun olduğunu öğrenmek ister misiniz? Hemen arayın!</p>
    <a href="tel:05317023538" class="btn btn-light btn-lg">0531 702 35 38</a>
</div>',
  `excerpt` = 'Projeniz için doğru ekskavatör tonajını nasıl seçersiniz? 20 ton, 30 ton, 35 ton ve 40 ton ekskavatör özellikleri ve kullanım alanları hakkında detaylı bilgi.',
  `meta_title` = 'Doğru Ekskavatör Seçimi Nasıl Yapılır? - Kayseri Emir Hafriyat Blog',
  `meta_description` = 'Projeniz için doğru ekskavatör tonajını seçme rehberi. 20-40 ton ekskavatör özellikleri, kullanım alanları ve seçim kriterleri. Uzman tavsiyeleri ile kazı işleriniz için ideal iş makinesini bulun.',
  `meta_keywords` = 'ekskavatör seçimi, ekskavatör tonajı, 20 ton ekskavatör, 30 ton ekskavatör, 35 ton ekskavatör, 40 ton ekskavatör, kazı makinesi, hafriyat makinesi'
WHERE `slug` = 'ekskavator-secimi';


-- 2. Temel Kazısında Dikkat Edilmesi Gerekenler
UPDATE `blog` SET
  `content` = '<img src="assets/img/blog/temel-kazisi.jpg" alt="Temel Kazısı" class="img-fluid rounded mb-4">

<p class="lead">Bir binanın ömrü ve güvenliği, temelin ne kadar sağlam atıldığına bağlıdır. Temel kazısı, inşaat sürecinin en kritik aşamalarından biridir ve doğru yapılmazsa telafisi olmayan sorunlara yol açabilir.</p>

<h2>1. Zemin Etüdü Mutlaka Yapılmalı</h2>
<p>Temel kazısına başlamadan önce mutlaka zemin etüdü yaptırılmalıdır. Zemin etüdü sayesinde:</p>
<ul>
    <li>Zeminin taşıma kapasitesi belirlenir</li>
    <li>Zemin cinsi (kil, kum, kaya vb.) tespit edilir</li>
    <li>Yeraltı su seviyesi öğrenilir</li>
    <li>Doğru temel tipi seçilir</li>
    <li>Olası zemin problemleri önceden görülür</li>
</ul>
<p>Zemin etüdü yapmadan temel kazısına başlamak, büyük bir risk almak anlamına gelir.</p>

<h2>2. Temel Derinliği Çok Önemli</h2>
<p>Temel derinliği, zemin türüne, bina ağırlığına ve iklim koşullarına göre belirlenir:</p>
<ul>
    <li><strong>Tek katlı binalar:</strong> Minimum 80-100 cm derinlik</li>
    <li><strong>İki katlı binalar:</strong> 120-150 cm derinlik</li>
    <li><strong>Çok katlı binalar:</strong> Statik projeye göre belirlenir</li>
    <li><strong>Don derinliği:</strong> Kayseri gibi soğuk bölgelerde don derinliğinin altına inilmelidir (yaklaşık 80 cm)</li>
</ul>

<h2>3. Kazı Yapılırken Dikkat Edilecekler</h2>

<h3>Mevcut Yapılar</h3>
<p>Komşu binaların temeline zarar vermemek için:</p>
<ul>
    <li>Komşu bina temellerinin derinliği tespit edilmeli</li>
    <li>45 derece kazı kuralına uyulmalı</li>
    <li>Gerekirse iksa sistemi kurulmalı</li>
    <li>Komşu bina duvarları çatlak açısından izlenmeli</li>
</ul>

<h3>Alt Yapı Hatları</h3>
<p>Kazı sırasında karşılaşılabilecek alt yapı hatları:</p>
<ul>
    <li>Su hatları (şebeke + kanalizasyon)</li>
    <li>Elektrik hatları</li>
    <li>Doğalgaz hatları</li>
    <li>Telefon ve internet altyapısı</li>
</ul>
<p><strong>Önemli:</strong> Kazıya başlamadan önce ilgili kurumlardan (su, elektrik, doğalgaz) hat bilgileri alınmalıdır.</p>

<h2>4. Drenaj Sistemi Şart</h2>
<p>Temelde su birikmesi, binanın düşmanıdır. Mutlaka drenaj sistemi yapılmalıdır:</p>
<ul>
    <li>Temel çevresine dren boruları döşenmeli</li>
    <li>Dren boruları en az %2 eğimle yerleştirilmeli</li>
    <li>Çakıl/kum filtre tabakası oluşturulmalı</li>
    <li>Yağmur suları temelden uzaklaştırılmalı</li>
    <li>Zemin su izolasyonu yapılmalı</li>
</ul>

<h2>5. Güvenlik Önlemleri</h2>
<p>Temel kazısı tehlikeli bir iştir. Alınması gereken güvenlik önlemleri:</p>
<ul>
    <li><strong>Kazı derinliği 1.5 metreden fazlaysa:</strong> Şev verilmeli veya iksa yapılmalı</li>
    <li><strong>Kazı çevresi:</strong> Bariyer/çitle kapatılmalı</li>
    <li><strong>Işıklandırma:</strong> Gece çalışmalarında yeterli aydınlatma olmalı</li>
    <li><strong>Ekipman:</strong> İş makinesi operatörleri sertifikalı olmalı</li>
    <li><strong>İşçi güvenliği:</strong> Baret, yelek, güvenlik ayakkabısı kullanılmalı</li>
    <li><strong>Hava koşulları:</strong> Yağışlı havalarda çalışma durdurulmalı</li>
</ul>

<h2>6. Kazı Toprağının Değerlendirilmesi</h2>
<p>Kazıdan çıkan toprak doğru şekilde değerlendirilmelidir:</p>
<ul>
    <li><strong>Üst toprak:</strong> Bahçe düzenlemesinde kullanılabilir</li>
    <li><strong>Dolgu toprağı:</strong> Temel etrafı dolgusunda kullanılır</li>
    <li><strong>Fazla toprak:</strong> Hafriyat firması tarafından taşınmalı</li>
    <li><strong>Kaya çıkarsa:</strong> Kırıcı ekipman gerekebilir</li>
</ul>

<h2>7. Hava Koşulları ve Mevsim</h2>
<p>Temel kazısı için ideal dönem:</p>
<ul>
    <li><strong>İlkbahar-Yaz:</strong> En uygun dönem (kurak ve sıcak)</li>
    <li><strong>Sonbahar:</strong> Yağışlara dikkat edilmeli</li>
    <li><strong>Kış:</strong> Don riski nedeniyle sakıncalı</li>
    <li>Yağmurlu havalarda kazı yapılmamalı</li>
    <li>Kazı sonrası uzun süre açık bırakılmamalı</li>
</ul>

<h2>8. Kalite Kontrol</h2>
<p>Temel kazısı tamamlandıktan sonra kontrol edilmesi gerekenler:</p>
<ul>
    <li>Temel tabanı düz ve temiz mi?</li>
    <li>Ölçüler projeye uygun mu?</li>
    <li>Köşe açıları doğru mu? (90 derece kontrolü)</li>
    <li>Çaprazlar eşit mi? (dikdörtgenlik kontrolü)</li>
    <li>Temel tabanında gevşek toprak var mı?</li>
    <li>Su birikintisi var mı?</li>
</ul>

<div class="feature-box mt-4">
    <h4><i class="fas fa-lightbulb"></i> Uzman Tavsiyesi</h4>
    <p>Temel kazısı kesinlikle profesyonellere yaptırılmalıdır. Deneyimli bir hafriyat firması, olası problemleri önceden görerek önlem alır ve güvenli kazı yapar. 25 yıllık tecrübemizle binlerce temel kazısı gerçekleştirdik.</p>
</div>

<h2>Sonuç</h2>
<p>Temel kazısı, inşaatın en önemli aşamasıdır. Zemin etüdü, doğru derinlik, drenaj sistemi, güvenlik önlemleri ve profesyonel ekip ile yapılan temel kazısı, binanızın uzun ömürlü ve güvenli olmasını sağlar.</p>
<p>Hatırlayın: <strong>"Sağlam temel, sağlam bina demektir!"</strong></p>

<div class="price-box mt-5">
    <h3><i class="fas fa-phone"></i> Temel Kazısı İçin Bizi Arayın</h3>
    <p>Profesyonel temel kazı hizmeti için uzman ekibimizle iletişime geçin.</p>
    <a href="tel:05317023538" class="btn btn-light btn-lg me-2"><i class="fas fa-phone"></i> 0531 702 35 38</a>
    <a href="https://wa.me/905317023538" class="btn btn-success btn-lg"><i class="fab fa-whatsapp"></i> WhatsApp</a>
</div>',
  `excerpt` = 'Bir binanın ömrü ve güvenliği, temelin ne kadar sağlam atıldığına bağlıdır. Zemin etüdü, derinlik hesabı, drenaj sistemi ve güvenlik önlemleri hakkında bilmeniz gerekenler.',
  `meta_title` = 'Temel Kazısında Dikkat Edilmesi Gerekenler - Kayseri Emir Hafriyat',
  `meta_description` = 'Temel kazısında dikkat edilmesi gereken önemli noktalar. Zemin etüdü, derinlik hesabı, drenaj sistemi ve güvenlik önlemleri. Güvenli ve sağlam temel için profesyonel rehber.',
  `meta_keywords` = 'temel kazısı, zemin etüdü, temel derinliği, drenaj, inşaat, kayseri, temel hafriyatı'
WHERE `slug` = 'temel-kazisi-dikkat-edilenler';


-- 3. Bina Yıkımında Güvenlik Önlemleri
UPDATE `blog` SET
  `content` = '<img src="assets/img/blog/bina-yikim.jpg" alt="Bina Yıkımı Güvenlik" class="img-fluid rounded mb-4">

<p class="lead">Bina yıkımı, inşaat sektörünün en riskli işlerinden biridir. Yanlış yapılan yıkım işlemleri, can kaybına, yaralanmalara, çevre binalarına zarar verilmesine ve çevre kirliliğine yol açabilir. Bu yazımızda, güvenli bina yıkımı için alınması gereken tüm önlemleri detaylı olarak anlatacağız.</p>

<h2>1. Yasal İzinler ve Prosedürler</h2>
<p>Bina yıkımına başlamadan önce mutlaka tamamlanması gereken yasal işlemler:</p>

<h3>Gerekli İzinler</h3>
<ul>
    <li><strong>Belediyeden yıkım ruhsatı:</strong> Yıkılacak binanın imar durumuna uygun olmalı</li>
    <li><strong>Riskli yapı raporu:</strong> Gerekirse deprem uzmanından alınmalı</li>
    <li><strong>Kat maliklerinin onayı:</strong> Müşterek binada tüm maliklerden izin</li>
    <li><strong>Komşu onayları:</strong> Bitişik nizam binalarda komşu izni</li>
    <li><strong>DASK sigortası kontrolü:</strong> Zorunlu deprem sigortası kontrolü</li>
</ul>

<h3>Bildirimler</h3>
<ul>
    <li>Elektrik şirketine (elektrik kesimi için)</li>
    <li>Su idaresine (su kesimi için)</li>
    <li>Doğalgaz şirketine (gaz kesimi için)</li>
    <li>Telefon/internet sağlayıcısına</li>
    <li>Belediyeye (başlangıç ve bitiş tarihi)</li>
</ul>

<div class="feature-box">
    <h4><i class="fas fa-exclamation-triangle"></i> Önemli Uyarı</h4>
    <p>Yasal izin almadan yapılan yıkım işlemleri için ağır cezai yaptırımlar uygulanır. Ayrıca sigorta teminatınız geçersiz olur.</p>
</div>

<h2>2. Yıkım Öncesi Teknik Hazırlıklar</h2>

<h3>Bina Değerlendirmesi</h3>
<p>Yıkıma başlamadan önce yapılması gereken teknik incelemeler:</p>
<ul>
    <li><strong>Yapısal durum tespiti:</strong> Binanın statik durumu incelenmeli</li>
    <li><strong>Malzeme analizi:</strong> Betonarme, kâgir, ahşap vb. tespit edilmeli</li>
    <li><strong>Asbest kontrolü:</strong> Eski binalarda asbest olup olmadığı kontrol edilmeli</li>
    <li><strong>Komşu binalar:</strong> Bitişik binaların durumu incelenmeli</li>
    <li><strong>Zemin durumu:</strong> Alttaki zemin ve varsa bodrum katlar incelenmeli</li>
</ul>

<h3>Altyapı Bağlantılarının Kesilmesi</h3>
<p><strong>Kritik Önem!</strong> Tüm altyapı bağlantıları profesyonelce kesilmelidir:</p>
<ul>
    <li><i class="fas fa-bolt text-warning"></i> <strong>Elektrik:</strong> Ana şalter kapatılmalı, sayaç sökülmeli</li>
    <li><i class="fas fa-tint text-primary"></i> <strong>Su:</strong> Ana vana kapatılmalı, sayaç sökülmeli</li>
    <li><i class="fas fa-fire text-danger"></i> <strong>Doğalgaz:</strong> MUTLAKA yetkili firma tarafından kapatılmalı</li>
    <li><i class="fas fa-wifi text-info"></i> <strong>Telefon/İnternet:</strong> Hat kesilmeli</li>
    <li><i class="fas fa-toilet"></i> <strong>Kanalizasyon:</strong> Bağlantı kapatılmalı</li>
</ul>

<h2>3. Güvenlik Bölgesi Oluşturma</h2>

<h3>Çevre Güvenliği</h3>
<p>Yıkım alanı etrafında alınması gereken önlemler:</p>
<ul>
    <li><strong>Güvenli mesafe:</strong> Binanın yüksekliğinin 1.5 katı kadar alan çevrelenmeli</li>
    <li><strong>Güvenlik bariyeri:</strong> En az 2 metre yüksekliğinde sağlam çit</li>
    <li><strong>Uyarı levhaları:</strong> "Dikkat! Yıkım Çalışması Yapılıyor" levhaları</li>
    <li><strong>Gece aydınlatması:</strong> Çalışma saatleri dışında da alan aydınlatılmalı</li>
    <li><strong>Güvenlik görevlisi:</strong> 7/24 güvenlik sağlanmalı</li>
    <li><strong>Yol kapatma:</strong> Gerekirse sokak trafiğe kapatılmalı</li>
</ul>

<h3>Komşu Binaların Korunması</h3>
<ul>
    <li>Yıkım öncesi bitişik binaların fotoğrafları çekilmeli</li>
    <li>Varolan çatlaklar tutanakla tespit edilmeli</li>
    <li>Koruyucu brandalar ve levhalar yerleştirilmeli</li>
    <li>Pencereler, kapılar koruma altına alınmalı</li>
    <li>Yıkım sırasında titreşim ölçümü yapılmalı</li>
</ul>

<h2>4. İş Güvenliği Ekipmanları</h2>

<h3>Kişisel Koruyucu Donanımlar (KKD)</h3>
<p>Yıkım işinde çalışan herkes mutlaka kullanmalıdır:</p>
<ul>
    <li><i class="fas fa-hard-hat"></i> <strong>Baret:</strong> Üstten düşen parçalara karşı</li>
    <li><i class="fas fa-glasses"></i> <strong>Koruyucu gözlük:</strong> Toz ve parçacıklara karşı</li>
    <li><i class="fas fa-head-side-mask"></i> <strong>Toz maskesi:</strong> Solunum sağlığı için (N95 veya üzeri)</li>
    <li><i class="fas fa-vest"></i> <strong>Reflektörlü yelek:</strong> Görünürlük için</li>
    <li><i class="fas fa-shoe-prints"></i> <strong>Çelik burunlu iş ayakkabısı:</strong> Ayak koruması</li>
    <li><i class="fas fa-hand-paper"></i> <strong>İş eldiveni:</strong> El güvenliği</li>
    <li><i class="fas fa-volume-mute"></i> <strong>Kulak koruyucu:</strong> Gürültüye karşı</li>
</ul>

<h3>İş Makinesi Güvenliği</h3>
<ul>
    <li>Operatörler sertifikalı ve deneyimli olmalı</li>
    <li>Makineler yıllık bakımdan geçmiş olmalı</li>
    <li>İş makinelerinin sigortalı olması zorunlu</li>
    <li>Geri görüş kamerası ve alarm sistemi olmalı</li>
    <li>Yangın söndürücü bulundurulmalı</li>
</ul>

<h2>5. Yıkım Yöntemleri ve Güvenlik</h2>

<h3>Mekanik Yıkım (Ekskavatör ile)</h3>
<p><strong>Avantajları:</strong> Kontrollü, hızlı, güvenli</p>
<p><strong>Güvenlik önlemleri:</strong></p>
<ul>
    <li>Yukarıdan aşağıya doğru yıkım yapılmalı</li>
    <li>Ekskavatörün altında çalışma yapılmamalı</li>
    <li>Asılı kalan parçalar hemen temizlenmeli</li>
    <li>Çalışma alanına yetkisiz girişler engellenmeli</li>
</ul>

<h3>Manuel Yıkım</h3>
<p><strong>Ne zaman kullanılır:</strong> Dar alanlarda, özel durumlarda</p>
<p><strong>Güvenlik önlemleri:</strong></p>
<ul>
    <li>Ekip sürekli iletişim halinde olmalı</li>
    <li>Yıkım sırası dikkatli planlanmalı</li>
    <li>Tehlikeli bölümlerde çalışma yapılmamalı</li>
    <li>İskele ve güvenlik halatları kullanılmalı</li>
</ul>

<h2>6. Moloz Yönetimi ve Çevre Sağlığı</h2>

<h3>Toz Kontrolü</h3>
<ul>
    <li>Yıkım sırasında su püskürtme yapılmalı</li>
    <li>Rüzgarlı havalarda önlem artırılmalı</li>
    <li>Moloz yükleme sırasında toz önlemi alınmalı</li>
    <li>Kamyonlar örtülü gitmeli</li>
</ul>

<h3>Moloz Taşıma</h3>
<ul>
    <li>Kamyonlar aşırı yüklenmemeli</li>
    <li>Molozlar mutlaka örtülmeli</li>
    <li>Belediye lisanslı moloz sahalarına götürülmeli</li>
    <li>Çevreye dökülme yapılmamalı</li>
    <li>Yol üzerine dökülen molozlar temizlenmeli</li>
</ul>

<h2>7. Acil Durum Planı</h2>
<p>Her yıkım sahasında bulunması gerekenler:</p>
<ul>
    <li><strong>İlk yardım çantası:</strong> Eksiksiz ve güncel</li>
    <li><strong>İlk yardım eğitimli personel:</strong> En az 2 kişi</li>
    <li><strong>Yangın söndürme tüpleri:</strong> Yeterli sayıda</li>
    <li><strong>Acil durum telefon numaraları:</strong> Görünür yerde asılı</li>
    <li><strong>Ambulans erişimi:</strong> Acil durumda ambulansın girebileceği açık yol</li>
    <li><strong>Toplanma noktası:</strong> Belirlenmeli ve işaretlenmeli</li>
</ul>

<h2>8. Hava Koşulları</h2>
<p>Yıkım işi yapılmaması gereken durumlar:</p>
<ul>
    <li><i class="fas fa-wind"></i> Şiddetli rüzgar (40 km/saat üzeri)</li>
    <li><i class="fas fa-cloud-rain"></i> Yağmurlu hava (zemin kaygan olur)</li>
    <li><i class="fas fa-snowflake"></i> Kar ve buz (iş güvenliği riski)</li>
    <li><i class="fas fa-smog"></i> Sis (görüş mesafesi kısıtlı)</li>
    <li><i class="fas fa-bolt"></i> Fırtına ve yıldırım (elektrik riski)</li>
</ul>

<div class="feature-box mt-4" style="background: linear-gradient(135deg, var(--primary-blue), var(--light-blue)); color: white;">
    <h4><i class="fas fa-shield-alt"></i> Profesyonel Yıkım Ekibi Neden Önemli?</h4>
    <p>Bina yıkımı, uzmanlık ve deneyim gerektiren bir iştir. Kayseri Emir Hafriyat olarak:</p>
    <ul style="margin-bottom: 0;">
        <li>✓ 25 yıllık deneyimimizle binlerce bina yıkımı gerçekleştirdik</li>
        <li>✓ Tüm iş güvenliği önlemlerini eksiksiz uyguluyoruz</li>
        <li>✓ Sigortalı ve sertifikalı ekiple çalışıyoruz</li>
        <li>✓ Modern ve bakımlı ekipman kullanıyoruz</li>
        <li>✓ Moloz nakli ve saha temizliği dahil hizmet veriyoruz</li>
        <li>✓ Komşu binalara zarar vermeden güvenli yıkım yapıyoruz</li>
    </ul>
</div>

<h2>9. Yıkım Sonrası</h2>
<p>Yıkım işlemi bittikten sonra yapılması gerekenler:</p>
<ul>
    <li>Saha tamamen temizlenmeli</li>
    <li>Tehlikeli çukurlar kapatılmalı</li>
    <li>Alan çit ile çevrilmeli</li>
    <li>Belediyeye yıkım bitimi bildirilmeli</li>
    <li>Komşu binalar son kez kontrol edilmeli</li>
    <li>Varsa oluşan hasarlar tutanakla tespit edilmeli</li>
</ul>

<h2>Sonuç</h2>
<p>Bina yıkımı, ciddi planlama, dikkat ve uzmanlık gerektiren bir iştir. Güvenlik önlemlerinin eksiksiz alınması:</p>
<ul>
    <li>Can ve mal kayıplarını önler</li>
    <li>Yasal sorunları engeller</li>
    <li>Çevre sağlığını korur</li>
    <li>İşin kaliteli ve hızlı tamamlanmasını sağlar</li>
</ul>
<p><strong>Unutmayın:</strong> Yıkım işini mutlaka profesyonel bir firmaya yaptırın!</p>

<div class="price-box mt-5">
    <h3><i class="fas fa-phone"></i> Güvenli Bina Yıkımı İçin Bizi Arayın</h3>
    <p>25 yıllık tecrübemiz ve profesyonel ekibimizle güvenli yıkım garantisi veriyoruz.</p>
    <a href="tel:05317023538" class="btn btn-light btn-lg me-2"><i class="fas fa-phone"></i> 0531 702 35 38</a>
    <a href="https://wa.me/905317023538" class="btn btn-success btn-lg"><i class="fab fa-whatsapp"></i> WhatsApp</a>
</div>',
  `excerpt` = 'Bina yıkımı, inşaat sektörünün en riskli işlerinden biridir. Yanlış yapılan yıkım işlemleri can kaybına ve yaralanmalara yol açabilir. Güvenli bina yıkımı için alınması gereken tüm önlemler.',
  `meta_title` = 'Bina Yıkımında Güvenlik Önlemleri - Kayseri Emir Hafriyat',
  `meta_description` = 'Bina yıkımında güvenlik önlemleri. Riskli bina tespiti, yıkım öncesi hazırlıklar, ekipman güvenliği, yasal prosedürler ve can güvenliği için detaylı rehber.',
  `meta_keywords` = 'bina yıkımı, yıkım güvenliği, riskli bina, yıkım izni, iş güvenliği, kayseri bina yıkımı'
WHERE `slug` = 'bina-yikim-guvenlik';


-- 4. Hafriyat Nedir ve Ne Zaman Gereklidir?
UPDATE `blog` SET
  `content` = '<img src="assets/img/hizmetler/ekskavator.jpg" alt="Hafriyat Nedir" class="img-fluid rounded mb-4">

<p class="lead">Hafriyat, inşaat sektörünün temel taşlarından biridir ve neredeyse her yapı projesinin vazgeçilmez ilk adımıdır. Peki hafriyat tam olarak nedir, ne zaman gereklidir ve profesyonel hafriyat hizmeti almanın önemi nedir? Bu yazımızda hafriyat işlerinin tüm detaylarını ele alacağız.</p>

<h2>Hafriyat Nedir?</h2>
<p><strong>Hafriyat</strong>, en basit tanımıyla zeminin kazılması ve kazılan toprağın taşınması işlemidir. Ancak hafriyat sadece toprak kazmaktan ibaret değildir; profesyonel ekipman, deneyim ve planlama gerektiren kapsamlı bir süreçtir.</p>

<p>Hafriyat işlemleri şunları kapsar:</p>
<ul>
    <li>Zemin kazısı (toprak, kaya, moloz)</li>
    <li>Kazılan malzemenin taşınması</li>
    <li>Zeminin düzenlenmesi ve dolgu</li>
    <li>Moloz ve atıkların bertaraf edilmesi</li>
    <li>Temel hazırlığı işlemleri</li>
</ul>

<h2>Hafriyat Ne Zaman Gereklidir?</h2>

<h3>1. Temel Kazısı</h3>
<p>Her yapı projesi bir temel ile başlar. İster ev, ister fabrika, ister köprü inşa edin, sağlam bir temel kazısı şarttır. Temel kazısı için hafriyat:</p>
<ul>
    <li><strong>Ev temel kazısı:</strong> 80-150 cm derinlik</li>
    <li><strong>Apartman temeli:</strong> 2-3 metre derinlik</li>
    <li><strong>Fabrika/AVM:</strong> 4-6 metre ve üzeri</li>
</ul>

<h3>2. Bina Yıkımı Sonrası</h3>
<p>Eski bir binayı yıktıktan sonra, molozların temizlenmesi ve zeminin yeni inşaat için hazırlanması gerekir. Bina yıkımı hafriyatı:</p>
<ul>
    <li>Moloz kaldırma</li>
    <li>Eski temel sökümü</li>
    <li>Zemin temizliği</li>
    <li>Dolgu işleri</li>
</ul>

<h3>3. Alt Yapı Çalışmaları</h3>
<p>Alt yapı işleri için kazı çalışmaları hayati öneme sahiptir:</p>
<ul>
    <li>Su ve kanalizasyon hatları</li>
    <li>Elektrik alt yapısı</li>
    <li>Doğalgaz hatları</li>
    <li>Fiber optik kablolar</li>
    <li>Yağmur suyu drenajı</li>
</ul>

<h3>4. Yol ve Peyzaj Çalışmaları</h3>
<ul>
    <li>Yol yapımı ve genişletme</li>
    <li>Bahçe düzenleme</li>
    <li>Havuz kazısı</li>
    <li>Gölet ve su kanalı</li>
    <li>Spor sahası hazırlığı</li>
</ul>

<h3>5. Arazi Düzenleme</h3>
<ul>
    <li>Arazi tesviyesi (düzleştirme)</li>
    <li>Eğimli arazi düzeltme</li>
    <li>Tarım arazisi düzenleme</li>
    <li>İstinat duvarı temeli</li>
</ul>

<h2>Hafriyat Türleri</h2>

<h3>Toprak Hafriyatı</h3>
<p>En yaygın hafriyat türüdür. Yumuşak ve orta sert zeminlerde ekskavatör veya beko loder ile yapılır.</p>

<h3>Kaya Hafriyatı</h3>
<p>Kayalık zeminlerde özel ekipman ve bazen patlayıcı kullanımı gerekir. En zor ve maliyetli hafriyat türüdür.</p>

<h3>Moloz Hafriyatı</h3>
<p>Yıkım sonrası beton, tuğla, demir gibi malzemelerin kaldırılmasıdır. Kamyon kiralama ile moloz taşınır.</p>

<h3>Derin Kazı</h3>
<p>4 metre ve üzeri kazılarda kullanılır. Bodrum kat, metro, tünel projeleri için gereklidir.</p>

<h2>Profesyonel Hafriyat Hizmeti Neden Önemlidir?</h2>

<h3>1. İş Güvenliği</h3>
<p>Hafriyat işleri ciddi riskler taşır:</p>
<ul>
    <li>Toprak kayması</li>
    <li>Alt yapı hasarı (gaz, elektrik, su)</li>
    <li>Komşu binalara zarar</li>
    <li>İş makinesi kazaları</li>
</ul>
<p>Profesyonel firmalar bu riskleri minimize eder.</p>

<h3>2. Doğru Ekipman</h3>
<p>Her proje farklı ekipman gerektirir:</p>
<ul>
    <li><strong>Küçük projeler:</strong> 20 ton ekskavatör</li>
    <li><strong>Orta projeler:</strong> 30 ton ekskavatör + beko loder</li>
    <li><strong>Büyük projeler:</strong> 40 ton ekskavatör + kamyonlar + manitou</li>
</ul>

<h3>3. Hız ve Verimlilik</h3>
<p>Deneyimli ekip ve doğru ekipman ile:</p>
<ul>
    <li>İş süresi kısalır</li>
    <li>Maliyet düşer</li>
    <li>Kalite artar</li>
    <li>Sorunlar önceden görülür</li>
</ul>

<h3>4. Yasal Uyum</h3>
<p>Profesyonel hafriyat firmaları:</p>
<ul>
    <li>Gerekli izinleri alır</li>
    <li>Moloz nakil belgesi sağlar</li>
    <li>Çevre mevzuatına uyar</li>
    <li>Sigortalı çalışır</li>
</ul>

<h2>Hafriyat Maliyetini Etkileyen Faktörler</h2>

<ol>
    <li><strong>Kazı derinliği:</strong> Derin kazılar daha pahalıdır</li>
    <li><strong>Zemin cinsi:</strong> Kaya > Kil > Kum > Toprak</li>
    <li><strong>Proje alanı:</strong> m³ bazında hesaplanır</li>
    <li><strong>Erişim kolaylığı:</strong> Dar sokak = daha pahalı</li>
    <li><strong>Moloz miktarı:</strong> Taşıma mesafesi önemli</li>
    <li><strong>Ekipman ihtiyacı:</strong> Birden fazla makine gerekebilir</li>
    <li><strong>Süre:</strong> Günlük vs. aylık kiralama</li>
</ol>

<h2>Hafriyat Öncesi Dikkat Edilmesi Gerekenler</h2>

<div class="feature-box">
    <h4><i class="fas fa-exclamation-triangle"></i> ÖNEMLİ KONTROLLER</h4>
    <ul>
        <li>✓ Zemin etüdü yaptırın</li>
        <li>✓ Alt yapı hatları tespit edin (su, gaz, elektrik)</li>
        <li>✓ Gerekli izinleri alın</li>
        <li>✓ Komşu bina temellerini kontrol edin</li>
        <li>✓ Moloz dökülecek yeri belirleyin</li>
        <li>✓ Profesyonel firma seçin</li>
        <li>✓ Çalışma planı yapın</li>
        <li>✓ Bütçe oluşturun</li>
    </ul>
</div>

<h2>Kayseri Emir Hafriyat - 25 Yıllık Tecrübe</h2>
<p>Kayseri ve çevresinde 25 yıldır profesyonel hafriyat hizmetleri sunuyoruz. Modern iş makinelerimiz ve deneyimli ekibimizle her ölçekte projeye hizmet veriyoruz.</p>

<p><strong>Hizmetlerimiz:</strong></p>
<ul>
    <li>Temel kazısı (ev, apartman, fabrika)</li>
    <li>Bina yıkımı ve moloz kaldırma</li>
    <li>Alt yapı kazıları</li>
    <li>Arazi tesviyesi</li>
    <li>Ekskavatör, beko loder, kamyon kiralama</li>
    <li>Taş duvar işleri</li>
</ul>

<div class="price-box mt-5">
    <h3><i class="fas fa-phone"></i> Hafriyat İşleriniz İçin Bizi Arayın</h3>
    <p>Ücretsiz keşif ve fiyat teklifi için hemen iletişime geçin.</p>
    <a href="tel:05317023538" class="btn btn-light btn-lg me-2"><i class="fas fa-phone"></i> 0531 702 35 38</a>
    <a href="https://wa.me/905317023538" class="btn btn-success btn-lg"><i class="fab fa-whatsapp"></i> WhatsApp</a>
</div>',
  `excerpt` = 'Hafriyat, inşaat sektörünün temel taşlarından biridir ve neredeyse her yapı projesinin vazgeçilmez ilk adımıdır. Hafriyat nedir, ne zaman gereklidir ve profesyonel hafriyat hizmeti almanın önemi.',
  `meta_title` = 'Hafriyat Nedir ve Ne Zaman Gereklidir? - Kayseri Emir Hafriyat',
  `meta_description` = 'Hafriyat işleri hakkında kapsamlı bilgi. Hafriyat nedir, ne zaman gereklidir, türleri nelerdir? İnşaat projelerinde hafriyatın önemi ve profesyonel hizmet almanın faydaları.',
  `meta_keywords` = 'hafriyat, hafriyat nedir, hafriyat işleri, kazı işleri, kayseri hafriyat, hafriyat firması, toprak kazısı'
WHERE `slug` = 'hafriyat-nedir-ne-zaman-gerekli';


-- ============================================================
-- GÜNCELLEME TAMAMLANDI
-- ============================================================
-- Bu SQL dosyasını çalıştırdıktan sonra blog içerikleri tam olarak güncellenmiş olacaktır.
-- Tüm HTML içerik korunmuş, .html referansları kaldırılmış ve SQL için düzgün şekilde escape edilmiştir.

-- ============================================================
COMMIT;
-- Veritabanı kurulumu tamamlandı!
