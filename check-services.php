<?php
require_once 'config.php';
$db = Database::getInstance();

echo "<h2>Mevcut Hizmetler ve İçerikleri:</h2>\n";

$services = $db->fetchAll("SELECT id, title, slug, image, LEFT(description, 200) as desc_short FROM services ORDER BY id");

foreach($services as $service) {
    echo "\n====================================\n";
    echo "ID: {$service['id']}\n";
    echo "Başlık: {$service['title']}\n";
    echo "Slug: {$service['slug']}\n";
    echo "Resim: {$service['image']}\n";
    echo "İçerik (ilk 200 karakter): " . strip_tags($service['desc_short']) . "...\n";
}
