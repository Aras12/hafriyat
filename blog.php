<?php
$pageTitle = 'Blog';
$page = $db->fetchOne("SELECT * FROM pages WHERE page_key = 'blog'", []);
$pageMetaTitle = $page['meta_title'] ?? 'Blog | Emir Hafriyat';
$pageMetaDesc = $page['meta_description'] ?? '';
$pageMetaKeywords = $page['meta_keywords'] ?? '';

$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 9;
$offset = ($currentPage - 1) * $perPage;

$total = $db->fetchOne("SELECT COUNT(*) as count FROM blog WHERE status = 1")['count'];
$blogs = $db->fetchAll("SELECT * FROM blog WHERE status = 1 ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$pagination = paginate($total, $perPage, $currentPage);

include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item active">Blog</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold">Blog</h1>
        <p class="lead">Hafriyat ve inşaat sektöründen haberler</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach($blogs as $blog): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="blog-card">
                        <?php if($blog['featured_image']): ?>
                            <img src="<?= asset($blog['featured_image']) ?>" alt="<?= clean($blog['title']) ?>">
                        <?php endif; ?>
                        <div class="blog-card-body">
                            <span class="badge bg-warning text-dark mb-2"><?= clean($blog['category']) ?></span>
                            <h5><?= clean($blog['title']) ?></h5>
                            <p><?= excerpt(clean($blog['excerpt']), 120) ?></p>
                            <div class="blog-meta">
                                <small><i class="fas fa-user"></i> <?= clean($blog['author']) ?></small>
                                <small><i class="fas fa-calendar"></i> <?= formatDate($blog['created_at'], 'd.m.Y') ?></small>
                                <small><i class="fas fa-eye"></i> <?= $blog['views'] ?></small>
                            </div>
                            <a href="<?= siteUrl('blog/' . $blog['slug']) ?>" class="btn btn-outline-primary btn-sm mt-3">Devamını Oku</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if($pagination['total_pages'] > 1): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php if($pagination['has_prev']): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $currentPage-1 ?>">Önceki</a></li>
                    <?php endif; ?>
                    <?php for($i=1; $i<=$pagination['total_pages']; $i++): ?>
                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                    <?php if($pagination['has_next']): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $currentPage+1 ?>">Sonraki</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
