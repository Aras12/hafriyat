<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();

// GET existing data BEFORE POST check
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $slider = $db->fetchOne("SELECT * FROM sliders WHERE id = ?", [$id]);
    if (!$slider) {
        setFlash('error', 'Slider bulunamadı!');
        header('Location: sliders.php');
        exit;
    }
} else {
    setFlash('error', 'Geçersiz slider ID!');
    header('Location: sliders.php');
    exit;
}

// POST processing BEFORE header include
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean($_POST['title']);
    $description = clean($_POST['description']);
    $button_text = clean($_POST['button_text']);
    $button_link = clean($_POST['button_link']);
    $sort_order = (int)$_POST['sort_order'];
    $status = isset($_POST['status']) ? 1 : 0;

    $image = $slider['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        deleteImage($slider['image']);
        $image = uploadImage($_FILES['image'], 'slider');
        if (!$image) {
            setFlash('error', 'Resim yüklenirken hata oluştu!');
            header('Location: slider_edit.php?id=' . $id);
            exit;
        }
    }

    $sql = "UPDATE sliders SET title = ?, description = ?, image = ?, button_text = ?,
            button_link = ?, sort_order = ?, status = ? WHERE id = ?";

    if ($db->execute($sql, [$title, $description, $image, $button_text, $button_link, $sort_order, $status, $id])) {
        setFlash('success', 'Slider başarıyla güncellendi!');
        header('Location: sliders.php');
        exit;
    } else {
        setFlash('error', 'Slider güncellenirken hata oluştu!');
    }
}

// NOW include header
$pageTitle = 'Slider Düzenle';
include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-edit"></i> Slider Düzenle
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Başlık *</label>
                        <input type="text" name="title" class="form-control" value="<?= clean($slider['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" class="form-control" rows="3"><?= clean($slider['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Buton Metni</label>
                                <input type="text" name="button_text" class="form-control" value="<?= clean($slider['button_text']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Buton Linki</label>
                                <input type="text" name="button_link" class="form-control" value="<?= clean($slider['button_link']) ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Mevcut Görsel</label>
                        <div class="mb-2">
                            <img src="../<?= $slider['image'] ?>" alt="" class="img-fluid">
                        </div>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Yeni görsel yüklemek için seçin</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sıra</label>
                        <input type="number" name="sort_order" class="form-control" value="<?= $slider['sort_order'] ?>">
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" <?= $slider['status'] ? 'checked' : '' ?>>
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
                    <i class="fas fa-save"></i> Güncelle
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
