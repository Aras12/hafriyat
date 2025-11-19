<?php
require_once '../config.php';
requireAdmin();

$db = Database::getInstance();
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Panel' ?> - Emir Hafriyat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-yellow: #FFC107;
            --primary-blue: #1E40AF;
            --dark-blue: #0F172A;
        }
        body {
            background: #f8f9fa;
        }
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--dark-blue), var(--primary-blue));
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li a {
            display: block;
            padding: 15px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.1);
            color: var(--primary-yellow);
            border-left: 3px solid var(--primary-yellow);
        }
        .sidebar-menu li a i {
            width: 25px;
            margin-right: 10px;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
        }
        .top-bar {
            background: white;
            padding: 15px 20px;
            margin: -20px -20px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary-blue);
        }
        .btn-primary {
            background: var(--primary-blue);
            border: none;
        }
        .btn-primary:hover {
            background: var(--dark-blue);
        }
        .btn-warning {
            background: var(--primary-yellow);
            border: none;
            color: #000;
        }
        .table-actions {
            white-space: nowrap;
        }
        .badge-active {
            background: #28a745;
        }
        .badge-inactive {
            background: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-truck-monster fa-2x mb-2"></i>
            <h5>Emir Hafriyat</h5>
            <small>Admin Panel</small>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="index.php" class="<?= $current_page === 'index' ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="sliders.php" class="<?= $current_page === 'sliders' ? 'active' : '' ?>">
                    <i class="fas fa-images"></i> Slider Yönetimi
                </a>
            </li>
            <li>
                <a href="services.php" class="<?= $current_page === 'services' ? 'active' : '' ?>">
                    <i class="fas fa-cogs"></i> Hizmetler
                </a>
            </li>
            <li>
                <a href="tabs.php" class="<?= $current_page === 'tabs' ? 'active' : '' ?>">
                    <i class="fas fa-folder-open"></i> Tab Kategorileri
                </a>
            </li>
            <li>
                <a href="faqs.php" class="<?= $current_page === 'faqs' ? 'active' : '' ?>">
                    <i class="fas fa-question-circle"></i> SSS Yönetimi
                </a>
            </li>
            <li>
                <a href="testimonials.php" class="<?= $current_page === 'testimonials' ? 'active' : '' ?>">
                    <i class="fas fa-comments"></i> Yorumlar
                </a>
            </li>
            <li>
                <a href="blog.php" class="<?= $current_page === 'blog' ? 'active' : '' ?>">
                    <i class="fas fa-blog"></i> Blog Yönetimi
                </a>
            </li>
            <li>
                <a href="gallery.php" class="<?= $current_page === 'gallery' ? 'active' : '' ?>">
                    <i class="fas fa-image"></i> Galeri
                </a>
            </li>
            <li>
                <a href="projects.php" class="<?= $current_page === 'projects' ? 'active' : '' ?>">
                    <i class="fas fa-project-diagram"></i> Projeler
                </a>
            </li>
            <li>
                <a href="pages.php" class="<?= $current_page === 'pages' ? 'active' : '' ?>">
                    <i class="fas fa-file-alt"></i> Sayfa İçerikleri
                </a>
            </li>
            <li>
                <a href="messages.php" class="<?= $current_page === 'messages' ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i> Gelen Mesajlar
                </a>
            </li>
            <li>
                <a href="settings.php" class="<?= $current_page === 'settings' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i> Ayarlar
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Çıkış
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><?= $pageTitle ?? 'Dashboard' ?></h4>
            <div>
                <span class="text-muted me-3">
                    <i class="fas fa-user"></i> <?= $_SESSION['admin_name'] ?>
                </span>
                <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Siteyi Görüntüle
                </a>
            </div>
        </div>

        <?php if (hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> <?= getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> <?= getFlash('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
