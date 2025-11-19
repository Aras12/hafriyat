<?php
require_once 'config.php';
$db = Database::getInstance();

$pageTitle = 'Hizmetlerimiz';
$page = $db->fetchOne("SELECT * FROM pages WHERE page_key = 'hizmetler'", []);
$pageMetaTitle = $page['meta_title'] ?? 'Hizmetlerimiz | Emir Hafriyat';
$pageMetaDesc = $page['meta_description'] ?? '';
$pageMetaKeywords = $page['meta_keywords'] ?? '';

$services = $db->fetchAll("SELECT * FROM services WHERE status = 1 ORDER BY sort_order ASC");
include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item active">Hizmetler</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold">Hizmetlerimiz</h1>
        <p class="lead">Profesyonel hafriyat ve iş makinesi kiralama hizmetleri</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach($services as $service): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <?php if($service['image']): ?>
                            <img src="<?= asset($service['image']) ?>" alt="<?= clean($service['title']) ?>">
                        <?php endif; ?>
                        <div class="service-card-body">
                            <i class="<?= $service['icon'] ?> service-icon"></i>
                            <h5><?= clean($service['title']) ?></h5>
                            <p><?= clean($service['short_description']) ?></p>
                            <a href="<?= siteUrl('hizmet/' . $service['slug']) ?>" class="btn btn-outline-primary btn-sm">Detaylı Bilgi</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
