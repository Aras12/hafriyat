<?php
$pageTitle = 'Ana Sayfa';
$pageMetaTitle = getMeta('meta_home_title', 'Kayseri Emir Hafriyat');
$pageMetaDesc = getMeta('meta_home_description', '');
$pageMetaKeywords = getMeta('meta_home_keywords', '');
$pageUrl = siteUrl();

// Verileri çek
$sliders = $db->fetchAll("SELECT * FROM sliders WHERE status = 1 ORDER BY sort_order ASC");
$tabs = $db->fetchAll("SELECT * FROM service_tabs WHERE status = 1 ORDER BY sort_order ASC");
$allServices = $db->fetchAll("SELECT * FROM services WHERE status = 1 ORDER BY sort_order ASC");
$faqs = $db->fetchAll("SELECT * FROM faqs WHERE status = 1 ORDER BY sort_order ASC");
$testimonials = $db->fetchAll("SELECT * FROM testimonials WHERE status = 1 ORDER BY sort_order ASC LIMIT 3");
$blogPosts = $db->fetchAll("SELECT * FROM blog WHERE status = 1 ORDER BY created_at DESC LIMIT 4");

include 'includes/header.php';
?>

<!-- Hero Slider -->
<div id="heroSlider" class="carousel slide hero-slider" data-bs-ride="carousel">
    <?php if(count($sliders) > 1): ?>
        <div class="carousel-indicators">
            <?php foreach($sliders as $index => $slider): ?>
                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active"' : '' ?>></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="carousel-inner">
        <?php foreach($sliders as $index => $slider): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="<?= asset($slider['image']) ?>" class="d-block w-100" alt="<?= clean($slider['title']) ?>">
                <div class="carousel-caption">
                    <h1 class="fade-in-up"><?= clean($slider['title']) ?></h1>
                    <p class="fade-in-up"><?= clean($slider['description']) ?></p>
                    <?php if($slider['button_text'] && $slider['button_link']): ?>
                        <a href="<?= siteUrl($slider['button_link']) ?>" class="btn btn-warning btn-lg mt-3"><?= clean($slider['button_text']) ?></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if(count($sliders) > 1): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    <?php endif; ?>
</div>

<!-- Hizmetlerimiz Tabs -->
<section class="services-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2><i class="fas fa-cogs"></i> Hizmetlerimiz</h2>
            <p class="lead">Profesyonel hafriyat ve iş makinesi kiralama hizmetleri</p>
        </div>

        <ul class="nav nav-pills justify-content-center mb-4" id="serviceTabs" role="tablist">
            <?php foreach($tabs as $index => $tab): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= $tab['tab_key'] ?>" data-bs-toggle="pill" data-bs-target="#<?= $tab['tab_key'] ?>" type="button">
                        <i class="<?= $tab['icon'] ?>"></i> <?= clean($tab['tab_name']) ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content" id="serviceTabsContent">
            <?php foreach($tabs as $index => $tab): ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="<?= $tab['tab_key'] ?>" role="tabpanel">
                    <div class="row g-4">
                        <?php
                        $tabServices = array_filter($allServices, function($s) use ($tab) {
                            return $s['tab_category'] === $tab['tab_key'];
                        });
                        foreach($tabServices as $service):
                        ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="service-card">
                                    <?php if($service['image']): ?>
                                        <img src="<?= asset($service['image']) ?>" alt="<?= clean($service['title']) ?>">
                                    <?php endif; ?>
                                    <div class="service-card-body">
                                        <i class="<?= $service['icon'] ?> service-icon"></i>
                                        <h5><?= clean($service['title']) ?></h5>
                                        <p><?= clean($service['short_description']) ?></p>
                                        <a href="<?= siteUrl('hizmet/' . $service['slug']) ?>" class="btn btn-outline-primary btn-sm">Detaylı Bilgi</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- SSS -->
<section class="faq-section py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2><i class="fas fa-question-circle"></i> Sıkça Sorulan Sorular</h2>
            <p class="lead">Merak ettikleriniz</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <?php foreach($faqs as $index => $faq): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq<?= $faq['id'] ?>">
                                <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?= $faq['id'] ?>">
                                    <?= clean($faq['question']) ?>
                                </button>
                            </h2>
                            <div id="faqCollapse<?= $faq['id'] ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <?= clean($faq['answer']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Müşteri Yorumları -->
<section class="testimonials-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2><i class="fas fa-comments"></i> Müşteri Yorumları</h2>
            <p class="lead">Müşterilerimizin bize güveni</p>
        </div>
        <div class="row g-4">
            <?php foreach($testimonials as $testimonial): ?>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="stars mb-3">
                            <?php for($i=0; $i<$testimonial['rating']; $i++): ?>
                                <i class="fas fa-star text-warning"></i>
                            <?php endfor; ?>
                        </div>
                        <p>"<?= clean($testimonial['comment']) ?>"</p>
                        <div class="client-info">
                            <h6><?= clean($testimonial['client_name']) ?></h6>
                            <?php if($testimonial['client_company']): ?>
                                <small class="text-muted"><?= clean($testimonial['client_company']) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Blog -->
<section class="blog-section py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2><i class="fas fa-blog"></i> Blog Yazılarımız</h2>
            <p class="lead">Hafriyat ve inşaat sektörü hakkında güncel bilgiler</p>
        </div>
        <div class="row g-4">
            <?php foreach($blogPosts as $post): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="blog-card">
                        <?php if($post['featured_image']): ?>
                            <img src="<?= asset($post['featured_image']) ?>" alt="<?= clean($post['title']) ?>">
                        <?php endif; ?>
                        <div class="blog-card-body">
                            <span class="badge bg-warning text-dark mb-2"><?= clean($post['category']) ?></span>
                            <h5><?= clean($post['title']) ?></h5>
                            <p><?= excerpt(clean($post['excerpt']), 100) ?></p>
                            <div class="blog-meta">
                                <small><i class="fas fa-calendar"></i> <?= formatDate($post['created_at'], 'd.m.Y') ?></small>
                                <small><i class="fas fa-eye"></i> <?= $post['views'] ?></small>
                            </div>
                            <a href="<?= siteUrl('blog/' . $post['slug']) ?>" class="btn btn-outline-primary btn-sm mt-3">Devamını Oku</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= siteUrl('blog') ?>" class="btn btn-primary">Tüm Yazıları Gör</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
