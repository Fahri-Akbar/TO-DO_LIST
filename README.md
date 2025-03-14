
# 📋 Simple To-Do List Website

## 📖 Informasi Singkat

Ini adalah **website To-Do List sederhana** yang dibuat untuk membantu pengguna dalam **mencatat, mengatur, dan mengelola tugas-tugas harian** mereka. Website ini dirancang ringan, mudah digunakan, dan cocok untuk kebutuhan pribadi maupun pembelajaran.

---

## ✨ Fitur-Fitur Website

- **Menambah Tugas**  
  Pengguna dapat menambahkan tugas baru dengan mudah, cukup mengisi nama tugas dan deskripsi (opsional).

- **Menghapus Tugas**  
  Tugas yang sudah tidak diperlukan dapat dihapus secara permanen dari daftar.

- **Mengedit Tugas**  
  Tugas yang sudah ditambahkan dapat diedit untuk memperbarui isi atau statusnya.

- **Pin Tugas**  
  Fitur untuk **menandai (pin)** tugas penting agar muncul di bagian atas daftar tugas.

- **Statistik Tugas**  
  Menampilkan informasi statistik tugas yang meliputi:  
  - Total tugas yang pernah dibuat.  
  - Total tugas yang pernah diselesaikan.  
  - Total tugas aktif saat ini (belum diselesaikan).

---

## 💾 Cara Mendownload dari GitHub

1. **Buka repository GitHub**:  
   https://github.com/Fahri-Akbar/TO-DO_LIST.git

2. **Download ZIP**:  
   Klik tombol **Code** > pilih **Download ZIP**, lalu ekstrak file ZIP ke komputer kamu.

3. **Atau menggunakan Git (rekomendasi)**:  
   Buka terminal atau CMD, lalu jalankan perintah berikut:
   ```bash
   git clone https://github.com/Fahri-Akbar/TO-DO_LIST.git
   ```

---

## 🛠 Cara Import Database dan Konfigurasi

### 1. Aktifkan XAMPP
- Jalankan aplikasi **XAMPP**.
- Aktifkan **Apache** dan **MySQL**.

### 2. Buat Database Baru
- Buka browser, masuk ke **phpMyAdmin**:
  ```
  http://localhost/phpmyadmin
  ```
- Klik **New** (menu di sebelah kiri).
- Masukkan nama database: "db_todo"
- Klik **Create** untuk membuat database.

### 3. Import Database
- Klik database `db_todo` yang baru dibuat.
- Klik tab **Import**.
- Klik **Choose File** atau **Pilih File**, kemudian cari file `db_todo.sql` dari folder 'Database' yang berada di folder project yang sudah kamu download.
- Klik tombol **Go**.
- Setelah proses selesai, tabel-tabel akan otomatis muncul.

### 4. Konfigurasi Koneksi Database
- Buka file `koneksi.php` di folder project.
- Sesuaikan konfigurasi berikut sesuai XAMPP kamu:

```php
<?php
    $host = 'localhost'; //Server Lokal
    $database = 'db_todo'; //Nama Database
    $username = 'root'; //Nama Username (Default)
    $password = ''; //Password MySQL (Default)

    $connect = mysqli_connect($host, $username, $password, $database);

    if(!$connect) die('Koneksi Gagal' . mysqli_connect_error());
?>
```

> **Catatan:**
> - Jika MySQL memiliki password, isi bagian `$pass`.
> - Pastikan nama database sama persis dengan database di phpMyAdmin.

---

## 🚀 Cara Menjalankan Website

1. **Pindahkan folder project** ke:
   ```
   C:\xampp\htdocs\TO-DO_LIST
   ```
2. **Akses website** melalui browser:
   ```
   http://localhost/TO-DO_LIST
   ```

3. **Pastikan XAMPP aktif** (Apache & MySQL berjalan).

4. **Jika ada error koneksi**, cek ulang `koneksi.php` dan status database.


