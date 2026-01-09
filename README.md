# Membership API Documentation

## Proje Hakkında
Bu proje, Laravel 11 kullanılarak geliştirilmiş basit bir üyelik yönetim API'sidir. Kullanıcıları kaydetme, listeleme, güncelleme ve silme (soft delete) işlemlerini destekler.

## Gereksinimler
- PHP 8.2+
- Composer
- MySQL / MariaDB (veya SQLite)

## Kurulum

1.  Repoyu klonlayın:
    ```bash
    git clone <repo-url>
    cd membership
    ```

2.  Bağımlılıkları yükleyin:
    ```bash
    composer install
    ```

3.  Çevre dosyasını ayarlayın:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    `.env` dosyasındaki veritabanı ayarlarını yapılandırın.

4.  Veritabanı tablolarını oluşturun:
    ```bash
    php artisan migrate
    ```

## API Kullanımı

API, `api/v1` önekiyle çalışır. Authorization gerektirmez (Public API).

### 1. Kullanıcı Listeleme
Kayıtlı kullanıcıları listeler. Filtreleme seçenekleri mevcuttur.

*   **URL:** `/api/v1/users`
*   **Method:** `GET`
*   **Parametreler (Query String):**
    *   `first_name`: İsim filtresi
    *   `email`: Email filtresi
    *   `phone`: Telefon filtresi
    *   `firm_name`: Firma adı filtresi (user tablosunda firm_id tutulur, fakat firma adına göre arama yapılabilir)

### 2. Kullanıcı Oluşturma
Yeni bir kullanıcı ve (eğer yoksa) firmasını kaydeder.

*   **URL:** `/api/v1/users`
*   **Method:** `POST`
*   **Body (JSON):**
    ```json
    {
      "first_name": "Ahmet",
      "last_name": "Yılmaz",
      "email": "ahmet@example.com",
      "phone": "5551112233",
      "firm_name": "Acme Corp"
    }
    ```
*   **Not:** `firm_name` gönderildiğinde, sistemde bu isimde firma varsa o firmaya eklenir, yoksa yeni firma oluşturulur.

### 3. Kullanıcı Güncelleme
Mevcut kullanıcı bilgilerini günceller.

*   **URL:** `/api/v1/users/{id}`
*   **Method:** `PUT`
*   **Body (JSON):**
    ```json
    {
      "first_name": "Mehmet",
      "email": "mehmet@example.com"
      // İsteğe bağlı diğer alanlar
    }
    ```

### 4. Kullanıcı Silme
Kullanıcıyı sistemden siler (Soft Delete).

*   **URL:** `/api/v1/users/{id}`
*   **Method:** `DELETE`

## Veritabanı Yapısı
Proje ile birlikte verilen `database.sql` dosyası veritabanı şemasını içerir.
- `users`: Kullanıcı bilgileri
- `firms`: Firma bilgileri
*Relation:* Bir firma birden fazla kullanıcıya sahip olabilir (One-to-Many).

## 🧪 Postman Collection

API'yi test etmek için `docs/membership_api.postman_collection.json` dosyasını Postman'e import edebilirsiniz. Collection'da 5 hazır request bulunmaktadır:

1. **create-user** - Kullanıcı oluşturma
2. **list-users** - Kullanıcıları listeleme
3. **get-user** - Tek kullanıcı detayı
4. **update-user** - Kullanıcı güncelleme
5. **delete-user** - Kullanıcı silme (soft delete)

## 📸 Ekran Görüntüleri

Projenin çalışır durumunu gösteren ekran görüntüleri `docs/screenshots/` klasöründedir:

- API Request/Response ekranları
- Veritabanı tablo yapısı
- Postman Collection görüntüsü



## 📁 Proje Yapısı
```
membership/
├── app/
│   ├── Http/Controllers/Api/UserController.php
│   ├── Models/User.php
│   ├── Models/Firm.php
│   ├── Services/UserService.php
│   └── Repositories/UserRepository.php
├── database/
│   ├── migrations/      # Tablo yapıları
│   ├── database.sql     # Hazır SQL dump
│   └── seeders/
├── docs/
│   ├── membership_api.postman_collection.json # Postman Collection
│   └── screenshots/     # Ekran görüntüleri
├── routes/
│   └── api.php          # API route'ları
├── .env.example         # Örnek çevre dosyası
└── README.md
```
