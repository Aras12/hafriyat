<?php
$pageTitle = 'Tab Kategorileri';
include 'includes/header.php';
if(isset($_GET['delete'])){$db->execute("DELETE FROM service_tabs WHERE id=?",[(int)$_GET['delete']]);setFlash('success','Tab silindi!');header('Location: tabs.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['add'])){
    $tab_name=clean($_POST['tab_name']);
    $tab_key=createSlug($_POST['tab_key']?:$tab_name);
    $icon=clean($_POST['icon']);
    $sort_order=(int)$_POST['sort_order'];
    $db->execute("INSERT INTO service_tabs(tab_name,tab_key,icon,sort_order,status)VALUES(?,?,?,?,1)",[$tab_name,$tab_key,$icon,$sort_order]);
    setFlash('success','Tab eklendi!');
    header('Location: tabs.php');
    exit;
}
$tabs=$db->fetchAll("SELECT * FROM service_tabs ORDER BY sort_order");
?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="fas fa-folder-open"></i> Tab Listesi</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead><tr><th>Sıra</th><th>Tab Adı</th><th>Anahtar</th><th>İkon</th><th>İşlemler</th></tr></thead>
                    <tbody>
                        <?php foreach($tabs as $tab): ?>
                            <tr>
                                <td><?=$tab['sort_order']?></td>
                                <td><?=clean($tab['tab_name'])?></td>
                                <td><code><?=$tab['tab_key']?></code></td>
                                <td><i class="<?=$tab['icon']?>"></i></td>
                                <td><a href="?delete=<?=$tab['id']?>" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><i class="fas fa-plus"></i> Yeni Tab</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3"><label>Tab Adı *</label><input type="text" name="tab_name" class="form-control" required></div>
                    <div class="mb-3"><label>Anahtar</label><input type="text" name="tab_key" class="form-control"><small class="text-muted">Boş bırakılırsa otomatik</small></div>
                    <div class="mb-3"><label>İkon</label><input type="text" name="icon" class="form-control" value="fas fa-cogs"></div>
                    <div class="mb-3"><label>Sıra</label><input type="number" name="sort_order" class="form-control" value="<?=count($tabs)+1?>"></div>
                    <button type="submit" name="add" class="btn btn-primary w-100"><i class="fas fa-save"></i> Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
