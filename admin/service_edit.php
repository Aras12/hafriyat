<?php
$pageTitle = 'Hizmet Düzenle';
include 'includes/header.php';
$id = (int)$_GET['id'];
$service = $db->fetchOne("SELECT * FROM services WHERE id = ?", [$id]);
if (!$service) { setFlash('error', 'Hizmet bulunamadı!'); header('Location: services.php'); exit; }
$tabs = $db->fetchAll("SELECT * FROM service_tabs WHERE status = 1 ORDER BY sort_order");

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

    $image = $service['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($image) deleteImage($image);
        $image = uploadImage($_FILES['image'], 'hizmetler');
    }

    $sql = "UPDATE services SET title=?, slug=?, short_description=?, description=?, icon=?, image=?, features=?, tab_category=?, sort_order=?, status=?, meta_title=?, meta_description=?, meta_keywords=? WHERE id=?";
    if ($db->execute($sql, [$title, $slug, $short_description, $description, $icon, $image, $features, $tab_category, $sort_order, $status, $meta_title, $meta_description, $meta_keywords, $id])) {
        setFlash('success', 'Hizmet güncellendi!');
        header('Location: services.php');
        exit;
    }
}
?>
<div class="card">
    <div class="card-header"><i class="fas fa-edit"></i> Hizmet Düzenle</div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-9">
                    <div class="mb-3"><label>Başlık *</label><input type="text" name="title" id="title" class="form-control" value="<?=clean($service['title'])?>" required></div>
                    <div class="mb-3"><label>Slug</label><input type="text" name="slug" id="slug" class="form-control" value="<?=clean($service['slug'])?>"></div>
                    <div class="mb-3"><label>Kısa Açıklama</label><input type="text" name="short_description" class="form-control" value="<?=clean($service['short_description'])?>"></div>
                    <div class="mb-3"><label>Açıklama</label><textarea name="description" class="ckeditor"><?=$service['description']?></textarea></div>
                    <div class="mb-3"><label>Özellikler</label><input type="text" name="features" class="form-control" value="<?=clean($service['features'])?>"></div>
                    <hr><h5>SEO</h5>
                    <div class="mb-3"><label>Meta Başlık</label><input type="text" name="meta_title" class="form-control" value="<?=clean($service['meta_title'])?>"></div>
                    <div class="mb-3"><label>Meta Açıklama</label><textarea name="meta_description" class="form-control" rows="2"><?=clean($service['meta_description'])?></textarea></div>
                    <div class="mb-3"><label>Meta Kelimeler</label><input type="text" name="meta_keywords" class="form-control" value="<?=clean($service['meta_keywords'])?>"></div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3"><label>Mevcut Görsel</label><?php if($service['image']): ?><img src="../<?=$service['image']?>" class="img-fluid mb-2"><?php endif; ?><input type="file" name="image" class="form-control" accept="image/*"></div>
                    <div class="mb-3"><label>İkon</label><input type="text" name="icon" class="form-control" value="<?=clean($service['icon'])?>"></div>
                    <div class="mb-3"><label>Tab Kategorisi</label><select name="tab_category" class="form-select"><?php foreach($tabs as $tab): ?><option value="<?=$tab['tab_key']?>" <?=$service['tab_category']==$tab['tab_key']?'selected':''?>><?=$tab['tab_name']?></option><?php endforeach; ?></select></div>
                    <div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="<?=$service['sort_order']?>"></div>
                    <div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" <?=$service['status']?'checked':''?>><label>Aktif</label></div></div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <a href="services.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Güncelle</button>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
