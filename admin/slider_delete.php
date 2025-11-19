<?php
require_once '../config.php';
requireAdmin();

$id = (int)$_GET['id'];
$db = Database::getInstance();
$slider = $db->fetchOne("SELECT * FROM sliders WHERE id = ?", [$id]);

if ($slider) {
    deleteImage($slider['image']);
    if ($db->execute("DELETE FROM sliders WHERE id = ?", [$id])) {
        setFlash('success', 'Slider başarıyla silindi!');
    } else {
        setFlash('error', 'Slider silinirken hata oluştu!');
    }
} else {
    setFlash('error', 'Slider bulunamadı!');
}

header('Location: sliders.php');
exit;
