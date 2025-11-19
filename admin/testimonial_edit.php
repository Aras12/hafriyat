<?php
$pageTitle = 'Yorum Düzenle';
include 'includes/header.php';
$id = (int)$_GET['id'];
$t = $db->fetchOne("SELECT * FROM testimonials WHERE id = ?", [$id]);
if (!$t) { setFlash('error', 'Yorum bulunamadı!'); header('Location: testimonials.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = clean($_POST['client_name']);
    $client_company = clean($_POST['client_company']);
    $comment = clean($_POST['comment']);
    $rating = (int)$_POST['rating'];
    $sort_order = (int)$_POST['sort_order'];
    $status = isset($_POST['status']) ? 1 : 0;
    if ($db->execute("UPDATE testimonials SET client_name=?, client_company=?, comment=?, rating=?, sort_order=?, status=? WHERE id=?",
        [$client_name, $client_company, $comment, $rating, $sort_order, $status, $id])) {
        setFlash('success', 'Yorum güncellendi!');
        header('Location: testimonials.php');
        exit;
    }
}
?>
<div class="card">
    <div class="card-header"><i class="fas fa-edit"></i> Yorum Düzenle</div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3"><label>Müşteri Adı *</label><input type="text" name="client_name" class="form-control" value="<?=clean($t['client_name'])?>" required></div>
            <div class="mb-3"><label>Firma</label><input type="text" name="client_company" class="form-control" value="<?=clean($t['client_company'])?>"></div>
            <div class="mb-3"><label>Yorum *</label><textarea name="comment" class="form-control" rows="4" required><?=clean($t['comment'])?></textarea></div>
            <div class="mb-3"><label>Puan</label><select name="rating" class="form-select"><?php for($i=5;$i>=1;$i--): ?><option value="<?=$i?>" <?=$t['rating']==$i?'selected':''?>><?=$i?> Yıldız</option><?php endfor; ?></select></div>
            <div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="<?=$t['sort_order']?>"></div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" <?=$t['status']?'checked':''?>><label>Aktif</label></div></div>
            <hr>
            <div class="d-flex justify-content-between">
                <a href="testimonials.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Güncelle</button>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
