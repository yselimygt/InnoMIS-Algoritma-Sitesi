# InnoMIS Algoritma Platformu

InnoMIS Algoritma Platformu, öğrencilerin algoritma becerilerini geliştirmeleri, yarışmalara katılmaları ve birbirleriyle etkileşimde bulunmaları için tasarlanmış modern bir web uygulamasıdır.

## Özellikler

- **Problem Çözme:** Çeşitli zorluk seviyelerinde algoritma problemleri.
- **Sıralama ve Rozetler:** Kullanıcıların başarılarına göre sıralandığı ve rozet kazandığı oyunlaştırma sistemi.
- **Turnuvalar:** Belirli zaman aralıklarında düzenlenen kodlama yarışmaları.
- **Takımlar:** Kullanıcıların takım oluşturup birlikte yarışabildiği sistem.
- **Öğrenme Yolları:** Belirli konularda adım adım ilerleyen eğitim modülleri.
- **Forum (Yakında):** Kullanıcıların tartışabileceği topluluk alanı.

## Kurulum

1.  Bu projeyi yerel sunucunuza (XAMPP, WAMP, vb.) klonlayın.
2.  Veritabanını oluşturun: `innomis_algo`
3.  `database.sql` dosyasını içe aktarın.
4.  `config/config.php` dosyasındaki veritabanı ayarlarını kendi ortamınıza göre düzenleyin.
5.  `public_html` klasörünü web sunucunuzun kök dizini olarak ayarlayın veya tarayıcıdan `http://localhost/InnoMIS-Algoritma-Sitesi/public_html` adresine gidin.

## Yönetici Hesabı

Varsayılan yönetici hesabı:
- **E-posta:** admin@admin.com
- **Şifre:** admin12345

## Teknoloji Yığını

- **Backend:** PHP (MVC Yapısı)
- **Veritabanı:** MySQL
- **Frontend:** HTML, CSS, JavaScript

## Ek Tablolar

- **user_follows:** Kullanıcıların takip ettiği kullanıcılar ve takip edilen zaman.
  - `id`: Tablonun anahtar numarası.
  - `follower_id`: Takip eden kullanıcı ID'si.
  - `followee_id`: Takip edilen kullanıcı ID'si.
  - `created_at`: Takip edilme zamanı.
  - **Kısıtlar:**
    - `uniq_follow_pair`: `follower_id` ve `followee_id`'nin benzersiz olması.
    - `followee_id`: `followee_id`'nin `users` tablosuna ait olması.
  - **İlişkiler:**
    - `fk_user_follows_follower`: `follower_id`'nin `users` tablosuna ait olması.
    - `fk_user_follows_followee`: `followee_id`'nin `users` tablosuna ait olması.
