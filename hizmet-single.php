<?php
require_once 'config.php';
$db = Database::getInstance();

$slug = $_GET['slug'] ?? '';
$service = $db->fetchOne("SELECT * FROM services WHERE slug = ? AND status = 1", [$slug]);

if (!$service) {
    header('Location: ' . siteUrl('hizmetler.php'));
    exit;
}

$pageTitle = $service['title'];
$pageMetaTitle = $service['meta_title'] ?: $service['title'];
$pageMetaDesc = $service['meta_description'] ?: $service['short_description'];
$pageMetaKeywords = $service['meta_keywords'];
$pageUrl = siteUrl('hizmet/' . $service['slug']);

$features = $service['features'] ? explode(',', $service['features']) : [];
include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item"><a href="<?= siteUrl('hizmetler') ?>">Hizmetler</a></li>
                <li class="breadcrumb-item active"><?= clean($service['title']) ?></li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold"><?= clean($service['title']) ?></h1>
        <p class="lead"><?= clean($service['short_description']) ?></p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php if($service['image']): ?>
                    <img src="<?= asset($service['image']) ?>" alt="<?= clean($service['title']) ?>" class="img-fluid mb-4">
                <?php endif; ?>

                <div class="service-content">
                    <?= $service['description'] ?>
                </div>

                <?php if(!empty($features)): ?>
                    <div class="service-features mt-4">
                        <h3><i class="fas fa-check-circle"></i> Özellikler</h3>
                        <ul class="feature-list">
                            <?php foreach($features as $feature): ?>
                                <li><i class="fas fa-check text-primary"></i> <?= clean(trim($feature)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="service-sidebar">
                    <div class="contact-box">
                        <h4><i class="fas fa-phone-alt"></i> Hemen Teklif Alın</h4>
                        <p>Bu hizmet hakkında detaylı bilgi ve fiyat teklifi için bizi arayın.</p>
                        <a href="tel:<?= preg_replace('/[^0-9]/', '', getMeta('company_phone')) ?>" class="btn btn-warning w-100 mb-2">
                            <i class="fas fa-phone"></i> <?= getMeta('company_phone') ?>
                        </a>
                        <a href="<?= siteUrl('iletisim') ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-envelope"></i> İletişim Formu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
