<?php
$pageTitle = 'Proje Yönetimi';
include 'includes/header.php';

// DELETE
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    $p=$db->fetchOne("SELECT image FROM projects WHERE id=?",[$id]);
    if($p&&$p['image'])deleteImage($p['image']);
    $db->execute("DELETE FROM projects WHERE id=?",[$id]);
    setFlash('success','Proje silindi!');
    header('Location: projects.php');
    exit;
}

// POST - ADD OR EDIT
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=(int)($_POST['id']??0);
    $title=clean($_POST['title']);
    $description=clean($_POST['description']);
    $location=clean($_POST['location']);
    $client=clean($_POST['client']);
    $completion_date=clean($_POST['completion_date'])?:null;
    $category=clean($_POST['category']);
    $sort_order=(int)$_POST['sort_order'];
    $status=isset($_POST['status'])?1:0;

    if($id>0){
        // EDIT
        $project=$db->fetchOne("SELECT * FROM projects WHERE id=?",[$id]);
        $image=$project['image'];
        if(isset($_FILES['image'])&&$_FILES['image']['error']===UPLOAD_ERR_OK){
            if($image)deleteImage($image);
            $image=uploadImage($_FILES['image'],'projeler');
        }
        $db->execute("UPDATE projects SET title=?,description=?,location=?,client=?,completion_date=?,image=?,category=?,sort_order=?,status=? WHERE id=?",
            [$title,$description,$location,$client,$completion_date,$image,$category,$sort_order,$status,$id]);
        setFlash('success','Proje güncellendi!');
    }else{
        // ADD
        $image='';
        if(isset($_FILES['image'])&&$_FILES['image']['error']===UPLOAD_ERR_OK){
            $image=uploadImage($_FILES['image'],'projeler');
        }
        $db->execute("INSERT INTO projects(title,description,location,client,completion_date,image,category,sort_order,status)VALUES(?,?,?,?,?,?,?,?,?)",
            [$title,$description,$location,$client,$completion_date,$image,$category,$sort_order,$status]);
        setFlash('success','Proje eklendi!');
    }
    header('Location: projects.php');
    exit;
}

$projects=$db->fetchAll("SELECT * FROM projects ORDER BY sort_order ASC");
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-project-diagram"></i> Projeler</span>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Yeni Proje</button>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead><tr><th>Görsel</th><th>Başlık</th><th>Konum</th><th>Müşteri</th><th>Tarih</th><th>Durum</th><th>İşlemler</th></tr></thead>
            <tbody>
                <?php foreach($projects as $p): ?>
                    <tr>
                        <td><?php if($p['image']): ?><img src="../<?=$p['image']?>" style="max-width:80px;border-radius:5px;"><?php endif; ?></td>
                        <td><?=clean($p['title'])?></td>
                        <td><?=clean($p['location'])?></td>
                        <td><?=clean($p['client'])?></td>
                        <td><?=$p['completion_date']?formatDate($p['completion_date']):'-'?></td>
                        <td><?=$p['status']?'<span class="badge badge-active">Aktif</span>':'<span class="badge badge-inactive">Pasif</span>'?></td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-warning" onclick="editProject(<?=htmlspecialchars(json_encode($p))?>)"><i class="fas fa-edit"></i></button>
                            <a href="?delete=<?=$p['id']?>" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
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
                        <div class="col-md-4"><div class="mb-3"><label>Kategori</label><input type="text" name="category" class="form-control"></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="0"></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Görsel *</label><input type="file" name="image" class="form-control" accept="image/*" required></div></div>
                        <div class="col-md-12"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" checked><label>Aktif</label></div></div>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header"><h5>Proje Düzenle</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label>Başlık *</label><input type="text" name="title" id="edit_title" class="form-control" required></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Konum</label><input type="text" name="location" id="edit_location" class="form-control"></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Müşteri</label><input type="text" name="client" id="edit_client" class="form-control"></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Tamamlanma Tarihi</label><input type="date" name="completion_date" id="edit_completion_date" class="form-control"></div></div>
                        <div class="col-md-12"><div class="mb-3"><label>Açıklama</label><textarea name="description" id="edit_description" class="form-control" rows="2"></textarea></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Kategori</label><input type="text" name="category" id="edit_category" class="form-control"></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" id="edit_sort_order" class="form-control"></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Görsel</label><img src="" id="edit_image_preview" class="img-fluid mb-2" style="max-height:100px;"><input type="file" name="image" class="form-control" accept="image/*"></div></div>
                        <div class="col-md-12"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" id="edit_status"><label>Aktif</label></div></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editProject(p) {
    document.getElementById('edit_id').value = p.id;
    document.getElementById('edit_title').value = p.title;
    document.getElementById('edit_location').value = p.location||'';
    document.getElementById('edit_client').value = p.client||'';
    document.getElementById('edit_completion_date').value = p.completion_date||'';
    document.getElementById('edit_description').value = p.description||'';
    document.getElementById('edit_category').value = p.category||'';
    document.getElementById('edit_sort_order').value = p.sort_order||0;
    document.getElementById('edit_status').checked = p.status==1;
    document.getElementById('edit_image_preview').src = p.image ? '../'+p.image : '';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<?php include 'includes/footer.php'; ?>
