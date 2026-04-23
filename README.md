# NexDesk API (Sistem Chat Headless)

NexDesk API adalah *backend* tangguh dan *scalable* untuk aplikasi pesan (chat) dan pelaporan. Dibangun menggunakan **Laravel 13**, API ini menerapkan **Arsitektur Database Polyglot** yang menggabungkan *database* relasional (MySQL) dan NoSQL (MongoDB) untuk mengoptimalkan penyimpanan dan performa data.

## Fitur Utama & Logika Bisnis

* **Sistem Database Hybrid:** Menggunakan MySQL untuk data relasional terstruktur (User, Autentikasi) dan MongoDB untuk data berbasis dokumen bervolume tinggi (Pesan Chat).
* **Relasi Lintas-Database (Cross-DB):** Integrasi mulus antara model `User` di MySQL dan model `Message` di MongoDB menggunakan *package* `jenssegers/mongodb` (HybridRelations).
* **Manajemen Pesan Lanjutan:**
    * **Batas Waktu Edit:** Pengguna hanya dapat mengedit pesan dalam batas waktu maksimal 60 menit setelah dikirim.
    * **Otorisasi Ketat:** Pengguna hanya dapat mengubah atau menghapus pesannya sendiri (Dilengkapi proteksi 403 Forbidden).
    * **Status Baca (Read Receipts):** Fitur pembaruan massal untuk menandai pesan telah dibaca (`read_at`), dirancang agar ringan dan efisien di sisi *database*.
* **Autentikasi Aman:** Sistem otentikasi berbasis Token menggunakan **Laravel Sanctum**.
* **Standarisasi Respons JSON:** *Output* API yang rapi dan konsisten menggunakan *API Resources* dan *Pagination* bawaan Laravel.

## Tech Stack (Teknologi yang Digunakan)

* **Framework:** Laravel 13.x
* **Environment:** Docker (Laravel Sail)
* **Database Relasional:** MySQL 8.0 (Users, Auth, Reports)
* **Database NoSQL:** MongoDB (Chat Messages)
* **Autentikasi:** Laravel Sanctum
* **Testing API:** Postman

[Klik di sini untuk melihat Dokumentasi Postman NexDesk API]  
https://crimson-satellite-1456435.postman.co/workspace/kkh's-Workspace~513eca4e-75f6-45a2-8afd-b1b7c048edb9/collection/51063118-437c9f62-8580-4440-8924-2297f1e98641?action=share&source=copy-link&creator=51063118

## Cara Menjalankan Project (Lokal)

**1. Clone Repository:**
```bash
git clone https://github.com/kkhff/NexDesk-API.git
cd NexDesk-API
```

**2. Setup Environment**
```bash
cp .env.example .env
```

**3. Install Dependencies:** Jika kamu memiliki PHP dan Composer lokal:
```bash
composer install
```
Jika kamu **hanya ingin menggunakan** Docker (Tanpa install PHP di lokal):
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php8.3-composer:latest \
    composer install --ignore-platform-reqs
```

**4. Jalankan Docker Sail**
```bash
./vendor/bin/sail up -d
```

**5. Generate Key & Migrate**
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

## API Endpoints
| Role | Email | Password |
| :--- | :--- | :--- |
| Admin | `admin@laporhub.com` | password123 |
| Petugas | `petugas@laporhub.com` | password123 |
