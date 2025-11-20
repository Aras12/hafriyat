    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-truck-monster"></i> <?= getMeta('site_title', 'Emir Hafriyat') ?></h5>
                    <p><?= getMeta('company_experience', '25') ?> yıllık tecrübemizle Kayseri ve çevresinde profesyonel hafriyat ve iş makinesi kiralama hizmetleri sunuyoruz.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5><i class="fas fa-link"></i> Hızlı Linkler</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="<?= siteUrl() ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                        <li><a href="<?= siteUrl('hakkimizda') ?>"><i class="fas fa-info-circle"></i> Hakkımızda</a></li>
                        <li><a href="<?= siteUrl('hizmetler') ?>"><i class="fas fa-cogs"></i> Hizmetlerimiz</a></li>
                        <li><a href="<?= siteUrl('galeri') ?>"><i class="fas fa-images"></i> Galeri</a></li>
                        <li><a href="<?= siteUrl('projeler') ?>"><i class="fas fa-project-diagram"></i> Projeler</a></li>
                        <li><a href="<?= siteUrl('blog') ?>"><i class="fas fa-blog"></i> Blog</a></li>
                        <li><a href="<?= siteUrl('iletisim') ?>"><i class="fas fa-envelope"></i> İletişim</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5><i class="fas fa-phone"></i> İletişim</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt"></i> <?= nl2br(clean(getMeta('company_address', ''))) ?></li>
                        <li><i class="fas fa-phone"></i> <?= clean(getMeta('company_phone', '')) ?></li>
                        <li><i class="fas fa-envelope"></i> <?= clean(getMeta('company_email', '')) ?></li>
                    </ul>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> <?= clean(getMeta('site_title', 'Emir Hafriyat')) ?>. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>

    <!-- Quick Contact Buttons -->
    <div class="quick-contact">
        <a href="tel:<?= preg_replace('/[^0-9]/', '', getMeta('company_phone', '05317023538')) ?>" class="contact-btn phone">
            <i class="fas fa-phone"></i>
        </a>
        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', getMeta('company_phone', '905317023538')) ?>" target="_blank" class="contact-btn whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= asset('assets/js/main.js') ?>"></script>
</body>
</html>
