<?php
$pageTitle = 'SSS Düzenle';
include 'includes/header.php';
$id = (int)$_GET['id'];
$faq = $db->fetchOne("SELECT * FROM faqs WHERE id = ?", [$id]);
if (!$faq) { setFlash('error', 'SSS bulunamadı!'); header('Location: faqs.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = clean($_POST['question']);
    $answer = clean($_POST['answer']);
    $sort_order = (int)$_POST['sort_order'];
    $status = isset($_POST['status']) ? 1 : 0;
    if ($db->execute("UPDATE faqs SET question=?, answer=?, sort_order=?, status=? WHERE id=?", [$question, $answer, $sort_order, $status, $id])) {
        setFlash('success', 'SSS güncellendi!');
        header('Location: faqs.php');
        exit;
    }
}
?>
<div class="card">
    <div class="card-header"><i class="fas fa-edit"></i> SSS Düzenle</div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3"><label>Soru *</label><input type="text" name="question" class="form-control" value="<?=clean($faq['question'])?>" required></div>
            <div class="mb-3"><label>Cevap *</label><textarea name="answer" class="form-control" rows="4" required><?=clean($faq['answer'])?></textarea></div>
            <div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="<?=$faq['sort_order']?>"></div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" <?=$faq['status']?'checked':''?>><label>Aktif</label></div></div>
            <hr>
            <div class="d-flex justify-content-between">
                <a href="faqs.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Güncelle</button>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
