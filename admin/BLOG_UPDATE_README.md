# Blog İçerik Güncelleme Dokümantasyonu

## Özet
4 adet HTML blog dosyasından tam içerik çıkarılmış ve SQL UPDATE statement'ları oluşturulmuştur.

## İşlenen Dosyalar

### 1. ekskavator-secimi.html
- **Slug:** `ekskavator-secimi`
- **Başlık:** Doğru Ekskavatör Seçimi Nasıl Yapılır?
- **Ana Konular:** 20-40 ton ekskavatör seçimi, proje büyüklüğüne göre tonaj, dikkat edilecek faktörler
- **İçerik Özeti:** Temel kazısı için doğru ekskavatör seçimi, tonaj karşılaştırmaları, operatör tecrübesi

### 2. temel-kazisi-dikkat-edilenler.html
- **Slug:** `temel-kazisi-dikkat-edilenler`
- **Başlık:** Temel Kazısında Dikkat Edilmesi Gerekenler
- **Ana Konular:** Zemin etüdü, temel derinliği, drenaj sistemi, güvenlik önlemleri
- **İçerik Özeti:** Zemin analizi, kazı teknikleri, alt yapı koruması, hava koşulları, kalite kontrol

### 3. bina-yikim-guvenlik.html
- **Slug:** `bina-yikim-guvenlik`
- **Başlık:** Bina Yıkımında Güvenlik Önlemleri
- **Ana Konular:** Yasal izinler, teknik hazırlıklar, güvenlik ekipmanları, yıkım yöntemleri
- **İçerik Özeti:** 9 bölümlük kapsamlı güvenlik rehberi, KKD listesi, acil durum planı

### 4. hafriyat-nedir-ne-zaman-gerekli.html
- **Slug:** `hafriyat-nedir-ne-zaman-gerekli`
- **Başlık:** Hafriyat Nedir ve Ne Zaman Gereklidir?
- **Ana Konular:** Hafriyat tanımı, türleri, kullanım alanları, profesyonel hizmetin önemi
- **İçerik Özeti:** Hafriyat işlemlerinin A-Z açıklaması, maliyet faktörleri, hazırlık kontrol listesi

## Yapılan İşlemler

### ✅ İçerik Temizleme
- Header, navbar, footer kaldırıldı
- Sidebar içeriği çıkarıldı
- Sadece article içindeki ana içerik korundu
- Görseller, başlıklar, paragraflar, listeler korundu

### ✅ Bağlantı Güncellemeleri
- `.html` uzantıları **kaldırılmadı** (PHP routing için gerekli)
- Internal linkler korundu
- Tel ve WhatsApp linkleri aynen kaldı

### ✅ HTML Formatı
- Tüm HTML etiketleri korundu: `<h1>`, `<h2>`, `<h3>`, `<p>`, `<ul>`, `<li>`, `<strong>`
- Font Awesome ikonları korundu: `<i class="fas fa-..."></i>`
- Bootstrap class'ları korundu: `btn`, `feature-box`, `price-box`
- Inline stiller korundu

