<div align="center">

# TryHackUs CTF

**Kasıtlı zafiyetler içeren PHP + MySQL + Apache CTF laboratuvarı**

Siberpunk görselli, hikâye odaklı, Türkçe arayüzlü ve eğitim/lab ortamları için tasarlanmış bir çalışma.

<p>
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img alt="MySQL" src="https://img.shields.io/badge/MySQL%20%2F%20MariaDB-Gerekli-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img alt="Apache" src="https://img.shields.io/badge/Apache-mod__rewrite%20%2B%20.htaccess-D22128?style=for-the-badge&logo=apache&logoColor=white">
  <img alt="Amaç" src="https://img.shields.io/badge/Amaç-Sadece%20Eğitim-111111?style=for-the-badge">
</p>

</div>

---

## Genel Bakış

TryHackUs CTF, **bilinçli olarak zafiyet bırakılmış challenge yüzeyleri** etrafında tasarlanmış klasik bir LAMP tarzı eğitim laboratuvarıdır.  
Proje şu yapıyı kullanır:

- **Vanilla PHP**
- **MySQL / MariaDB**
- **Apache + mod_rewrite + .htaccess**
- **Türkçe arayüz metinleri**
- **İngilizce challenge ipuçları ve teknik yönlendirmeler**

Şunlar için uygundur:

- yerel lab kurulumları
- özel eğitim ortamları
- demo makineleri / workshop egzersizleri
- self-hosted CTF pratiği

**İnternete açık production yayını** için tasarlanmamıştır.

---

## Özellikler

- Hikâye odaklı underground portal teması
- Cyberpunk / terminal esintili arayüz
- 20 challenge flag
- Easy → insane zorluk ilerleyişi
- Bilinçli olarak zafiyetli authentication, dosya işlemleri, API ve admin akışları
- Türkçe hikâye/metin yapısı, İngilizce teknik hintler
- Genişletmesi ve özelleştirmesi kolay sade proje yapısı

---

## Teknoloji Yığını

- **PHP 8.1+**
- **MySQL / MariaDB**
- **Apache**
- **mod_rewrite**
- **.htaccess desteği**

---

## Proje Yapısı

```text
.
├── admin/          # Admin paneli, loglar ve yönetim yüzeyleri
├── api/            # Challenge'larda kullanılan API endpoint'leri
├── c2/             # Gizli / chained attack yüzeyleri
├── db/             # Veritabanı başlangıç SQL'i
├── includes/       # Ortak config, auth, db ve helper mantığı
├── static/         # CSS / JS dosyaları
├── uploads/        # Yazılabilir upload hedefi
├── *.php           # Ana uygulama sayfaları
├── robots.txt
└── README.md
```

---

## Gereksinimler

Başlamadan önce şunların hazır olduğundan emin ol:

- PHP **8.1+**
- Apache:
  - `mod_rewrite` açık olmalı
  - `.htaccess` desteği açık olmalı
- MySQL veya MariaDB
- Yazılabilir `uploads/` klasörü

Önerilen ortam:

- Ubuntu / Debian
- Apache 2.4+
- MariaDB 10.x+

---

## Hızlı Kurulum

### 1) Projeyi Apache document root altına kopyala

Örnek:

```bash
sudo cp -r THUctf /var/www/html/
```

Ya da proje dizinine işaret eden ayrı bir virtual host tanımla.

### 2) Veritabanı config dosyasını düzenle

Düzenlenecek dosya:

```bash
includes/config.php
```

Kendi ortamına göre şunları ayarla:

- host / port veya socket
- veritabanı adı
- kullanıcı adı / şifre
- gerekirse base URL

### 3) Veritabanını import et

```bash
mysql -u root -p < db/setup.sql
```

### 4) uploads klasörünün yazılabilir olduğundan emin ol

```bash
chmod -R 775 uploads
```

### 5) Apache rewrite desteğini aç

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 6) Laboratuvarı aç

```text
http://localhost/THUctf
```

veya tanımladığın vhost URL’si üzerinden eriş.

---

## Challenge Haritası

| ID | Challenge | Zafiyet |
|---:|---|---|
| 01 | Robots | Bilgi sızması |
| 02 | Source Code | Kaynak kod sızması |
| 03 | Cookie Monster | Cookie içinde hassas veri |
| 04 | Reflected XSS | Reflected XSS |
| 05 | Directory Listing | Dizin listeleme |
| 06 | HTTP Header | Header içinde hassas veri |
| 07 | SQL Injection (Login) | Auth bypass |
| 08 | IDOR | Broken object-level authorization |
| 09 | Stored XSS | Kalıcı XSS |
| 10 | Path Traversal | Yetkisiz dosya okuma |
| 11 | File Upload | Sınırsız / hatalı dosya upload |
| 12 | JWT None Algorithm | JWT yanlış yapılandırması |
| 13 | SQL Injection (UNION) | UNION tabanlı SQLi |
| 14 | Broken Access Control | Admin API açığı |
| 15 | Log Injection + Path Traversal | LFI / log poisoning |
| 16 | SSRF | Server-side request forgery |
| 17 | XXE | XML external entity injection |
| 18 | Mass Assignment | Yetki yükseltme |
| 19 | Chained Access | Çok adımlı exploit zinciri |
| 20 | Timing + Extension | Timing leak + hash suistimali |

---

## Gerçekçi Davranış İçin Notlar

Bazı challenge’lar klasik Apache / LAMP davranışına dayanır. En sağlıklı sonuç için:

- PHP built-in server yerine **Apache** tercih et
- `.htaccess` aktif olsun
- gerçek bir MySQL / MariaDB instance kullan
- gerekli yerlerde upload klasörü yazılabilir olsun
- encoded-path davranışları test edilecekse Apache tarafında aşağıdaki gibi uyumlu ayar kullan:

```apache
AllowEncodedSlashes NoDecode
```

---

## Güvenlik Uyarısı

Bu repository, **eğitim amacıyla kasıtlı olarak bırakılmış zafiyetler** içerir.

Sadece şu ortamlarda kullan:

- yerel sistemler
- izole lab ortamları
- özel CTF / eğitim altyapıları

Ne yaptığını tam bilmiyorsan bunu doğrudan internete açık şekilde yayınlama.

---

## Özelleştirme Fikirleri

- Yeni flag ve hikâye zincirleri ekle
- Arayüz metinlerini başka bir dile çevir
- Admin / API / C2 rotalarını genişlet
- Docker desteği ekle
- Demo kullanıcılar veya reset scriptleri ekle
- Writeup destekli workshop paketine dönüştür

---

## GitHub İçin Önerilen Ekler

Bu repo’yu daha profesyonel hale getirmek istersen şunları da ekleyebilirsin:

- `LICENSE`
- `Dockerfile`
- `docker-compose.yml`
- `start.sh`
- ekran görüntüleri / GIF demo
- kurulum walkthrough

---

## Sorumluluk Reddi

Bu proje **yalnızca eğitim ve laboratuvar kullanımı** içindir.

İçerdiği zafiyetler bilinçli olarak bırakılmıştır.
Bunu public production uygulaması gibi dağıtma veya kullanma.
