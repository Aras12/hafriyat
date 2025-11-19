<?php
$pageTitle = 'Gelen Mesajlar';
include 'includes/header.php';

// Mesajı okundu olarak işaretle
if (isset($_GET['read'])) {
    $id = (int)$_GET['read'];
    $db->execute("UPDATE contact_messages SET is_read = 1 WHERE id = ?", [$id]);
    header('Location: messages.php');
    exit;
}

// Mesaj sil
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $db->execute("DELETE FROM contact_messages WHERE id = ?", [$id]);
    setFlash('success', 'Mesaj silindi!');
    header('Location: messages.php');
    exit;
}

$messages = $db->fetchAll("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-envelope"></i> Gelen Mesajlar
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>Durum</th>
                    <th>İsim</th>
                    <th>E-posta</th>
                    <th>Telefon</th>
                    <th>Konu</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr class="<?= !$msg['is_read'] ? 'table-warning' : '' ?>">
                        <td>
                            <?php if (!$msg['is_read']): ?>
                                <span class="badge bg-danger">Yeni</span>
                            <?php else: ?>
                                <span class="badge bg-success">Okundu</span>
                            <?php endif; ?>
                        </td>
                        <td><?= clean($msg['name']) ?></td>
                        <td><?= clean($msg['email']) ?></td>
                        <td><?= clean($msg['phone']) ?></td>
                        <td><?= clean($msg['subject']) ?></td>
                        <td><?= formatDate($msg['created_at'], 'd.m.Y H:i') ?></td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#messageModal<?= $msg['id'] ?>">
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php if (!$msg['is_read']): ?>
                                <a href="?read=<?= $msg['id'] ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-check"></i>
                                </a>
                            <?php endif; ?>
                            <a href="?delete=<?= $msg['id'] ?>" class="btn btn-sm btn-danger btn-delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="messageModal<?= $msg['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Mesaj Detayı</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>İsim:</strong> <?= clean($msg['name']) ?></p>
                                    <p><strong>E-posta:</strong> <?= clean($msg['email']) ?></p>
                                    <p><strong>Telefon:</strong> <?= clean($msg['phone']) ?></p>
                                    <p><strong>Konu:</strong> <?= clean($msg['subject']) ?></p>
                                    <p><strong>IP:</strong> <?= $msg['ip_address'] ?></p>
                                    <p><strong>Tarih:</strong> <?= formatDate($msg['created_at'], 'd.m.Y H:i') ?></p>
                                    <hr>
                                    <p><strong>Mesaj:</strong></p>
                                    <p><?= nl2br(clean($msg['message'])) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <a href="mailto:<?= $msg['email'] ?>" class="btn btn-primary">
                                        <i class="fas fa-reply"></i> E-posta Gönder
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
