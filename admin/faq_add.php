<?php
$pageTitle = 'Yeni SSS';
include 'includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = clean($_POST['question']);
    $answer = clean($_POST['answer']);
    $sort_order = (int)$_POST['sort_order'];
    $status = isset($_POST['status']) ? 1 : 0;
    if ($db->execute("INSERT INTO faqs (question, answer, sort_order, status) VALUES (?, ?, ?, ?)", [$question, $answer, $sort_order, $status])) {
        setFlash('success', 'SSS eklendi!');
        header('Location: faqs.php');
        exit;
    }
}
?>
<div class="card">
    <div class="card-header"><i class="fas fa-plus"></i> Yeni SSS</div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3"><label>Soru *</label><input type="text" name="question" class="form-control" required></div>
            <div class="mb-3"><label>Cevap *</label><textarea name="answer" class="form-control" rows="4" required></textarea></div>
            <div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="0"></div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" checked><label>Aktif</label></div></div>
            <hr>
            <div class="d-flex justify-content-between">
                <a href="faqs.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
