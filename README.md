# 🚀 NexDesk API (Headless Chat System)

NexDesk API is a robust, scalable backend for a real-time messaging and reporting application. Built with **Laravel 11**, it implements a **Polyglot Database Architecture** utilizing both relational (MySQL) and NoSQL (MongoDB) databases to optimize data storage and retrieval.

## ✨ Key Features & Business Logic

* **Hybrid Database System:** Uses MySQL for structured relational data (Users, Authentication) and MongoDB for high-volume, document-based data (Messages).
* **Cross-Database Eloquent Relations:** Seamless integration between MySQL `User` models and MongoDB `Message` models using `jenssegers/mongodb` (HybridRelations).
* **Advanced Message Management:**
    * **Edit Limits:** Users can only edit messages within a 60-minute window.
    * **Strict Authorization:** Users can only update or delete their own messages (403 Forbidden protection).
    * **Read Receipts:** Mass-update functionality for `read_at` timestamps to optimize database queries.
* **Secure Authentication:** Token-based authentication using **Laravel Sanctum**.
* **Standardized JSON Responses:** Elegant and consistent output formatting using Laravel API Resources and Pagination.

## 🛠️ Tech Stack

* **Framework:** Laravel 11.x
* **Environment:** Docker (Laravel Sail)
* **Relational DB:** MySQL 8.0 (Users, Auth, Reports)
* **NoSQL DB:** MongoDB (Chat Messages)
* **Authentication:** Laravel Sanctum
* **Client Testing:** Postman


## Cara Menjalankan Project (Lokal)

**1. Clone Repository:**
```bash
git clone https://github.com/kkhff/NexDesk-API.git
cd LaporHub-API
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
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

**4. Jalankan Docker Sail**
```bash
./vendor/bin/sail up -d
```

**5. Generate Key & Migrate**
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan storage:link
./vendor/bin/sail artisan migrate --seed
```

## API Endpoints
| Role | Email | Password |
| :--- | :--- | :--- |
| Admin | `admin@laporhub.com` | password123 |
| Petugas | `petugas@laporhub.com` | password123 |
