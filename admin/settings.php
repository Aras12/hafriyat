<?php
require_once '../config.php';
requireAdmin();
$db = Database::getInstance();

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

$pageTitle = 'Site Ayarları';
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cog"></i> Site Ayarları
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">

                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#genel">Genel Ayarlar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#iletisim">İletişim Bilgileri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#nedenbiz">Neden Biz?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#seo">SEO Ayarları</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#smtp">SMTP Ayarları</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Genel Ayarlar -->
                        <div class="tab-pane fade show active" id="genel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Site Başlığı</label>
                                        <input type="text" name="setting[site_title]" class="form-control" value="<?= clean($settings['site_title'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Firma Tecrübesi (Yıl)</label>
                                        <input type="number" name="setting[company_experience]" class="form-control" value="<?= clean($settings['company_experience'] ?? '25') ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Site Logosu</label>
                                        <input type="file" name="logo" class="form-control" accept="image/*">
                                        <?php if (!empty($settings['site_logo']) && strpos($settings['site_logo'], 'data:image') === false): ?>
                                            <img src="<?= siteUrl($settings['site_logo']) ?>" alt="Logo" class="mt-2" style="max-height: 80px;">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Favicon</label>
                                        <input type="file" name="favicon" class="form-control" accept="image/*">
                                        <small class="text-muted">Tarayıcı sekmesinde görünen ikon (16x16px veya 32x32px)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- İletişim Bilgileri -->
                        <div class="tab-pane fade" id="iletisim">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Telefon</label>
                                        <input type="text" name="setting[company_phone]" class="form-control" value="<?= clean($settings['company_phone'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">E-posta</label>
                                        <input type="email" name="setting[company_email]" class="form-control" value="<?= clean($settings['company_email'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Adres</label>
                                <textarea name="setting[company_address]" class="form-control" rows="3"><?= clean($settings['company_address'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Neden Biz? -->
                        <div class="tab-pane fade" id="nedenbiz">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Anasayfa slider altında görünen "Neden Biz?" bölümünü buradan düzenleyebilirsiniz.
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Bölüm Aktif Mi?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="setting[why_us_enabled]" value="1" <?= ($settings['why_us_enabled'] ?? '1') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label">Aktif</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Başlık</label>
                                        <input type="text" name="setting[why_us_title]" class="form-control" value="<?= clean($settings['why_us_title'] ?? 'Neden Kayseri Emir Hafriyat?') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Alt Başlık</label>
                                        <input type="text" name="setting[why_us_subtitle]" class="form-control" value="<?= clean($settings['why_us_subtitle'] ?? 'Güvenilir, Hızlı ve Profesyonel Hizmet Anlayışı') ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h6 class="mb-3"><i class="fas fa-star"></i> Kart 1</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">İkon (Font Awesome)</label>
                                        <input type="text" name="setting[why_card1_icon]" class="form-control" value="<?= clean($settings['why_card1_icon'] ?? 'fas fa-award') ?>" placeholder="fas fa-award">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Başlık</label>
                                        <input type="text" name="setting[why_card1_title]" class="form-control" value="<?= clean($settings['why_card1_title'] ?? '25 Yıl Tecrübe') ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Açıklama</label>
                                        <input type="text" name="setting[why_card1_text]" class="form-control" value="<?= clean($settings['why_card1_text'] ?? 'Çeyrek asırlık deneyimimizle sektörde öncüyüz') ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h6 class="mb-3"><i class="fas fa-star"></i> Kart 2</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">İkon (Font Awesome)</label>
                                        <input type="text" name="setting[why_card2_icon]" class="form-control" value="<?= clean($settings['why_card2_icon'] ?? 'fas fa-clock') ?>" placeholder="fas fa-clock">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Başlık</label>
                                        <input type="text" name="setting[why_card2_title]" class="form-control" value="<?= clean($settings['why_card2_title'] ?? 'Zamanında Teslimat') ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Açıklama</label>
                                        <input type="text" name="setting[why_card2_text]" class="form-control" value="<?= clean($settings['why_card2_text'] ?? 'Projelerinizi zamanında başlatır ve teslim ederiz') ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h6 class="mb-3"><i class="fas fa-star"></i> Kart 3</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">İkon (Font Awesome)</label>
                                        <input type="text" name="setting[why_card3_icon]" class="form-control" value="<?= clean($settings['why_card3_icon'] ?? 'fas fa-tools') ?>" placeholder="fas fa-tools">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Başlık</label>
                                        <input type="text" name="setting[why_card3_title]" class="form-control" value="<?= clean($settings['why_card3_title'] ?? 'Modern Ekipman') ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Açıklama</label>
                                        <input type="text" name="setting[why_card3_text]" class="form-control" value="<?= clean($settings['why_card3_text'] ?? 'En son teknoloji iş makineleri ve ekipmanlar') ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h6 class="mb-3"><i class="fas fa-star"></i> Kart 4</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">İkon (Font Awesome)</label>
                                        <input type="text" name="setting[why_card4_icon]" class="form-control" value="<?= clean($settings['why_card4_icon'] ?? 'fas fa-users') ?>" placeholder="fas fa-users">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Başlık</label>
                                        <input type="text" name="setting[why_card4_title]" class="form-control" value="<?= clean($settings['why_card4_title'] ?? 'Uzman Kadro') ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Açıklama</label>
                                        <input type="text" name="setting[why_card4_text]" class="form-control" value="<?= clean($settings['why_card4_text'] ?? 'Deneyimli operatörler ve profesyonel ekip') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Ayarları -->
                        <div class="tab-pane fade" id="seo">
                            <div class="mb-3">
                                <label class="form-label">Ana Sayfa Meta Başlık</label>
                                <input type="text" name="setting[meta_home_title]" class="form-control" value="<?= clean($settings['meta_home_title'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ana Sayfa Meta Açıklama</label>
                                <textarea name="setting[meta_home_description]" class="form-control" rows="3"><?= clean($settings['meta_home_description'] ?? '') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ana Sayfa Meta Anahtar Kelimeler</label>
                                <textarea name="setting[meta_home_keywords]" class="form-control" rows="2"><?= clean($settings['meta_home_keywords'] ?? '') ?></textarea>
                                <small class="text-muted">Virgülle ayırarak yazın</small>
                            </div>
                        </div>

                        <!-- SMTP Ayarları -->
                        <div class="tab-pane fade" id="smtp">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Host</label>
                                        <input type="text" name="setting[smtp_host]" class="form-control" value="<?= clean($settings['smtp_host'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Port</label>
                                        <input type="number" name="setting[smtp_port]" class="form-control" value="<?= clean($settings['smtp_port'] ?? '587') ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Kullanıcı Adı</label>
                                        <input type="text" name="setting[smtp_username]" class="form-control" value="<?= clean($settings['smtp_username'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Şifre</label>
                                        <input type="password" name="setting[smtp_password]" class="form-control" value="<?= clean($settings['smtp_password'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">SMTP Şifreleme</label>
                                <select name="setting[smtp_encryption]" class="form-control">
                                    <option value="tls" <?= ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' ?>>TLS</option>
                                    <option value="ssl" <?= ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Ayarları Kaydet
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
