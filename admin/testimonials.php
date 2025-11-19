<?php
$pageTitle = 'Yorum Yönetimi';
include 'includes/header.php';
$testimonials = $db->fetchAll("SELECT * FROM testimonials ORDER BY sort_order ASC");
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-comments"></i> Müşteri Yorumları</span>
        <a href="testimonial_add.php" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Yeni Yorum</a>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead><tr><th>Sıra</th><th>İsim</th><th>Firma</th><th>Puan</th><th>Durum</th><th>İşlemler</th></tr></thead>
            <tbody>
                <?php foreach ($testimonials as $t): ?>
                    <tr>
                        <td><?= $t['sort_order'] ?></td>
                        <td><?= clean($t['client_name']) ?></td>
                        <td><?= clean($t['client_company']) ?></td>
                        <td><?= str_repeat('⭐', $t['rating']) ?></td>
                        <td><?= $t['status'] ? '<span class="badge badge-active">Aktif</span>' : '<span class="badge badge-inactive">Pasif</span>' ?></td>
                        <td class="table-actions">
                            <a href="testimonial_edit.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <a href="testimonial_delete.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
