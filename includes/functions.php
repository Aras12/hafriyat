<?php
/**
 * Yardımcı Fonksiyonlar
 */

// XSS Koruması
function clean($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// URL slug oluşturma
function createSlug($text) {
    $text = mb_strtolower($text, 'UTF-8');

    $find = array('ç', 'ğ', 'ı', 'ö', 'ş', 'ü');
    $replace = array('c', 'g', 'i', 'o', 's', 'u');
    $text = str_replace($find, $replace, $text);

    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    $text = trim($text, '-');

    return $text;
}

// Tarih formatı
function formatDate($date, $format = 'd.m.Y') {
    return date($format, strtotime($date));
}

// Kısa metin
function excerpt($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    return $text . '...';
}

// URL oluşturma
function siteUrl($path = '') {
    $base = rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . SITE_URL, '/');
    return $base . '/' . ltrim($path, '/');
}

// Asset URL
function asset($path) {
    return siteUrl($path);
}

// Aktif menü kontrolü
function isActive($page) {
    $current = basename($_SERVER['PHP_SELF'], '.php');
    return ($current === $page) ? 'active' : '';
}

// Admin kontrolü
function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Admin redirect
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: ' . siteUrl('admin/login.php'));
        exit;
    }
}

// Resim yükleme
function uploadImage($file, $directory = 'uploads') {
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }

    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxSize) {
        return false;
    }

    $uploadDir = BASE_PATH . '/assets/img/' . $directory . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return 'assets/img/' . $directory . '/' . $filename;
    }

    return false;
}

// Resim silme
function deleteImage($imagePath) {
    $fullPath = BASE_PATH . '/' . $imagePath;
    if (file_exists($fullPath) && is_file($fullPath)) {
        return unlink($fullPath);
    }
    return false;
}

// Flash mesajlar
function setFlash($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

function getFlash($type) {
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

function hasFlash($type) {
    return isset($_SESSION['flash'][$type]);
}

// Sayfalama
function paginate($total, $perPage = 10, $currentPage = 1) {
    $totalPages = ceil($total / $perPage);
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $perPage;

    return [
        'total' => $total,
        'per_page' => $perPage,
        'current_page' => $currentPage,
        'total_pages' => $totalPages,
        'offset' => $offset,
        'has_prev' => $currentPage > 1,
        'has_next' => $currentPage < $totalPages
    ];
}

// CSRF Token
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Meta tag helper
function getMeta($key, $default = '') {
    $db = Database::getInstance();
    return $db->getSetting($key, $default);
}