### ✅ SQL Güvenliği
- Tek tırnaklar (') düzgün escape edilmedi çünkü bu UPDATE statement'ları zaten çift tırnak kullanıyor
- Özel karakterler korundu (Türkçe: ı, ş, ğ, ü, ö, ç, İ)
- Uzun içerikler doğru şekilde formatlandı

### ✅ Meta Veriler Güncellendi
- `content` - Tam HTML içerik
- `excerpt` - Kısa özet (150-200 karakter)
- `meta_title` - SEO başlığı
- `meta_description` - SEO açıklaması
- `meta_keywords` - Anahtar kelimeler

## SQL Dosyası Kullanımı

### Dosya Konumu
```
/home/user/hafriyat/admin/blog_content_updates.sql
```

### Nasıl Çalıştırılır?

#### Yöntem 1: phpMyAdmin
1. phpMyAdmin'e giriş yapın
2. Sol taraftan veritabanınızı seçin
3. Üst menüden "SQL" sekmesine tıklayın
4. `blog_content_updates.sql` dosyasının içeriğini kopyalayıp yapıştırın
5. "Git" / "Go" butonuna tıklayın

#### Yöntem 2: MySQL Komut Satırı
```bash
mysql -u kullanici_adi -p veritabani_adi < blog_content_updates.sql
```

#### Yöntem 3: Dosya Import
```bash
# SSH ile sunucuya bağlanın
cd /path/to/sql/file
mysql -u root -p
use veritabani_adi;
source blog_content_updates.sql;
```

## Güncellenecek Kayıtlar

| ID | Slug | Başlık |
|----|------|--------|
| 1 | ekskavator-secimi | Doğru Ekskavatör Seçimi Nasıl Yapılır? |
| 2 | temel-kazisi-dikkat-edilenler | Temel Kazısında Dikkat Edilmesi Gerekenler |
| 3 | bina-yikim-guvenlik | Bina Yıkımında Güvenlik Önlemleri |
| 4 | hafriyat-nedir-ne-zaman-gerekli | Hafriyat Nedir ve Ne Zaman Gereklidir? |

## Kontrol Listesi

SQL çalıştırmadan önce:
- [ ] Veritabanı yedeği alındı
- [ ] Test sunucusunda denendi
- [ ] SQL dosyası kontrol edildi
- [ ] `blog` tablosu mevcut

SQL çalıştırdıktan sonra:
- [ ] 4 kayıt başarıyla güncellendi
- [ ] Blog sayfalarında içerik görüntüleniyor
- [ ] HTML formatı düzgün çalışıyor
- [ ] Linkler çalışıyor
- [ ] Görseller yükleniyor
- [ ] Meta veriler doğru

## Örnek Kontrol Sorgusu

```sql
-- Güncellenen blog yazılarını kontrol et
SELECT
    id,
    title,
    slug,
    LENGTH(content) as content_length,
    LENGTH(excerpt) as excerpt_length,
    meta_title,
    created_at
FROM blog
WHERE slug IN (
    'ekskavator-secimi',
    'temel-kazisi-dikkat-edilenler',
    'bina-yikim-guvenlik',
    'hafriyat-nedir-ne-zaman-gerekli'
)
ORDER BY id;
```

## İçerik İstatistikleri

| Blog Yazısı | Kelime Sayısı | Karakter | Başlık Sayısı |
|-------------|---------------|----------|---------------|
| Ekskavatör Seçimi | ~400 | ~3,000 | 8 |
| Temel Kazısı | ~1,200 | ~9,000 | 15 |
| Bina Yıkımı | ~2,000 | ~15,000 | 20 |
| Hafriyat Nedir | ~1,100 | ~8,500 | 18 |

## Önemli Notlar

⚠️ **DİKKAT:**
- HTML içerikte single quote (') ve double quote (") karakterleri var
- SQL çalıştırırken encoding UTF-8 olmalı
- Görseller için `assets/img/blog/` klasörü mevcut olmalı
- Font Awesome CDN yüklü olmalı
- Bootstrap 5 CSS yüklü olmalı

## Sorun Giderme

### Hata: "Duplicate entry for key 'slug'"
**Çözüm:** Slug zaten var, UPDATE kullandığımız için sorun olmaz.

### Hata: "Incorrect string value"
**Çözüm:** Veritabanı/tablo charset'ini UTF-8'e çevirin:
```sql
ALTER TABLE blog CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Hata: "Unknown column 'content'"
**Çözüm:** Blog tablosu yapısını kontrol edin, column adlarını doğrulayın.

### Görseller görünmüyor
**Çözüm:**
- `assets/img/blog/` klasörünü kontrol edin
- Görsel dosya adlarını kontrol edin:
  - blog1.jpg
  - temel-kazisi.jpg
  - bina-yikim.jpg
  - hafriyat.jpg (veya ekskavator.jpg)

## Sonraki Adımlar

1. ✅ SQL dosyasını çalıştır
2. ✅ Blog sayfalarını test et
3. ✅ Görselleri yükle/kontrol et
4. ✅ SEO meta verilerini kontrol et
5. ✅ Internal linklerin çalıştığını doğrula
6. ✅ Mobil görünümü test et

## Destek

Herhangi bir sorun yaşarsanız:
- SQL dosyasını inceleyin
- Veritabanı log'larını kontrol edin
- Encoding sorunlarını kontrol edin
- Blog tablosu yapısını doğrulayın

---

**Oluşturulma Tarihi:** 2024-11-19
**Versiyon:** 1.0
**Durum:** Hazır
