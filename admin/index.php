<?php
$pageTitle = 'Dashboard';
include 'includes/header.php';

// İstatistikler
$stats = [
    'services' => $db->fetchOne("SELECT COUNT(*) as count FROM services WHERE status = 1")['count'],
    'blog' => $db->fetchOne("SELECT COUNT(*) as count FROM blog WHERE status = 1")['count'],
    'gallery' => $db->fetchOne("SELECT COUNT(*) as count FROM gallery WHERE status = 1")['count'],
    'projects' => $db->fetchOne("SELECT COUNT(*) as count FROM projects WHERE status = 1")['count'],
    'messages' => $db->fetchOne("SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0")['count'],
    'sliders' => $db->fetchOne("SELECT COUNT(*) as count FROM sliders WHERE status = 1")['count'],
];

// Son mesajlar
$recentMessages = $db->fetchAll("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");

// Son blog yazıları
$recentBlogs = $db->fetchAll("SELECT * FROM blog ORDER BY created_at DESC LIMIT 5");
?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?= $stats['services'] ?></h3>
                    <p class="text-muted mb-0">Aktif Hizmet</p>
                </div>
                <div class="text-primary">
                    <i class="fas fa-cogs fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?= $stats['blog'] ?></h3>
                    <p class="text-muted mb-0">Blog Yazısı</p>
                </div>
                <div class="text-success">
                    <i class="fas fa-blog fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?= $stats['messages'] ?></h3>
                    <p class="text-muted mb-0">Okunmamış Mesaj</p>
                </div>
                <div class="text-danger">
                    <i class="fas fa-envelope fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?= $stats['sliders'] ?></h3>
                    <p class="text-muted mb-0">Aktif Slider</p>
                </div>
                <div class="text-warning">
                    <i class="fas fa-images fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?= $stats['gallery'] ?></h3>
                    <p class="text-muted mb-0">Galeri Görseli</p>
                </div>
                <div class="text-info">
                    <i class="fas fa-image fa-3x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0"><?= $stats['projects'] ?></h3>
                    <p class="text-muted mb-0">Tamamlanan Proje</p>
                </div>
                <div class="text-secondary">
                    <i class="fas fa-project-diagram fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-envelope"></i> Son Gelen Mesajlar
            </div>
            <div class="card-body">
                <?php if (empty($recentMessages)): ?>
                    <p class="text-muted">Henüz mesaj yok.</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentMessages as $msg): ?>
                            <a href="messages.php" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?= clean($msg['name']) ?></h6>
                                        <small class="text-muted"><?= clean($msg['subject']) ?></small>
                                    </div>
                                    <small><?= formatDate($msg['created_at'], 'd.m.Y H:i') ?></small>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="fas fa-blog"></i> Son Blog Yazıları
            </div>
            <div class="card-body">
                <?php if (empty($recentBlogs)): ?>
                    <p class="text-muted">Henüz blog yazısı yok.</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentBlogs as $blog): ?>
                            <a href="blog_edit.php?id=<?= $blog['id'] ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?= clean($blog['title']) ?></h6>
                                        <small class="text-muted">
                                            <?= $blog['views'] ?> görüntülenme
                                        </small>
                                    </div>
                                    <small><?= formatDate($blog['created_at'], 'd.m.Y') ?></small>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
