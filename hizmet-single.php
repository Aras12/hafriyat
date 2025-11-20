<?php
require_once 'config.php';
$db = Database::getInstance();

$slug = $_GET['slug'] ?? '';
$service = $db->fetchOne("SELECT * FROM services WHERE slug = ? AND status = 1", [$slug]);

if (!$service) {
    header('Location: ' . siteUrl('hizmetler'));
    exit;
}

$pageTitle = $service['title'];
$pageMetaTitle = $service['meta_title'] ?: $service['title'];
$pageMetaDesc = $service['meta_description'] ?: $service['short_description'];
$pageMetaKeywords = $service['meta_keywords'];
$pageUrl = siteUrl('hizmet/' . $service['slug']);

$features = $service['features'] ? explode(',', $service['features']) : [];

// Tüm hizmetleri sidebar için çek
$allServices = $db->fetchAll("SELECT id, title, slug, icon FROM services WHERE status = 1 ORDER BY sort_order ASC");

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
                    <!-- Hizmetler Menüsü -->
                    <div class="sidebar-widget">
                        <h4><i class="fas fa-cogs"></i> Tüm Hizmetlerimiz</h4>
                        <ul class="sidebar-menu">
                            <?php foreach($allServices as $svc): ?>
                                <li>
                                    <a href="<?= siteUrl('hizmet/' . $svc['slug']) ?>" class="<?= $svc['id'] == $service['id'] ? 'active' : '' ?>">
                                        <i class="<?= $svc['icon'] ?>"></i> <?= clean($svc['title']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="<?= siteUrl('hizmetler') ?>" class="btn btn-outline-primary w-100 mt-3">
                            <i class="fas fa-th"></i> Tüm Hizmetler
                        </a>
                    </div>

                    <!-- İletişim Box -->
                    <div class="sidebar-widget">
                        <h4><i class="fas fa-phone-alt"></i> Hemen Teklif Alın</h4>
                        <p>Bu hizmet hakkında detaylı bilgi ve fiyat teklifi için bizi arayın.</p>
                        <a href="tel:<?= preg_replace('/[^0-9]/', '', getMeta('company_phone')) ?>" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-phone"></i> <?= getMeta('company_phone') ?>
                        </a>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', getMeta('company_phone', '905317023538')) ?>" target="_blank" class="btn w-100 mb-2" style="background: #25D366; color: white;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
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
