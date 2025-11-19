<?php
$pageTitle = 'SSS Yönetimi';
include 'includes/header.php';
$faqs = $db->fetchAll("SELECT * FROM faqs ORDER BY sort_order ASC");
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-question-circle"></i> SSS Listesi</span>
        <a href="faq_add.php" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Yeni SSS</a>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead><tr><th>Sıra</th><th>Soru</th><th>Cevap</th><th>Durum</th><th>İşlemler</th></tr></thead>
            <tbody>
                <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><?= $faq['sort_order'] ?></td>
                        <td><?= clean($faq['question']) ?></td>
                        <td><?= excerpt(clean($faq['answer']), 80) ?></td>
                        <td><?= $faq['status'] ? '<span class="badge badge-active">Aktif</span>' : '<span class="badge badge-inactive">Pasif</span>' ?></td>
                        <td class="table-actions">
                            <a href="faq_edit.php?id=<?= $faq['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <a href="faq_delete.php?id=<?= $faq['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
