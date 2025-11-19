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

COMMIT;
