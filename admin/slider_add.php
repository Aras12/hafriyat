<?php
$pageTitle = 'Yeni Slider Ekle';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean($_POST['title']);
    $description = clean($_POST['description']);
    $button_text = clean($_POST['button_text']);
    $button_link = clean($_POST['button_link']);
    $sort_order = (int)$_POST['sort_order'];
    $status = isset($_POST['status']) ? 1 : 0;

    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = uploadImage($_FILES['image'], 'slider');
        if (!$image) {
            setFlash('error', 'Resim yüklenirken hata oluştu!');
            header('Location: slider_add.php');
            exit;
        }
    } else {
        setFlash('error', 'Slider görseli zorunludur!');
        header('Location: slider_add.php');
        exit;
    }

    $sql = "INSERT INTO sliders (title, description, image, button_text, button_link, sort_order, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($db->execute($sql, [$title, $description, $image, $button_text, $button_link, $sort_order, $status])) {
        setFlash('success', 'Slider başarıyla eklendi!');
        header('Location: sliders.php');
        exit;
    } else {
        setFlash('error', 'Slider eklenirken hata oluştu!');
    }
}
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-plus"></i> Yeni Slider Ekle
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Başlık *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Buton Metni</label>
                                <input type="text" name="button_text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Buton Linki</label>
                                <input type="text" name="button_link" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Slider Görseli *</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Önerilen boyut: 1920x800px</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sıra</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                            <label class="form-check-label" for="status">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-between">
                <a href="sliders.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Geri
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
