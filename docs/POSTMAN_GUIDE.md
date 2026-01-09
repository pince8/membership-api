# 🚀 Postman Kullanım Kılavuzu

Bu proje, API testlerini hızlıca yapabilmeniz için hazır bir Postman Koleksiyonu (`membership_api.postman_collection.json`) içerir.

## 📥 Koleksiyonu İçe Aktarma (Import)

1.  **Postman** uygulamasını açın.
2.  Sol üst köşedeki **"Import"** butonuna tıklayın.
3.  Açılan pencerede dosya seçiciye tıklayın veya dosyayı sürükleyip bırakın.
    *   Dosya konumu: `docs/membership_api.postman_collection.json`
4.  **"Membership API"** isimli koleksiyon sol menüde belirecektir.

## 🧪 Hazır İstekler

Koleksiyon içerisinde aşağıdaki 5 temel işlem hazır olarak gelir:

1.  **create-user:** Yeni bir kullanıcı oluşturur.
    *   *Body sekmesinden verileri değiştirerek farklı kullanıcılar ekleyebilirsiniz.*
2.  **list-users:** Tüm kullanıcıları getirir.
3.  **get-user:** URL'deki ID'ye göre tek bir kullanıcı getirir.
    *   *Varsayılan ID: 1*
4.  **update-user:** Kullanıcı bilgilerini günceller.
5.  **delete-user:** Kullanıcıyı siler.

## ⚙️ Ortam Ayarları (Environment)

Koleksiyon, varsayılan olarak `http://localhost:8000/api/v1` adresini kullanır. Eğer projenizi farklı bir portta veya sunucuda çalıştırıyorsanız:

1.  Postman'de koleksiyonun üzerine gelin ve **"..." > Edit** seçeneğine tıklayın.
2.  **Variables** sekmesine gidin.
3.  `base_url` değişkenini kendi sunucu adresinizle güncelleyin.
