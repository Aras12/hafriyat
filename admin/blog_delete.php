<?php
require_once '../config.php';
requireAdmin();

$id = (int)$_GET['id'];
$db = Database::getInstance();
$blog = $db->fetchOne("SELECT * FROM blog WHERE id = ?", [$id]);

if ($blog) {
    if ($blog['featured_image']) deleteImage($blog['featured_image']);
    if ($db->execute("DELETE FROM blog WHERE id = ?", [$id])) {
        setFlash('success', 'Blog yazısı silindi!');
    } else {
        setFlash('error', 'Blog yazısı silinirken hata oluştu!');
    }
} else {
    setFlash('error', 'Blog yazısı bulunamadı!');
}

header('Location: blog.php');
exit;
