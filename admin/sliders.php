<?php
$pageTitle = 'Slider Yönetimi';
include 'includes/header.php';

$sliders = $db->fetchAll("SELECT * FROM sliders ORDER BY sort_order ASC");
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-images"></i> Slider Listesi</span>
        <a href="slider_add.php" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Yeni Slider Ekle
        </a>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>Görsel</th>
                    <th>Başlık</th>
                    <th>Açıklama</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sliders as $slider): ?>
                    <tr>
                        <td><?= $slider['sort_order'] ?></td>
                        <td>
                            <img src="../<?= $slider['image'] ?>" alt="" style="max-width:100px; height:auto;">
                        </td>
                        <td><?= clean($slider['title']) ?></td>
                        <td><?= excerpt(clean($slider['description']), 50) ?></td>
                        <td>
                            <?php if ($slider['status']): ?>
                                <span class="badge badge-active">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-inactive">Pasif</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-actions">
                            <a href="slider_edit.php?id=<?= $slider['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="slider_delete.php?id=<?= $slider['id'] ?>" class="btn btn-sm btn-danger btn-delete">
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
