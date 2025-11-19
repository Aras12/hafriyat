<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();

// POST processing BEFORE header include
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean($_POST['title']);
    $slug = createSlug($_POST['slug'] ?: $title);
    $excerpt = clean($_POST['excerpt']);
    $content = $_POST['content']; // CKEditor için clean kullanmıyoruz
    $category = clean($_POST['category']);
    $author = clean($_POST['author']);
    $status = isset($_POST['status']) ? 1 : 0;
    $meta_title = clean($_POST['meta_title']) ?: $title;
    $meta_description = clean($_POST['meta_description']);
    $meta_keywords = clean($_POST['meta_keywords']);

    $featured_image = '';
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        $featured_image = uploadImage($_FILES['featured_image'], 'blog');
    }

    $sql = "INSERT INTO blog (title, slug, excerpt, content, featured_image, category, author, status, meta_title, meta_description, meta_keywords)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($db->execute($sql, [$title, $slug, $excerpt, $content, $featured_image, $category, $author, $status, $meta_title, $meta_description, $meta_keywords])) {
        setFlash('success', 'Blog yazısı başarıyla eklendi!');
        header('Location: blog.php');
        exit;
    } else {
        setFlash('error', 'Blog yazısı eklenirken hata oluştu!');
    }
}

// NOW include header
$pageTitle = 'Yeni Blog Yazısı';
include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-plus"></i> Yeni Blog Yazısı
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-9">
                    <div class="mb-3">
                        <label class="form-label">Başlık *</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (URL)</label>
                        <input type="text" name="slug" id="slug" class="form-control">
                        <small class="text-muted">Boş bırakılırsa otomatik oluşturulur</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Özet</label>
                        <textarea name="excerpt" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">İçerik *</label>
                        <textarea name="content" id="content" class="ckeditor" required></textarea>
                    </div>

                    <!-- SEO Ayarları -->
                    <hr>
                    <h5><i class="fas fa-search"></i> SEO Ayarları</h5>

                    <div class="mb-3">
                        <label class="form-label">Meta Başlık</label>
                        <input type="text" name="meta_title" class="form-control">
                        <small class="text-muted">Boş bırakılırsa başlık kullanılır</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Açıklama</label>
                        <textarea name="meta_description" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Kelimeler</label>
                        <input type="text" name="meta_keywords" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" class="form-control" value="Hafriyat">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Yazar</label>
                        <input type="text" name="author" class="form-control" value="Admin">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Öne Çıkan Görsel</label>
                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                            <label class="form-check-label" for="status">Yayınla</label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-between">
                <a href="blog.php" class="btn btn-secondary">
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
