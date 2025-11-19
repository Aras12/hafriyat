<?php
$pageTitle = 'Galeri';
$page = $db->fetchOne("SELECT * FROM pages WHERE page_key = 'galeri'", []);
$pageMetaTitle = $page['meta_title'] ?? 'Galeri | Emir Hafriyat';
$pageMetaDesc = $page['meta_description'] ?? '';
$pageMetaKeywords = $page['meta_keywords'] ?? '';
$gallery = $db->fetchAll("SELECT * FROM gallery WHERE status = 1 ORDER BY sort_order ASC");
include 'includes/header.php';
?>
<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item active">Galeri</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold">Galeri</h1>
        <p class="lead">Projelerimizden görüntüler</p>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach($gallery as $item): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="gallery-item">
                        <img src="<?= asset($item['image']) ?>" alt="<?= clean($item['title']) ?>" class="img-fluid">
                        <div class="gallery-overlay">
                            <h5><?= clean($item['title']) ?></h5>
                            <?php if($item['category']): ?><span class="badge bg-warning"><?= clean($item['category']) ?></span><?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
