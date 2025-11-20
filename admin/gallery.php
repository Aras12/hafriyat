<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();

// DELETE (header include'dan ÖNCE)
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    $g=$db->fetchOne("SELECT image FROM gallery WHERE id=?",[$id]);
    if($g&&$g['image'])deleteImage($g['image']);
    $db->execute("DELETE FROM gallery WHERE id=?",[$id]);
    setFlash('success','Görsel silindi!');
    header('Location: gallery.php');
    exit;
}

// POST (header include'dan ÖNCE)
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=clean($_POST['title']);
    $category=clean($_POST['category']);
    $description=clean($_POST['description']);
    $sort_order=(int)$_POST['sort_order'];
    $image='';
    if(isset($_FILES['image'])&&$_FILES['image']['error']===UPLOAD_ERR_OK){
        $image=uploadImage($_FILES['image'],'galeri');
        if($image){
            $result = $db->execute("INSERT INTO gallery(title,description,image,category,sort_order,status)VALUES(?,?,?,?,?,1)",
                [$title,$description,$image,$category,$sort_order]);
            setFlash($result ? 'success' : 'error', $result ? 'Görsel eklendi!' : 'Görsel eklenirken hata oluştu!');
        } else {
            setFlash('error', 'Görsel yüklenirken hata oluştu!');
        }
    } else {
        setFlash('error', 'Lütfen bir görsel seçin!');
    }
    header('Location: gallery.php');
    exit;
}

$gallery=$db->fetchAll("SELECT * FROM gallery ORDER BY sort_order ASC");

// ŞİMDİ header include et
$pageTitle = 'Galeri Yönetimi';
include 'includes/header.php';
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-image"></i> Galeri</span>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Yeni Görsel</button>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <?php foreach($gallery as $g): ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="../<?=$g['image']?>" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6><?=clean($g['title'])?></h6>
                            <span class="badge bg-info"><?=clean($g['category'])?></span>
                            <div class="mt-2">
                                <a href="?delete=<?=$g['id']?>" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header"><h5>Yeni Görsel</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Başlık *</label><input type="text" name="title" class="form-control" required></div>
                    <div class="mb-3"><label>Kategori</label><input type="text" name="category" class="form-control"></div>
                    <div class="mb-3"><label>Açıklama</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                    <div class="mb-3"><label>Görsel *</label><input type="file" name="image" class="form-control" accept="image/*" required></div>
                    <div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="0"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
