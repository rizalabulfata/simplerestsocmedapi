# Simple Rest Social Media

🚀 **Simple Rest Social Media** adalah proyek API sederhana berbasis Laravel 11 dan PHP 8.2 untuk fitur dasar media sosial seperti autentikasi, profil, sistem mengikuti (follow), postingan dengan gambar, like, dan komentar.

## 📌 Fitur Utama
### 🔐 **User**
- ✅ **Autentikasi** (Register, Login dan Logout)
- ✅ **Manajemen Profil**
  - Update profil
  - Lihat profil (profil sendiri & pengguna lain)
  - Cari pengguna berdasarkan nama
- ✅ **Sistem Mengikuti (Follow/Unfollow)**
  - Dapatkan daftar pengikut (followers)
  - Dapatkan daftar yang diikuti (following)
  - Follow/unfollow pengguna lain

### 📝 **Postingan** (Multiple Images & Text)
- ✅ **Buat, Edit, dan Hapus Post**
- ✅ **Dapatkan semua post**
  - Postingan saya
  - Semua postingan pengguna
  - Postingan berdasarkan User ID
  - Postingan dari pengguna yang diikuti
- ✅ **Dapatkan post spesifik (by ID)**
- ✅ **Interaksi Post**
  - Like/unlike post
  - Tambah komentar (hanya teks)
  - Hapus komentar
  - Dapatkan daftar postingan yang sudah di-like

- ✅ **Pagination & Response API yang Konsisten**

---

## 📥 1. Clone Repository
Jalankan perintah berikut untuk meng-clone proyek:

```bash
git clone https://github.com/rizalabulfata/simplerestsocmedapi.git
cd simplerestsocmedapi
```

---

## ⚙️ 2. Instalasi & Konfigurasi
### **Install Dependency**
Pastikan Anda telah menginstal **Composer** dan **PHP 8.2+**, lalu jalankan:

```bash
composer install
```

### **Buat File .env**
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

### **Generate Application Key**
```bash
php artisan key:generate
```

---

## 🛠 3. Konfigurasi Database
Pastikan Anda sudah memiliki database (PostgreSQL, MySQL, SQLite) lalu edit `.env`:

```env
DB_DATABASE=social_media
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

Kemudian jalankan migrasi dan seeder:
```bash
php artisan migrate --seed
```

---

## 🔑 4. Menjalankan Server
Jalankan perintah berikut untuk menjalankan aplikasi: custom port
```bash
php artisan serve --port=2112
```
API sekarang berjalan di: [http://127.0.0.1:2112](http://127.0.0.1:2112)

---

## 📄 5. Dokumentasi API (Postman)
Dokumentasi API tersedia di Postman. Klik tautan berikut untuk mengaksesnya:

[**Dokumentasi Postman - Simple Rest Social Media API**](#)

---

## 🏗 6. Struktur Proyek Kunci
```
app/
  Http/
    Controllers/
      AuthController.php
      UserController.php
      PostController.php
      CommentController.php
    Requests/
    Resources/
      Auth/
      Comment/
      Post/
      User/
    Responses/
      ApiResponse.php
  Interfaces/
    ModelManagementInterface.php
  Repositories/
    ModelManagementRepository.php
  Services/
    AuthService.php
    CommentService.php
    ModelManagementService.php
    PostService.php
    UserService.php
  Models/
    User.php
    Post.php
    Comment.php
routes/
  api.php
  web.php
```

## 📜 Lisensi
Proyek ini menggunakan lisensi **MIT**.

Happy Coding! 🚀

