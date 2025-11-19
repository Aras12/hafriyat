<?php
$pageTitle = 'Hizmet Yönetimi';
include 'includes/header.php';
$services = $db->fetchAll("SELECT s.*, st.tab_name FROM services s LEFT JOIN service_tabs st ON s.tab_category = st.tab_key ORDER BY s.sort_order ASC");
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-cogs"></i> Hizmetler</span>
        <a href="service_add.php" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Yeni Hizmet</a>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead><tr><th>Sıra</th><th>Başlık</th><th>Kategori</th><th>Durum</th><th>İşlemler</th></tr></thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?= $service['sort_order'] ?></td>
                        <td><?= clean($service['title']) ?></td>
                        <td><span class="badge bg-info"><?= clean($service['tab_name'] ?? 'Yok') ?></span></td>
                        <td><?= $service['status'] ? '<span class="badge badge-active">Aktif</span>' : '<span class="badge badge-inactive">Pasif</span>' ?></td>
                        <td class="table-actions">
                            <a href="service_edit.php?id=<?= $service['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <a href="service_delete.php?id=<?= $service['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
