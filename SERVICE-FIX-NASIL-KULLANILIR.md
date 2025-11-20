# 🔧 HİZMET İÇERİK SORUNUNU ÇÖZME KILAVUZU

## 🚨 SORUN NEDİR?

Hizmet sayfalarında (örn: Manitou) tıkladığınızda **yanlış içerik** görünüyor:
- URL: `/hizmet/manitou` ✓ Doğru
- Meta bilgiler: "Manitou Kiralama" ✓ Doğru
- Sayfa başlığı: "Taş Duvar" ✗ Yanlış
- Sayfa içeriği: "Taş duvar açıklaması" ✗ Yanlış

**Neden oluyor?** Veritabanında her hizmetin `description` alanı karışmış.

---

## ✅ ÇÖZÜM 1: WEB ARACI (ÖNERİLEN)

### Adım 1: Dosyayı Yükleyin
```bash
# FTP ile fix-service-descriptions.php dosyasını web sitenizin kök dizinine yükleyin
```

### Adım 2: Tarayıcıda Açın
```
https://adanaotokokusu.com.tr/fix-service-descriptions.php
```

### Adım 3: Düzelt Butonuna Tıklayın
1. Sayfada mevcut durumu göreceksiniz (hangi hizmetler yanlış?)
2. **"Hizmetleri Düzelt"** butonuna tıklayın
3. Onaylayın
4. Sonuçları kontrol edin

### Adım 4: Test Edin
```
https://adanaotokokusu.com.tr/hizmet/manitou
https://adanaotokokusu.com.tr/hizmet/tas-duvar
https://adanaotokokusu.com.tr/hizmet/ekskavator
```
Şimdi her hizmet **kendi içeriğini** göstermeli!

### Adım 5: Güvenlik (ÖNEMLİ!)
```bash
# İşlem bitince dosyayı silin:
rm fix-service-descriptions.php
```

---

## ✅ ÇÖZÜM 2: SQL İLE MANUEL (İLERİ SEVİYE)

### Adım 1: phpMyAdmin'e Girin
```
cPanel > phpMyAdmin > emirhafr_kayseriemir veritabanını seçin
```

### Adım 2: SQL Sekmesini Açın

### Adım 3: CHECK-AND-FIX-SERVICES.sql Dosyasını Açın
Dosyayı bir metin editöründe açın ve içindeki SQL komutlarını phpMyAdmin'de çalıştırın.

**İlk önce kontrol edin:**
```sql
SELECT id, slug, title,
       LEFT(meta_description, 60) as meta_desc,
       LEFT(description, 60) as desc_text
FROM services
ORDER BY sort_order ASC;
```

**Sonra düzeltin:**
```sql
-- Her hizmet için UPDATE komutlarını tek tek çalıştırın
UPDATE services SET
    description = '<p>Manitou forklift kiralama hizmeti...</p>',
    meta_description = 'Manitou forklift kiralama...',
    short_description = 'Yükleme ve taşıma hizmetleri',
    features = 'Yüksek kaldırma kapasitesi,Güvenli kullanım...'
WHERE slug = 'manitou';
```

### Adım 4: Tekrar Kontrol Edin
```sql
SELECT id, slug, title,
       LEFT(meta_description, 60) as meta_desc,
       LEFT(description, 60) as desc_text
FROM services
ORDER BY sort_order ASC;
```

---

## ✅ ÇÖZÜM 3: PHP KOMUT SATIRI

### SSH ile sunucuya bağlanın:
```bash
cd /home/emirhafr/public_html

# Kontrol et
php check-services.php

# Düzelt
php update-service-contents.php
```

---

## 📦 ZIP İÇİNDEKİ DOSYALAR

| Dosya | Açıklama | Kullanım |
|-------|----------|----------|
| `fix-service-descriptions.php` | **WEB ARACI** - Tarayıcıda açıp kullanın | ⭐ ÖNERİLEN |
| `CHECK-AND-FIX-SERVICES.sql` | SQL sorguları - phpMyAdmin'de çalıştırın | İleri seviye |
| `check-services.php` | Kontrol aracı - SSH'de çalıştırın | İsteğe bağlı |
| `update-service-contents.php` | Güncelleme aracı - SSH'de çalıştırın | İsteğe bağlı |
| `admin/service_edit.php` | Admin panel düzenleme sayfası | Otomatik |
| `FIX-DATABASE.sql` | Önceki düzeltme SQL'i | Yedek |

---

## 🎯 BEKLENEN SONUÇ

İşlem tamamlandıktan sonra:

✅ **Manitou sayfası** → Manitou içeriği gösterecek
✅ **Taş Duvar sayfası** → Taş duvar içeriği gösterecek
✅ **Ekskavatör sayfası** → Ekskavatör içeriği gösterecek
✅ **Diğer tüm hizmetler** → Kendi içeriklerini gösterecek

---

## ❓ SORUN DEVAM EDİYORSA

1. **Cache temizleyin**: Tarayıcı cache'ini temizleyin (Ctrl+F5)
2. **CDN cache**: Eğer Cloudflare kullanıyorsanız cache'i temizleyin
3. **PHP cache**: cPanel > Select PHP Version > Extensions > OPcache'i resetleyin
4. **Dosyaları kontrol edin**: `hizmet-single.php` dosyasının güncel olduğundan emin olun

---

## 🆘 DESTEK

Sorun devam ederse:
1. `fix-service-descriptions.php` çıktısının ekran görüntüsünü alın
2. Hangi hizmette sorun olduğunu belirtin
3. Hata mesajlarını kaydedin

---

**Son güncelleme:** 20 Kasım 2025
**Versiyon:** 1.0
**Hazırlayan:** Claude AI - Kayseri Emir Hafriyat Web Geliştirme
