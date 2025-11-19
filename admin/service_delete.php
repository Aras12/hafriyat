<?php
require_once '../config.php';
requireAdmin();
$id = (int)$_GET['id'];
$db = Database::getInstance();
$service = $db->fetchOne("SELECT * FROM services WHERE id = ?", [$id]);
if ($service) {
    if ($service['image']) deleteImage($service['image']);
    $db->execute("DELETE FROM services WHERE id = ?", [$id]);
    setFlash('success', 'Hizmet silindi!');
}
header('Location: services.php');
exit;
