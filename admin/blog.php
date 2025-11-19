<?php
$pageTitle = 'Blog Yönetimi';
include 'includes/header.php';

$blogs = $db->fetchAll("SELECT * FROM blog ORDER BY created_at DESC");
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-blog"></i> Blog Yazıları</span>
        <a href="blog_add.php" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Yeni Yazı Ekle
        </a>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Başlık</th>
                    <th>Kategori</th>
                    <th>Yazar</th>
                    <th>Görüntülenme</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td><?= $blog['id'] ?></td>
                        <td><?= clean($blog['title']) ?></td>
                        <td><span class="badge bg-info"><?= clean($blog['category']) ?></span></td>
                        <td><?= clean($blog['author']) ?></td>
                        <td><?= $blog['views'] ?></td>
                        <td>
                            <?php if ($blog['status']): ?>
                                <span class="badge badge-active">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-inactive">Pasif</span>
                            <?php endif; ?>
                        </td>
                        <td><?= formatDate($blog['created_at'], 'd.m.Y') ?></td>
                        <td class="table-actions">
                            <a href="blog_edit.php?id=<?= $blog['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="blog_delete.php?id=<?= $blog['id'] ?>" class="btn btn-sm btn-danger btn-delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
