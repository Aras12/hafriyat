<?php
require_once 'config.php';
$db = Database::getInstance();

$slug = $_GET['slug'] ?? '';
$blog = $db->fetchOne("SELECT * FROM blog WHERE slug = ? AND status = 1", [$slug]);

if (!$blog) {
    header('Location: ' . siteUrl('blog'));
    exit;
}

// Görüntülenme sayısını artır
$db->execute("UPDATE blog SET views = views + 1 WHERE id = ?", [$blog['id']]);

$pageTitle = $blog['title'];
$pageMetaTitle = $blog['meta_title'] ?: $blog['title'];
$pageMetaDesc = $blog['meta_description'] ?: excerpt($blog['excerpt'], 150);
$pageMetaKeywords = $blog['meta_keywords'];
$pageUrl = siteUrl('blog/' . $blog['slug']);

// Son yazılar
$recentPosts = $db->fetchAll("SELECT * FROM blog WHERE status = 1 AND id != ? ORDER BY created_at DESC LIMIT 5", [$blog['id']]);

include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item"><a href="<?= siteUrl('blog') ?>">Blog</a></li>
                <li class="breadcrumb-item active"><?= clean($blog['title']) ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="blog-single">
                    <?php if($blog['featured_image']): ?>
                        <img src="<?= asset($blog['featured_image']) ?>" alt="<?= clean($blog['title']) ?>" class="img-fluid mb-4">
                    <?php endif; ?>

                    <div class="blog-meta mb-3">
                        <span class="badge bg-warning text-dark"><?= clean($blog['category']) ?></span>
                        <small class="ms-3"><i class="fas fa-user"></i> <?= clean($blog['author']) ?></small>
                        <small class="ms-3"><i class="fas fa-calendar"></i> <?= formatDate($blog['created_at'], 'd F Y') ?></small>
                        <small class="ms-3"><i class="fas fa-eye"></i> <?= $blog['views'] ?> görüntülenme</small>
                    </div>

                    <h1 class="mb-4"><?= clean($blog['title']) ?></h1>

                    <div class="blog-content">
                        <?= $blog['content'] ?>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="sidebar">
                    <div class="sidebar-widget">
                        <h4><i class="fas fa-newspaper"></i> Son Yazılar</h4>
                        <ul class="list-unstyled">
                            <?php foreach($recentPosts as $post): ?>
                                <li class="mb-3">
                                    <a href="<?= siteUrl('blog/' . $post['slug']) ?>"><?= clean($post['title']) ?></a>
                                    <small class="d-block text-muted"><?= formatDate($post['created_at'], 'd.m.Y') ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="sidebar-widget">
                        <h4><i class="fas fa-phone"></i> İletişim</h4>
                        <p><strong>Telefon:</strong><br><?= clean(getMeta('company_phone')) ?></p>
                        <p><strong>E-posta:</strong><br><?= clean(getMeta('company_email')) ?></p>
                        <a href="<?= siteUrl('iletisim') ?>" class="btn btn-primary w-100">Bize Ulaşın</a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
