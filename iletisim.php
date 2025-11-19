<?php
require_once 'config.php';
$db = Database::getInstance();

$pageTitle = 'İletişim';
$page = $db->fetchOne("SELECT * FROM pages WHERE page_key = 'iletisim'", []);
$pageMetaTitle = $page['meta_title'] ?? 'İletişim | Emir Hafriyat';
$pageMetaDesc = $page['meta_description'] ?? '';
$pageMetaKeywords = $page['meta_keywords'] ?? '';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $phone = clean($_POST['phone'] ?? '');
    $subject = clean($_POST['subject'] ?? '');
    $message = clean($_POST['message'] ?? '');
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($name && $email && $subject && $message) {
        $sql = "INSERT INTO contact_messages (name, email, phone, subject, message, ip_address) VALUES (?, ?, ?, ?, ?, ?)";
        if ($db->execute($sql, [$name, $email, $phone, $subject, $message, $ip])) {
            $success = true;
        } else {
            $error = 'Mesaj gönderilirken hata oluştu. Lütfen tekrar deneyin.';
        }
    } else {
        $error = 'Lütfen tüm zorunlu alanları doldurun.';
    }
}

include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                <li class="breadcrumb-item active">İletişim</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold">İletişim</h1>
        <p class="lead">Bize ulaşın, size yardımcı olalım</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="contact-info-box">
                    <i class="fas fa-map-marker-alt"></i>
                    <h5>Adres</h5>
                    <p><?= nl2br(clean(getMeta('company_address'))) ?></p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info-box">
                    <i class="fas fa-phone"></i>
                    <h5>Telefon</h5>
                    <p><a href="tel:<?= preg_replace('/[^0-9]/', '', getMeta('company_phone')) ?>"><?= clean(getMeta('company_phone')) ?></a></p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info-box">
                    <i class="fas fa-envelope"></i>
                    <h5>E-posta</h5>
                    <p><a href="mailto:<?= getMeta('company_email') ?>"><?= clean(getMeta('company_email')) ?></a></p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6">
                <h3 class="mb-4">Bize Mesaj Gönderin</h3>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="contact-form">
                    <div class="mb-3">
                        <label class="form-label">Adınız Soyadınız *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">E-posta *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Telefon</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konu *</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mesajınız *</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane"></i> Gönder
                    </button>
                </form>
            </div>
            <div class="col-lg-6">
                <h3 class="mb-4">Çalışma Saatlerimiz</h3>
                <div class="working-hours">
                    <p><strong>Pazartesi - Cumartesi:</strong> 08:00 - 18:00</p>
                    <p><strong>Pazar:</strong> Kapalı</p>
                    <p class="mt-4"><i class="fas fa-info-circle"></i> Acil durumlar için 7/24 hizmet vermekteyiz.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
