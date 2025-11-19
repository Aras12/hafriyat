/**
 * KAYSERİ EMİR HAFRİYAT - MAIN.JS
 * Modern & Professional JavaScript
 */

// Smooth Scroll for Navigation Links
document.addEventListener('DOMContentLoaded', function() {

    // Navbar Active Link
    const currentLocation = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentLocation) {
            link.classList.add('active');
        }
    });

    // Lazy Loading for Images
    const lazyImages = document.querySelectorAll('img.lazy-load');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    img.classList.remove('lazy-load');
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.classList.add('loaded');
        });
    }

    // Fade-in Animation on Scroll
    const fadeElements = document.querySelectorAll('.fade-in-up');

    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    fadeElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        fadeObserver.observe(el);
    });

    // Contact Form Validation & Submission
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();

            if (!name || !phone || !message) {
                alert('Lütfen tüm gerekli alanları doldurun.');
                return;
            }

            // Email validation
            if (email && !validateEmail(email)) {
                alert('Lütfen geçerli bir e-posta adresi girin.');
                return;
            }

            // Phone validation (Turkish format)
            if (!validatePhone(phone)) {
                alert('Lütfen geçerli bir telefon numarası girin. (Örn: 0531 702 35 38)');
                return;
            }

            // Create WhatsApp message
            const whatsappMessage = `Merhaba, web sitesinden mesaj gönderiyorum.\n\n` +
                                  `Ad: ${name}\n` +
                                  `Telefon: ${phone}\n` +
                                  (email ? `E-posta: ${email}\n` : '') +
                                  `Mesaj: ${message}`;

            const encodedMessage = encodeURIComponent(whatsappMessage);
            const whatsappUrl = `https://wa.me/905317023538?text=${encodedMessage}`;

            window.open(whatsappUrl, '_blank');

            // Reset form
            contactForm.reset();
        });
    }

    // Gallery Modal (if needed)
    const galleryImages = document.querySelectorAll('.gallery-item img');
    galleryImages.forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            // Simple lightbox effect
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.9);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            `;

            const largeImg = document.createElement('img');
            largeImg.src = this.src;
            largeImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                border-radius: 10px;
                box-shadow: 0 0 30px rgba(255,193,7,0.5);
            `;

            overlay.appendChild(largeImg);
            document.body.appendChild(overlay);

            overlay.addEventListener('click', function() {
                document.body.removeChild(overlay);
            });
        });
    });

    // Navbar scroll effect
    let lastScroll = 0;
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 100) {
            navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
        } else {
            navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        }

        lastScroll = currentScroll;
    });

    // Counter Animation for About Page
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        // Start animation when element is visible
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counterObserver.observe(counter);
    });

});

// Email Validation Function
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Phone Validation Function (Turkish Format)
function validatePhone(phone) {
    // Remove spaces and special characters
    const cleaned = phone.replace(/[\s\-\(\)]/g, '');
    // Check if it's 11 digits starting with 0, or 10 digits
    return /^0[0-9]{10}$/.test(cleaned) || /^[0-9]{10}$/.test(cleaned);
}

// Scroll to Top Button (Optional)
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Phone Call Analytics (Optional)
function trackPhoneClick() {
    if (typeof gtag !== 'undefined') {
        gtag('event', 'phone_call', {
            'event_category': 'contact',
            'event_label': 'Phone Click'
        });
    }
}

// WhatsApp Analytics (Optional)
function trackWhatsAppClick() {
    if (typeof gtag !== 'undefined') {
        gtag('event', 'whatsapp_click', {
            'event_category': 'contact',
            'event_label': 'WhatsApp Click'
        });
    }
}

// Auto-close Bootstrap alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        if (alert.classList.contains('alert-dismissible')) {
            const closeButton = alert.querySelector('.btn-close');
            if (closeButton) closeButton.click();
        }
    });
}, 5000);

// Prevent form double submission
let formSubmitted = false;
document.addEventListener('submit', function(e) {
    if (formSubmitted) {
        e.preventDefault();
        return false;
    }
    formSubmitted = true;
    setTimeout(() => { formSubmitted = false; }, 3000);
});
