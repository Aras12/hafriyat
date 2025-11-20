<?php
require_once 'config.php';
$db = Database::getInstance();

$pageTitle = 'Hakkımızda';
$page = $db->fetchOne("SELECT * FROM pages WHERE page_key = 'hakkimizda'", []);
$pageMetaTitle = $page['meta_title'] ?? 'Hakkımızda | Emir Hafriyat';
$pageMetaDesc = $page['meta_description'] ?? '';
$pageMetaKeywords = $page['meta_keywords'] ?? '';
include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item active">Hakkımızda</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold">Hakkımızda</h1>
        <p class="lead"><?= getMeta('company_experience', '25') ?> yıllık tecrübemizle yanınızdayız</p>
    </div>
</section>

<!-- About Content -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <div class="section-title text-start">
                    <h2>Kayseri'nin Hafriyat Lideri</h2>
                </div>
                <p class="lead"><?= clean(getMeta('site_title', 'Emir Hafriyat')) ?>, <?= getMeta('company_experience', '25') ?> yıllık tecrübesi ile Kayseri ve çevresinde hafriyat, kazı, yıkım ve iş makinesi kiralama sektörünün güvenilir ve öncü firmasıdır.</p>
                <p>Modern ekipmanlarımız, deneyimli operatör kadromuz ve müşteri memnuniyeti odaklı çalışma prensibimizle, küçük ölçekli ev tadilatlarından büyük altyapı projelerine kadar geniş bir yelpazede profesyonel hizmet sunuyoruz.</p>
                <p>Kalite, güvenilirlik ve zamanında teslimat ilkelerimizden asla ödün vermiyoruz. Her projede, müşterilerimizin ihtiyaçlarını en iyi şekilde anlayıp, beklentilerinin üzerinde sonuçlar elde etmek için çalışıyoruz.</p>
            </div>
            <div class="col-lg-6">
                <img src="<?= asset('assets/img/uploads/hafriyat-1.jpg') ?>" alt="Emir Hafriyat" class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- Mission & Vision Cards -->
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="mission-vision-card">
                    <i class="fas fa-bullseye"></i>
                    <h3>Misyonumuz</h3>
                    <p>Hafriyat ve iş makinesi kiralama sektöründe modern ekipman ve deneyimli kadromuzla en yüksek kalite standartlarında hizmet sunarak, müşterilerimizin projelerini güvenli, hızlı ve ekonomik bir şekilde tamamlamalarına katkı sağlamak. Çevre bilinci ve iş güvenliği önceliklerimizi koruyarak sektöre öncülük etmek.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mission-vision-card">
                    <i class="fas fa-eye"></i>
                    <h3>Vizyonumuz</h3>
                    <p>Kayseri ve çevresinde hafriyat sektörünün en güvenilir ve tercih edilen markası olmak. Sürekli yenilenen ekipman parkurumuz, eğitimli personelimiz ve yenilikçi yaklaşımlarımızla sektörde lider konumumuzu pekiştirerek, bölgenin altyapı ve inşaat projelerine en büyük katkıyı sağlayan firma olmak.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-box">
                    <i class="fas fa-award"></i>
                    <span class="stat-number counter" data-target="<?= getMeta('company_experience', '25') ?>">0</span>
                    <div class="stat-label">Yıllık Tecrübe</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <i class="fas fa-project-diagram"></i>
                    <span class="stat-number counter" data-target="1000">0</span>
                    <div class="stat-label">Tamamlanan Proje</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <i class="fas fa-smile"></i>
                    <span class="stat-number counter" data-target="500">0</span>
                    <div class="stat-label">Mutlu Müşteri</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>Neden Bizi Tercih Etmelisiniz?</h2>
            <p>Kayseri Emir Hafriyat'ı öne çıkaran özellikler</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-highlight">
                    <i class="fas fa-tools"></i>
                    <h4>Modern Ekipman</h4>
                    <p>Son model iş makineleri ve ekipmanlarla donanmış filomuzla her türlü projeye hazırız. Düzenli bakım ve kontroller ile ekipmanlarımızın her zaman en iyi performansta olmasını sağlıyoruz.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-highlight">
                    <i class="fas fa-user-tie"></i>
                    <h4>Deneyimli Kadro</h4>
                    <p>Sertifikalı ve deneyimli operatörlerimiz, alanında uzman teknik ekibimiz ile güvenli ve profesyonel hizmet sunuyoruz. Sürekli eğitimlerle kendimizi geliştiriyoruz.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-highlight">
                    <i class="fas fa-clock"></i>
                    <h4>Zamanında Teslimat</h4>
                    <p>Projelerinizin zamanında teslimi bizim için önceliklidir. Planlı çalışma ve etkili proje yönetimi ile taahhütlerimizi tam zamanında yerine getiriyoruz.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-highlight">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Güvenli İş Yeri</h4>
                    <p>İş güvenliği standartlarına tam uyum gösteriyoruz. Tüm çalışanlarımız düzenli iş güvenliği eğitimleri alıyor ve projelerimizde azami güvenlik önlemlerini alıyoruz.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-highlight">
                    <i class="fas fa-hand-holding-usd"></i>
                    <h4>Uygun Fiyat</h4>
                    <p>Kaliteden ödün vermeden rekabetçi fiyatlarımızla bütçenize uygun çözümler sunuyoruz. Fiyat-performans dengesinde sektörün en iyi seçeneğiyiz.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-highlight">
                    <i class="fas fa-headset"></i>
                    <h4>7/24 Destek</h4>
                    <p>Müşteri memnuniyeti odaklı çalışma anlayışımızla 7/24 ulaşılabilir durumdayız. Sorularınız, talepleriniz için her zaman yanınızdayız.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--dark-blue), #1e3a5f);">
    <div class="container text-center text-white">
        <h2 class="mb-4">Projeniz İçin Profesyonel Destek!</h2>
        <p class="lead mb-4">Hafriyat ve iş makinesi kiralama ihtiyaçlarınız için hemen bizimle iletişime geçin. Ücretsiz keşif ve fiyat teklifi için bizi arayın.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="tel:<?= preg_replace('/[^0-9]/', '', getMeta('company_phone', '05317023538')) ?>" class="btn btn-lg mb-2" style="background: var(--primary-yellow); color: var(--dark-blue); font-weight: bold;">
                <i class="fas fa-phone"></i> <?= getMeta('company_phone', '0531 702 35 38') ?>
            </a>
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', getMeta('company_phone', '905317023538')) ?>" target="_blank" class="btn btn-lg mb-2" style="background: #25D366; color: white; font-weight: bold;">
                <i class="fab fa-whatsapp"></i> WhatsApp ile İletişim
            </a>
            <a href="<?= siteUrl('iletisim.php') ?>" class="btn btn-outline-light btn-lg mb-2">
                <i class="fas fa-envelope"></i> İletişim Formu
            </a>
        </div>
    </div>
</section>

<script>
// Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');

    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                let current = 0;
                const increment = target / 50;
                const duration = 2000;
                const stepTime = duration / 50;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target + '+';
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, stepTime);

                observer.unobserve(counter);
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));
});
</script>

<?php include 'includes/footer.php'; ?>
