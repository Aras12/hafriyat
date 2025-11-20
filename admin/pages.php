<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();

// POST işlemi ÖNCE yapılmalı (header include'dan önce)
if($_SERVER['REQUEST_METHOD']==='POST'){
    $page_key=clean($_POST['page_key']);
    $content=$_POST['content'];
    $meta_title=clean($_POST['meta_title']);
    $meta_description=clean($_POST['meta_description']);
    $meta_keywords=clean($_POST['meta_keywords']);

    $result = $db->execute("UPDATE pages SET content=?,meta_title=?,meta_description=?,meta_keywords=? WHERE page_key=?",
        [$content,$meta_title,$meta_description,$meta_keywords,$page_key]);

    if($result) {
        setFlash('success','Sayfa güncellendi!');
    } else {
        setFlash('error','Sayfa güncellenirken hata oluştu!');
    }
    header('Location: pages.php');
    exit;
}

$pages=$db->fetchAll("SELECT * FROM pages ORDER BY id");

// Şimdi header include et
$pageTitle = 'Sayfa İçerikleri';
include 'includes/header.php';
?>
<div class="row g-3">
    <?php foreach($pages as $page): ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-file-alt"></i> <?=clean($page['page_title'])?>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="page_key" value="<?=$page['page_key']?>">
                        <div class="mb-3"><label>İçerik</label><textarea name="content" class="ckeditor"><?=$page['content']?></textarea></div>
                        <hr>
                        <h6>SEO Ayarları</h6>
                        <div class="mb-3"><label>Meta Başlık</label><input type="text" name="meta_title" class="form-control" value="<?=clean($page['meta_title'])?>"></div>
                        <div class="mb-3"><label>Meta Açıklama</label><textarea name="meta_description" class="form-control" rows="2"><?=clean($page['meta_description'])?></textarea></div>
                        <div class="mb-3"><label>Meta Kelimeler</label><input type="text" name="meta_keywords" class="form-control" value="<?=clean($page['meta_keywords'])?>"></div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Güncelle</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'includes/footer.php'; ?>
