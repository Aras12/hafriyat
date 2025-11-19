<?php
$pageTitle = 'Yeni Yorum';
include 'includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = clean($_POST['client_name']);
    $client_company = clean($_POST['client_company']);
    $comment = clean($_POST['comment']);
    $rating = (int)$_POST['rating'];
    $sort_order = (int)$_POST['sort_order'];
    $status = isset($_POST['status']) ? 1 : 0;
    if ($db->execute("INSERT INTO testimonials (client_name, client_company, comment, rating, sort_order, status) VALUES (?, ?, ?, ?, ?, ?)",
        [$client_name, $client_company, $comment, $rating, $sort_order, $status])) {
        setFlash('success', 'Yorum eklendi!');
        header('Location: testimonials.php');
        exit;
    }
}
?>
<div class="card">
    <div class="card-header"><i class="fas fa-plus"></i> Yeni Yorum</div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3"><label>Müşteri Adı *</label><input type="text" name="client_name" class="form-control" required></div>
            <div class="mb-3"><label>Firma</label><input type="text" name="client_company" class="form-control"></div>
            <div class="mb-3"><label>Yorum *</label><textarea name="comment" class="form-control" rows="4" required></textarea></div>
            <div class="mb-3"><label>Puan</label><select name="rating" class="form-select"><option value="5">5 Yıldız</option><option value="4">4 Yıldız</option><option value="3">3 Yıldız</option><option value="2">2 Yıldız</option><option value="1">1 Yıldız</option></select></div>
            <div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="0"></div>
            <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" checked><label>Aktif</label></div></div>
            <hr>
            <div class="d-flex justify-content-between">
                <a href="testimonials.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
