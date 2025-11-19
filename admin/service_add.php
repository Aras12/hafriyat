<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();

// GET tabs data for form
$tabs = $db->fetchAll("SELECT * FROM service_tabs WHERE status = 1 ORDER BY sort_order");

// POST processing BEFORE header include
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean($_POST['title']);
    $slug = createSlug($_POST['slug'] ?: $title);
    $short_description = clean($_POST['short_description']);
    $description = $_POST['description'];
    $icon = clean($_POST['icon']);
    $features = clean($_POST['features']);
    $tab_category = clean($_POST['tab_category']);
    $sort_order = (int)$_POST['sort_order'];
    $status = isset($_POST['status']) ? 1 : 0;
    $meta_title = clean($_POST['meta_title']) ?: $title;
    $meta_description = clean($_POST['meta_description']);
    $meta_keywords = clean($_POST['meta_keywords']);

    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = uploadImage($_FILES['image'], 'hizmetler');
    }

    $sql = "INSERT INTO services (title, slug, short_description, description, icon, image, features, tab_category, sort_order, status, meta_title, meta_description, meta_keywords)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($db->execute($sql, [$title, $slug, $short_description, $description, $icon, $image, $features, $tab_category, $sort_order, $status, $meta_title, $meta_description, $meta_keywords])) {
        setFlash('success', 'Hizmet eklendi!');
        header('Location: services.php');
        exit;
    }
}

// NOW include header
$pageTitle = 'Yeni Hizmet';
include 'includes/header.php';
?>
<div class="card">
    <div class="card-header"><i class="fas fa-plus"></i> Yeni Hizmet</div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-9">
                    <div class="mb-3"><label>Başlık *</label><input type="text" name="title" id="title" class="form-control" required></div>
                    <div class="mb-3"><label>Slug</label><input type="text" name="slug" id="slug" class="form-control"></div>
                    <div class="mb-3"><label>Kısa Açıklama</label><input type="text" name="short_description" class="form-control"></div>
                    <div class="mb-3"><label>Açıklama</label><textarea name="description" class="ckeditor"></textarea></div>
                    <div class="mb-3"><label>Özellikler (virgülle ayırın)</label><input type="text" name="features" class="form-control"></div>
                    <hr><h5>SEO</h5>
                    <div class="mb-3"><label>Meta Başlık</label><input type="text" name="meta_title" class="form-control"></div>
                    <div class="mb-3"><label>Meta Açıklama</label><textarea name="meta_description" class="form-control" rows="2"></textarea></div>
                    <div class="mb-3"><label>Meta Kelimeler</label><input type="text" name="meta_keywords" class="form-control"></div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3"><label>Görsel</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                    <div class="mb-3"><label>İkon (FA Class)</label><input type="text" name="icon" class="form-control" value="fas fa-cogs"></div>
                    <div class="mb-3"><label>Tab Kategorisi</label><select name="tab_category" class="form-select"><?php foreach($tabs as $tab): ?><option value="<?=$tab['tab_key']?>"><?=$tab['tab_name']?></option><?php endforeach; ?></select></div>
                    <div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="0"></div>
                    <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" checked><label>Aktif</label></div></div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <a href="services.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
