<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();

// GET existing data BEFORE POST check
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $blog = $db->fetchOne("SELECT * FROM blog WHERE id = ?", [$id]);
    if (!$blog) {
        setFlash('error', 'Blog yazısı bulunamadı!');
        header('Location: blog.php');
        exit;
    }
} else {
    setFlash('error', 'Geçersiz blog ID!');
    header('Location: blog.php');
    exit;
}

// POST processing BEFORE header include
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id']; // POST'tan al
    $title = clean($_POST['title']);
    $slug = createSlug($_POST['slug'] ?: $title);
    $excerpt = clean($_POST['excerpt']);
    $content = $_POST['content'];
    $category = clean($_POST['category']);
    $author = clean($_POST['author']);
    $status = isset($_POST['status']) ? 1 : 0;
    $meta_title = clean($_POST['meta_title']) ?: $title;
    $meta_description = clean($_POST['meta_description']);
    $meta_keywords = clean($_POST['meta_keywords']);

    $featured_image = $blog['featured_image'];
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        if ($featured_image) deleteImage($featured_image);
        $featured_image = uploadImage($_FILES['featured_image'], 'blog');
    }

    $sql = "UPDATE blog SET title = ?, slug = ?, excerpt = ?, content = ?, featured_image = ?, category = ?,
            author = ?, status = ?, meta_title = ?, meta_description = ?, meta_keywords = ? WHERE id = ?";

    if ($db->execute($sql, [$title, $slug, $excerpt, $content, $featured_image, $category, $author, $status, $meta_title, $meta_description, $meta_keywords, $id])) {
        setFlash('success', 'Blog yazısı başarıyla güncellendi!');
        header('Location: blog.php');
        exit;
    } else {
        setFlash('error', 'Blog yazısı güncellenirken hata oluştu!');
    }
}

// NOW include header
$pageTitle = 'Blog Düzenle';
include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-edit"></i> Blog Düzenle
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $blog['id'] ?>">
            <div class="row">
                <div class="col-md-9">
                    <div class="mb-3">
                        <label class="form-label">Başlık *</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?= clean($blog['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (URL)</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="<?= clean($blog['slug']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Özet</label>
                        <textarea name="excerpt" class="form-control" rows="2"><?= clean($blog['excerpt']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">İçerik *</label>
                        <textarea name="content" id="content" class="ckeditor" required><?= $blog['content'] ?></textarea>
                    </div>

                    <hr>
                    <h5><i class="fas fa-search"></i> SEO Ayarları</h5>

                    <div class="mb-3">
                        <label class="form-label">Meta Başlık</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= clean($blog['meta_title']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Açıklama</label>
                        <textarea name="meta_description" class="form-control" rows="2"><?= clean($blog['meta_description']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Kelimeler</label>
                        <input type="text" name="meta_keywords" class="form-control" value="<?= clean($blog['meta_keywords']) ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" class="form-control" value="<?= clean($blog['category']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Yazar</label>
                        <input type="text" name="author" class="form-control" value="<?= clean($blog['author']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mevcut Görsel</label>
                        <?php if ($blog['featured_image']): ?>
                            <img src="../<?= $blog['featured_image'] ?>" alt="" class="img-fluid mb-2">
                        <?php endif; ?>
                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" <?= $blog['status'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="status">Yayınla</label>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <small><i class="fas fa-eye"></i> <?= $blog['views'] ?> görüntülenme</small>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-between">
                <a href="blog.php" class="btn btn-secondary">
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
