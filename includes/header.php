<?php
require_once __DIR__ . '/../config.php';
$db = Database::getInstance();

// Meta defaults
$pageMetaTitle = $pageMetaTitle ?? getMeta('meta_home_title', 'Emir Hafriyat');
$pageMetaDesc = $pageMetaDesc ?? getMeta('meta_home_description', '');
$pageMetaKeywords = $pageMetaKeywords ?? getMeta('meta_home_keywords', '');
$pageTitle = $pageTitle ?? 'Ana Sayfa';
$pageUrl = $pageUrl ?? siteUrl();

// Site settings
$siteLogo = getMeta('site_logo', 'assets/img/logo.png');
$siteTitle = getMeta('site_title', 'Emir Hafriyat');
$siteFavicon = getMeta('site_favicon', 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚛</text></svg>');

// Hizmetler menü için
$services = $db->fetchAll("SELECT * FROM services WHERE status = 1 ORDER BY sort_order ASC LIMIT 8");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= clean($pageMetaDesc) ?>">
    <meta name="keywords" content="<?= clean($pageMetaKeywords) ?>">
    <meta name="author" content="Kayseri Emir Hafriyat">
    <meta property="og:title" content="<?= clean($pageMetaTitle) ?>">
    <meta property="og:description" content="<?= clean($pageMetaDesc) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $pageUrl ?>">
    <meta property="og:image" content="<?= siteUrl('assets/img/slider/slide1.jpg') ?>">
    <link rel="canonical" href="<?= $pageUrl ?>">
    <link rel="icon" type="image/png" href="<?= $siteFavicon ?>">
    <title><?= clean($pageMetaTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= siteUrl() ?>">
                <img src="<?= asset($siteLogo) ?>" alt="<?= clean($siteTitle) ?> Logo" height="50" class="me-2">
                <span><?= clean($siteTitle) ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link <?= isActive('index') ?>" href="<?= siteUrl() ?>">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link <?= isActive('hakkimizda') ?>" href="<?= siteUrl('hakkimizda') ?>">Hakkımızda</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="hizmetlerDropdown" role="button" data-bs-toggle="dropdown">Hizmetler</a>
                        <ul class="dropdown-menu">
                            <?php foreach($services as $service): ?>
                                <li><a class="dropdown-item" href="<?= siteUrl('hizmet/' . $service['slug']) ?>"><?= clean($service['title']) ?></a></li>
                            <?php endforeach; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= siteUrl('hizmetler') ?>">Tüm Hizmetler</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link <?= isActive('galeri') ?>" href="<?= siteUrl('galeri') ?>">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link <?= isActive('projeler') ?>" href="<?= siteUrl('projeler') ?>">Projeler</a></li>
                    <li class="nav-item"><a class="nav-link <?= isActive('blog') ?>" href="<?= siteUrl('blog') ?>">Blog</a></li>
                    <li class="nav-item"><a class="nav-link <?= isActive('iletisim') ?>" href="<?= siteUrl('iletisim') ?>">İletişim</a></li>
                </ul>
            </div>
        </div>
    </nav>
