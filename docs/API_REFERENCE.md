# 📚 API Referans Dokümantasyonu

Bu doküman, Membership Platform API'si için kullanılabilir uç noktaları (endpoints), parametreleri ve örnek yanıtları içerir.

**Base URL:** `http://localhost:8000/api/v1`
**İçerik Tipi:** `application/json`

---

## 👥 Kullanıcı İşlemleri

### 1. Kullanıcıları Listele (List Users)
Sistemdeki kayıtlı kullanıcıları listeler. Çeşitli parametreler ile filtreleme yapılabilir.

*   **URL:** `/users`
*   **Method:** `GET`

#### Parametreler (Query Parameters)
| Parametre | Tip | Zorunlu | Açıklama |
| :--- | :--- | :--- | :--- |
| `first_name` | string | Hayır | Kullanıcı adına göre filtreleme |
| `email` | string | Hayır | E-posta adresine göre filtreleme |
| `phone` | string | Hayır | Telefon numarasına göre filtreleme |
| `firm_name` | string | Hayır | Firma adına göre filtreleme |
| `firm_id` | integer | Hayır | Firma ID'sine göre filtreleme |

#### Başarılı Yanıt (200 OK)
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "firm_id": 1,
      "first_name": "Ahmet",
      "last_name": "Yılmaz",
      "email": "ahmet@techsoft.com",
      "phone": "05551234567",
      "firm": {
        "id": 1,
        "name": "TechSoft Inc"
      }
    }
  ]
}
```

---

### 2. Kullanıcı Oluştur (Create User)
Yeni bir kullanıcı kaydı oluşturur. Eğer belirtilen firma sistemde yoksa, otomatik olarak yeni bir firma oluşturulur.

*   **URL:** `/users`
*   **Method:** `POST`

#### İstek Gövdesi (Body)
| Parametre | Tip | Zorunlu | Açıklama |
| :--- | :--- | :--- | :--- |
| `firm_name` | string | Evet | Kullanıcının firması |
| `first_name` | string | Evet | Kullanıcı adı |
| `last_name` | string | Evet | Kullanıcı soyadı |
| `email` | string | Evet | E-posta adresi (Benzersiz olmalı) |
| `phone` | string | Evet | Telefon numarası |

#### Örnek İstek
```json
{
  "firm_name": "TechSoft Inc",
  "first_name": "Mehmet",
  "last_name": "Demir",
  "email": "mehmet@techsoft.com",
  "phone": "05559876543"
}
```

#### Başarılı Yanıt (201 Created)
```json
{
  "success": true,
  "message": "Kullanıcı başarıyla oluşturuldu",
  "data": {
    "first_name": "Mehmet",
    "last_name": "Demir",
    "email": "mehmet@techsoft.com",
    "phone": "05559876543",
    "firm_id": 1,
    "id": 2
  }
}
```

#### Hata Yanıtı (422 Unprocessable Entity)
```json
{
  "success": false,
  "message": "The email has already been taken."
}
```

---

### 3. Kullanıcı Detayı (Get User)
Belirli bir kullanıcının detaylı bilgilerini getirir.

*   **URL:** `/users/{id}`
*   **Method:** `GET`

#### Başarılı Yanıt (200 OK)
```json
{
  "success": true,
  "data": {
    "id": 1,
    "first_name": "Ahmet",
    "email": "ahmet@techsoft.com",
    "firm": {
      "id": 1,
      "name": "TechSoft Inc"
    }
  }
}
```

#### Hata Yanıtı (404 Not Found)
```json
{
  "success": false,
  "message": "Kullanıcı bulunamadı"
}
```

---

### 4. Kullanıcı Güncelle (Update User)
Mevcut bir kullanıcının bilgilerini günceller. Firma adı değiştirilirse, kullanıcı yeni firmaya taşınır (yoksa oluşturulur).

*   **URL:** `/users/{id}`
*   **Method:** `PUT`

#### İstek Gövdesi (Body)
Tüm alanlar opsiyoneldir (sometimes).

| Parametre | Tip | Açıklama |
| :--- | :--- | :--- |
| `firm_name` | string | Yeni firma adı |
| `first_name` | string | İsim |
| `email` | string | Yeni e-posta adresi |

#### Örnek İstek
```json
{
  "first_name": "Ahmet Can",
  "firm_name": "New Corp"
}
```

#### Başarılı Yanıt (200 OK)
```json
{
  "success": true,
  "message": "Kullanıcı başarıyla güncellendi",
  "data": {
    "id": 1,
    "first_name": "Ahmet Can",
    "firm_id": 2
  }
}
```

---

### 5. Kullanıcı Sil (Delete User)
Kullanıcıyı sistemden yumuşak siler (Soft Delete). Veritabanından tamamen kaldırılmaz, `deleted_at` işlenir.

*   **URL:** `/users/{id}`
*   **Method:** `DELETE`

#### Başarılı Yanıt (200 OK)
```json
{
  "success": true,
  "message": "Kullanıcı başarıyla silindi"
}
```

---

## 🚦 Durum Kodları (Status Codes)

| Kod | Anlamı | Açıklama |
| :--- | :--- | :--- |
| **200** | OK | İşlem başarıyla gerçekleşti. |
| **201** | Created | Yeni kayıt başarıyla oluşturuldu. |
| **404** | Not Found | İstenen kayıt bulunamadı. |
| **422** | Unprocessable Entity | Veri doğrulama hatası (Eksik veya hatalı veri). |
| **500** | Internal Server Error | Sunucu kaynaklı beklenmeyen hata. |
