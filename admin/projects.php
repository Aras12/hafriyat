<?php
$pageTitle = 'Proje Yönetimi';
include 'includes/header.php';
if(isset($_GET['delete'])){$id=(int)$_GET['delete'];$p=$db->fetchOne("SELECT image FROM projects WHERE id=?",[$id]);if($p&&$p['image'])deleteImage($p['image']);$db->execute("DELETE FROM projects WHERE id=?",[$id]);setFlash('success','Proje silindi!');header('Location: projects.php');exit;}
$projects=$db->fetchAll("SELECT * FROM projects ORDER BY sort_order ASC");
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-project-diagram"></i> Projeler</span>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Yeni Proje</button>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead><tr><th>Görsel</th><th>Başlık</th><th>Konum</th><th>Müşteri</th><th>Tarih</th><th>İşlemler</th></tr></thead>
            <tbody>
                <?php foreach($projects as $p): ?>
                    <tr>
                        <td><img src="../<?=$p['image']?>" style="max-width:80px;"></td>
                        <td><?=clean($p['title'])?></td>
                        <td><?=clean($p['location'])?></td>
                        <td><?=clean($p['client'])?></td>
                        <td><?=$p['completion_date']?formatDate($p['completion_date']):'-'?></td>
                        <td><a href="?delete=<?=$p['id']?>" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header"><h5>Yeni Proje</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label>Başlık *</label><input type="text" name="title" class="form-control" required></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Konum</label><input type="text" name="location" class="form-control"></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Müşteri</label><input type="text" name="client" class="form-control"></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Tamamlanma Tarihi</label><input type="date" name="completion_date" class="form-control"></div></div>
                        <div class="col-md-12"><div class="mb-3"><label>Açıklama</label><textarea name="description" class="form-control" rows="2"></textarea></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Kategori</label><input type="text" name="category" class="form-control"></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Görsel *</label><input type="file" name="image" class="form-control" accept="image/*" required></div></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=clean($_POST['title']);
    $description=clean($_POST['description']);
    $location=clean($_POST['location']);
    $client=clean($_POST['client']);
    $completion_date=clean($_POST['completion_date'])?:null;
    $category=clean($_POST['category']);
    $image='';
    if(isset($_FILES['image'])&&$_FILES['image']['error']===UPLOAD_ERR_OK){
        $image=uploadImage($_FILES['image'],'projeler');
        if($image){
            $db->execute("INSERT INTO projects(title,description,location,client,completion_date,image,category,status)VALUES(?,?,?,?,?,?,?,1)",
                [$title,$description,$location,$client,$completion_date,$image,$category]);
            setFlash('success','Proje eklendi!');
            header('Location: projects.php');
            exit;
        }
    }
}
include 'includes/footer.php';
?>
