<?php
$pageTitle = 'Site Ayarları';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = $_POST['setting'] ?? [];

    // Logo yükleme
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $oldLogo = $db->getSetting('site_logo');
        if ($oldLogo && strpos($oldLogo, 'data:image') === false) {
            deleteImage($oldLogo);
        }
        $logoPath = uploadImage($_FILES['logo'], 'logo');
        if ($logoPath) {
            $settings['site_logo'] = $logoPath;
        }
    }

    // Favicon yükleme
    if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
        $faviconPath = uploadImage($_FILES['favicon'], 'favicon');
        if ($faviconPath) {
            $settings['site_favicon'] = $faviconPath;
        }
    }

    // Ayarları kaydet
    foreach ($settings as $key => $value) {
        $db->updateSetting($key, $value);
    }

    setFlash('success', 'Ayarlar başarıyla güncellendi!');
    header('Location: settings.php');
    exit;
}

// Mevcut ayarları çek
$currentSettings = $db->fetchAll("SELECT setting_key, setting_value FROM settings");
$settings = [];
foreach ($currentSettings as $setting) {
    $settings[$setting['setting_key']] = $setting['setting_value'];
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cog"></i> Site Ayarları
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">
                                <i class="fas fa-home"></i> Genel Ayarlar
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact" type="button">
                                <i class="fas fa-phone"></i> İletişim Bilgileri
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#smtp" type="button">
                                <i class="fas fa-envelope"></i> SMTP Ayarları
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo" type="button">
                                <i class="fas fa-search"></i> SEO Ayarları
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-3" id="settingsTabsContent">
                        <!-- Genel Ayarlar -->
                        <div class="tab-pane fade show active" id="general">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Site Başlığı</label>
                                        <input type="text" name="setting[site_title]" class="form-control"
                                               value="<?= clean($settings['site_title'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mevcut Logo</label>
                                        <?php if (isset($settings['site_logo'])): ?>
                                            <div class="mb-2">
                                                <img src="../<?= $settings['site_logo'] ?>" alt="Logo" style="max-width:200px;">
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" name="logo" class="form-control" accept="image/*">
                                        <small class="text-muted">Yeni logo yüklemek için seçin</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Favicon</label>
                                        <input type="file" name="favicon" class="form-control" accept="image/*">
                                        <small class="text-muted">Site simgesi (ICO veya PNG)</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Deneyim Yılı</label>
                                        <input type="number" name="setting[company_experience]" class="form-control"
                                               value="<?= clean($settings['company_experience'] ?? '25') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- İletişim Bilgileri -->
                        <div class="tab-pane fade" id="contact">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Telefon</label>
                                        <input type="text" name="setting[company_phone]" class="form-control"
                                               value="<?= clean($settings['company_phone'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">E-posta</label>
                                        <input type="email" name="setting[company_email]" class="form-control"
                                               value="<?= clean($settings['company_email'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Adres</label>
                                        <textarea name="setting[company_address]" class="form-control" rows="4"><?= clean($settings['company_address'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SMTP Ayarları -->
                        <div class="tab-pane fade" id="smtp">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Host</label>
                                        <input type="text" name="setting[smtp_host]" class="form-control"
                                               value="<?= clean($settings['smtp_host'] ?? '') ?>" placeholder="smtp.gmail.com">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">SMTP Port</label>
                                        <input type="number" name="setting[smtp_port]" class="form-control"
                                               value="<?= clean($settings['smtp_port'] ?? '587') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Şifreleme</label>
                                        <select name="setting[smtp_encryption]" class="form-select">
                                            <option value="tls" <?= ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' ?>>TLS</option>
                                            <option value="ssl" <?= ($settings['smtp_encryption'] ?? 'tls') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Kullanıcı Adı</label>
                                        <input type="text" name="setting[smtp_username]" class="form-control"
                                               value="<?= clean($settings['smtp_username'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">SMTP Şifre</label>
                                        <input type="password" name="setting[smtp_password]" class="form-control"
                                               value="<?= clean($settings['smtp_password'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Ayarları -->
                        <div class="tab-pane fade" id="seo">
                            <div class="mb-3">
                                <label class="form-label">Ana Sayfa Meta Başlık</label>
                                <input type="text" name="setting[meta_home_title]" class="form-control"
                                       value="<?= clean($settings['meta_home_title'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ana Sayfa Meta Açıklama</label>
                                <textarea name="setting[meta_home_description]" class="form-control" rows="3"><?= clean($settings['meta_home_description'] ?? '') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ana Sayfa Meta Kelimeler</label>
                                <input type="text" name="setting[meta_home_keywords]" class="form-control"
                                       value="<?= clean($settings['meta_home_keywords'] ?? '') ?>">
                                <small class="text-muted">Virgülle ayırarak yazın</small>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
