<?php
$pageTitle = 'Menü Yönetimi';
include 'includes/header.php';

// DELETE
if(isset($_GET['delete'])){
    $id=(int)$_GET['delete'];
    $db->execute("DELETE FROM menus WHERE id=?",[$id]);
    setFlash('success','Menü silindi!');
    header('Location: menus.php');
    exit;
}

// POST - ADD OR EDIT
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=(int)($_POST['id']??0);
    $title=clean($_POST['title']);
    $url=clean($_POST['url']);
    $target=clean($_POST['target']);
    $icon=clean($_POST['icon']);
    $parent_id=(int)$_POST['parent_id'];
    $position=clean($_POST['position']);
    $sort_order=(int)$_POST['sort_order'];
    $status=isset($_POST['status'])?1:0;

    if($id>0){
        // EDIT
        $db->execute("UPDATE menus SET title=?,url=?,target=?,icon=?,parent_id=?,position=?,sort_order=?,status=? WHERE id=?",
            [$title,$url,$target,$icon,$parent_id,$position,$sort_order,$status,$id]);
        setFlash('success','Menü güncellendi!');
    }else{
        // ADD
        $db->execute("INSERT INTO menus(title,url,target,icon,parent_id,position,sort_order,status)VALUES(?,?,?,?,?,?,?,?)",
            [$title,$url,$target,$icon,$parent_id,$position,$sort_order,$status]);
        setFlash('success','Menü eklendi!');
    }
    header('Location: menus.php');
    exit;
}

$menus=$db->fetchAll("SELECT * FROM menus ORDER BY position ASC, sort_order ASC");
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-bars"></i> Menü Yönetimi</span>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Yeni Menü</button>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead><tr><th>Sıra</th><th>Başlık</th><th>URL</th><th>İkon</th><th>Konum</th><th>Durum</th><th>İşlemler</th></tr></thead>
            <tbody>
                <?php foreach($menus as $m): ?>
                    <tr>
                        <td><?=$m['sort_order']?></td>
                        <td><?=clean($m['title'])?></td>
                        <td><code><?=clean($m['url'])?></code></td>
                        <td><i class="<?=$m['icon']?>"></i> <?=$m['icon']?></td>
                        <td><span class="badge bg-<?=$m['position']=='header'?'primary':'secondary'?>"><?=ucfirst($m['position'])?></span></td>
                        <td><?=$m['status']?'<span class="badge badge-active">Aktif</span>':'<span class="badge badge-inactive">Pasif</span>'?></td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-warning" onclick="editMenu(<?=htmlspecialchars(json_encode($m))?>)"><i class="fas fa-edit"></i></button>
                            <a href="?delete=<?=$m['id']?>" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header"><h5>Yeni Menü</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Başlık *</label><input type="text" name="title" class="form-control" required></div>
                    <div class="mb-3"><label>URL *</label><input type="text" name="url" class="form-control" placeholder="/hakkimizda" required></div>
                    <div class="mb-3"><label>İkon (Font Awesome)</label><input type="text" name="icon" class="form-control" placeholder="fas fa-home"></div>
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label>Konum</label><select name="position" class="form-select"><option value="header">Header</option><option value="footer">Footer</option></select></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Hedef</label><select name="target" class="form-select"><option value="_self">Aynı Pencere</option><option value="_blank">Yeni Pencere</option></select></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label>Üst Menü</label><input type="number" name="parent_id" class="form-control" value="0"></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="0"></div></div>
                    </div>
                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" checked><label>Aktif</label></div>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header"><h5>Menü Düzenle</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Başlık *</label><input type="text" name="title" id="edit_title" class="form-control" required></div>
                    <div class="mb-3"><label>URL *</label><input type="text" name="url" id="edit_url" class="form-control" required></div>
                    <div class="mb-3"><label>İkon (Font Awesome)</label><input type="text" name="icon" id="edit_icon" class="form-control"></div>
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label>Konum</label><select name="position" id="edit_position" class="form-select"><option value="header">Header</option><option value="footer">Footer</option></select></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Hedef</label><select name="target" id="edit_target" class="form-select"><option value="_self">Aynı Pencere</option><option value="_blank">Yeni Pencere</option></select></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label>Üst Menü</label><input type="number" name="parent_id" id="edit_parent_id" class="form-control"></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" id="edit_sort_order" class="form-control"></div></div>
                    </div>
                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="status" id="edit_status"><label>Aktif</label></div>
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
function editMenu(m) {
    document.getElementById('edit_id').value = m.id;
    document.getElementById('edit_title').value = m.title;
    document.getElementById('edit_url').value = m.url;
    document.getElementById('edit_icon').value = m.icon||'';
    document.getElementById('edit_position').value = m.position;
    document.getElementById('edit_target').value = m.target;
    document.getElementById('edit_parent_id').value = m.parent_id||0;
    document.getElementById('edit_sort_order').value = m.sort_order||0;
    document.getElementById('edit_status').checked = m.status==1;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<?php include 'includes/footer.php'; ?>
