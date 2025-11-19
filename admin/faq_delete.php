<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();
$db->execute("DELETE FROM faqs WHERE id = ?", [(int)$_GET['id']]);
setFlash('success', 'SSS silindi!');
header('Location: faqs.php');
exit;
