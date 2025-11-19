<?php
require_once '../config.php';

// Zaten giriş yapmışsa dashboard'a yönlendir
if (isAdmin()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $db = Database::getInstance();
        $user = $db->fetchOne("SELECT * FROM admin_users WHERE username = ?", [$username]);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['full_name'];

            // Son giriş zamanını güncelle
            $db->execute("UPDATE admin_users SET last_login = NOW() WHERE id = ?", [$user['id']]);

            header('Location: index.php');
            exit;
        } else {
            $error = 'Kullanıcı adı veya şifre hatalı!';
        }
    } else {
        $error = 'Tüm alanları doldurun!';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi - Emir Hafriyat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0F172A, #1E40AF);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 50px rgba(0,0,0,0.3);
        }
        .login-header {
            background: linear-gradient(135deg, #FFC107, #FF9800);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }
        .login-body {
            padding: 30px;
        }
        .btn-login {
            background: #1E40AF;
            color: white;
            width: 100%;
            padding: 12px;
            font-weight: 600;
        }
        .btn-login:hover {
            background: #0F172A;
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-truck-monster fa-3x mb-3"></i>
            <h3>Emir Hafriyat</h3>
            <p class="mb-0">Admin Paneli</p>
        </div>
        <div class="login-body">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-user"></i> Kullanıcı Adı
                    </label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Şifre
                    </label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Giriş Yap
                </button>
            </form>

            <div class="text-center mt-4 text-muted small">
                <i class="fas fa-shield-alt"></i> Güvenli Giriş
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
