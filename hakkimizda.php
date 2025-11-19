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
<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item active">Hakkımızda</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold">Hakkımızda</h1>
        <p class="lead"><?= getMeta('company_experience', '25') ?> yıllık tecrübe</p>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <?= $page['content'] ?: '<p>Kayseri Emir Hafriyat olarak ' . getMeta('company_experience', '25') . ' yıldır sektörde hizmet vermekteyiz. Modern ekipmanlarımız ve deneyimli ekibimizle her türlü hafriyat ve iş makinesi kiralama ihtiyacınıza profesyonel çözümler sunuyoruz.</p>' ?>
            </div>
            <div class="col-lg-6">
                <img src="<?= asset('assets/img/logo.png') ?>" alt="Emir Hafriyat" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
