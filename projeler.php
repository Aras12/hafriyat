<?php
require_once 'config.php';
$db = Database::getInstance();

$pageTitle = 'Projeler';
$page = $db->fetchOne("SELECT * FROM pages WHERE page_key = 'projeler'", []);
$pageMetaTitle = $page['meta_title'] ?? 'Projeler | Emir Hafriyat';
$pageMetaDesc = $page['meta_description'] ?? '';
$pageMetaKeywords = $page['meta_keywords'] ?? '';
$projects = $db->fetchAll("SELECT * FROM projects WHERE status = 1 ORDER BY sort_order ASC");
include 'includes/header.php';
?>
<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item active">Projeler</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold">Projelerimiz</h1>
        <p class="lead">Tamamladığımız başarılı projeler</p>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach($projects as $project): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="project-card">
                        <img src="<?= asset($project['image']) ?>" alt="<?= clean($project['title']) ?>">
                        <div class="project-card-body">
                            <h5><?= clean($project['title']) ?></h5>
                            <?php if($project['description']): ?><p><?= excerpt(clean($project['description']), 100) ?></p><?php endif; ?>
                            <div class="project-info">
                                <?php if($project['location']): ?><small><i class="fas fa-map-marker-alt"></i> <?= clean($project['location']) ?></small><?php endif; ?>
                                <?php if($project['completion_date']): ?><small><i class="fas fa-calendar"></i> <?= formatDate($project['completion_date'], 'd.m.Y') ?></small><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
