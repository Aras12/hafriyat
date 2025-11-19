<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();
$db->execute("DELETE FROM testimonials WHERE id = ?", [(int)$_GET['id']]);
setFlash('success', 'Yorum silindi!');
header('Location: testimonials.php');
exit;
