# Cafe POS System

[![Build Status](https://img.shields.io/badge/build-passing-brightgreen?style=flat-square)](https://github.com/nirwanadoteth/cafe-pos)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-777bb4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-ff2d20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-5.x-f59e0b?style=flat-square)](https://filamentphp.com)
[![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)](LICENSE)

> A modern, feature-rich point-of-sale system built with Laravel and Filament for cafes and restaurants.

**🌐 Language / Bahasa:** **[English](#english)** • **[Indonesia](#bahasa-indonesia)**

---

<a name="english"></a>

# 🇬🇧 English

**[Overview](#overview)** • **[Features](#features)** • **[Getting Started](#getting-started)** • **[Installation](#installation)** • **[Usage](#usage)** • **[Development](#development)**

---

## Overview

The Cafe POS System is a comprehensive point-of-sale solution designed specifically for cafes and restaurants. Built with modern PHP technologies, it provides an intuitive admin interface, real-time reporting, and robust order management capabilities.

This application leverages **Laravel 12** for the backend and **Filament 5** for the admin panel, offering a seamless experience for both staff and management. Whether you're running a small cafe or a larger restaurant, this system scales to meet your needs.

> [!TIP]
> **Quick Start**: You can have the system running locally in under 5 minutes using SQLite (no database setup required).

## Features

- **📊 Real-time Dashboard** — Live revenue, order, and customer statistics with trend comparison
- **🛒 Order Management** — Complete order lifecycle: New → Processing → Completed / Cancelled
- **📝 Product Catalog** — Product and category management with image support and stock tracking
- **👥 Customer Tracking** — Customer profiles linked to order history
- **💰 Payment Processing** — Cash, Card, E-Wallet, and Bank Transfer with status tracking
- **📈 Sales & Product Reports** — Analytics filtered by custom date ranges
- **🔐 Role-based Access Control** — `super_admin`, `kasir`, and `inventaris` roles with granular permissions
- **📱 Responsive Design** — Works on desktop, tablet, and mobile
- **🌐 Internationalization** — Translation-ready with `resources/lang` structure
- **⚡ Inventory Tracking** — Automatic stock deduction and restoration on order status changes
- **🩺 System Health Monitoring** — Built-in health checks for database, cache, queue, and disk
- **📤 Import / Export** — Bulk CSV import and export for products and categories

### Dashboard

- Revenue tracking with period-over-period trend analysis
- New customers and new orders counters
- Latest orders table
- Orders and customers growth charts

### Order Management

- Intuitive order creation with inline product selector
- Real-time stock validation (prevents overselling)
- Status tabs with live badge counts (New, Processing, Completed, Cancelled)
- Payment recording per order (method + status + reference number)

### Reporting

- **Sales Reports** — Min, Max, Sum, Avg revenue grouped by date
- **Product Reports** — Per-product ordered quantity and revenue, with best/least-seller summary

## Getting Started

There are multiple ways to get started with this project, depending on your preference and environment.

### Prerequisites

- **PHP 8.2+** with extensions: `pdo`, `mbstring`, `json`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `gd`
- **Composer** — PHP dependency manager
- **Node.js 20+** and **NPM** — frontend asset compilation
- **Database** — SQLite (recommended for development) or MySQL 5.7+

### Quick Start with SQLite

The fastest way to get started is using SQLite, which requires no additional database setup:

```bash
# Clone the repository
git clone https://github.com/nirwanadoteth/cafe-pos.git
cd cafe-pos

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate
php artisan storage:link

# Database setup (SQLite)
php artisan migrate --seed

# Build frontend assets
npm run build

# Start the development server
composer run dev
```

The application will be available at `http://localhost:8000`.

> [!NOTE]
> The `composer run dev` command starts multiple services concurrently: the Laravel server, queue worker, log monitoring, and Vite for frontend assets.

### Alternative Setup with MySQL

If you prefer to use MySQL for development or production:

1. Create a MySQL database
2. Update your `.env` file:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=cafe_pos
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

3. Run migrations: `php artisan migrate --seed`

## Installation

### Development Environment

For local development, follow these detailed steps:

<details>
<summary><strong>1. Clone and Setup</strong></summary>

```bash
# Clone the repository
git clone https://github.com/nirwanadoteth/cafe-pos.git
cd cafe-pos

# Install PHP dependencies
composer install

# Install Node.js dependencies  
npm install
```

</details>

<details>
<summary><strong>2. Environment Configuration</strong></summary>

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create storage symlink
php artisan storage:link
```

Edit your `.env` file to configure:

- Database connection (SQLite recommended for development)
- Mail settings (optional)
- Queue configuration (sync for development)

</details>

<details>
<summary><strong>3. Database Setup</strong></summary>

**Option A: SQLite (Recommended)**

```bash
# Database will be created automatically
php artisan migrate --seed
```

**Option B: MySQL**

```bash
# Create database first, then:
php artisan migrate --seed
```

The seeder will create sample data including products, categories, and an admin user.

</details>

<details>
<summary><strong>4. Admin User Setup</strong></summary>

Create a secure admin user:

```bash
php artisan db:seed --class=AdminUserSeeder
```

You'll be prompted to enter:

- Admin email address
- Full name
- Secure password (12+ characters)

The user will be assigned the `super_admin` role with full system access.

</details>

<details>
<summary><strong>5. Start Development</strong></summary>

```bash
# Start all development services
composer run dev
```

This command starts:

- Laravel development server (`localhost:8000`)
- Queue worker for background jobs
- Log monitoring
- Vite for frontend asset compilation

</details>

### Production Deployment

For production deployment, additional steps are required:

1. **Environment**: Set `APP_ENV=production` and `APP_DEBUG=false`
2. **Database**: Use MySQL/PostgreSQL with proper indexing
3. **Cache**: Configure Redis for cache and sessions
4. **Queue**: Set up queue workers with Supervisor
5. **Web Server**: Configure Nginx/Apache with proper security headers
6. **SSL**: Enable HTTPS with valid certificates

Refer to the [Laravel deployment documentation](https://laravel.com/docs/12.x/deployment) for detailed production setup.

## Usage

### Accessing the Admin Panel

Navigate to `/admin` and log in with your credentials.

### User Roles

| Role | Access |
|------|--------|
| `super_admin` | Full access to all features |
| `kasir` | Create and manage orders, record payments |
| `inventaris` | Manage products and categories (import/export) |

### Typical Cashier Workflow

1. Open **Orders → New Order**
2. Select or create a customer
3. Adjust product quantities in the order form
4. Save the order — status defaults to **New**
5. Update status to **Processing** when preparing
6. Record payment method and mark as **Completed**

### Managing the Catalog

- Go to **Catalog → Categories** and create categories first
- Go to **Catalog → Products** and add products with price, stock, and image
- Toggle **Visible** to control what appears on the public menu page

### Viewing Reports

- Go to **Reports → Sales Reports** for revenue analysis
- Go to **Reports → Product Reports** for best-selling products
- Use the **Date Range** filter to narrow results

## Development

### Project Structure

The project follows Laravel's conventional structure with additional organization:

```
app/
├── Filament/
│   ├── Resources/      # CRUD panels (Orders, Products, Categories, Users, Roles)
│   ├── Clusters/       # Grouped pages (Reports)
│   ├── Widgets/        # Dashboard widgets
│   └── Pages/          # Custom pages (Dashboard, Welcome, HealthCheckResults)
├── Livewire/           # Interactive components (public product list, reports tables)
├── Services/           # Business logic (InventoryService, StatsOverviewCalculator, …)
├── Models/             # Eloquent models
├── Enums/              # OrderStatus, PaymentMethod, PaymentStatus
└── Helpers/            # Utility functions

resources/
├── views/              # Blade templates
├── lang/en/            # English translations
└── css/, js/           # Frontend source files
```

### Composer Scripts

```bash
composer run dev        # Start dev environment (server + queue + vite)
composer run test       # Run PHPUnit test suite
composer run lint       # Fix code style with Laravel Pint
composer run stan       # Static analysis with PHPStan (level 8)
composer run cs         # Pint + Prettier formatting
```

### Code Quality

| Tool | Purpose |
|------|---------|
| **Laravel Pint** | PSR-12 code formatting |
| **PHPStan Level 8** | Static type analysis |
| **PHPUnit 11** | Feature and unit tests |

### Running Tests

```bash
# Full test suite
php artisan test --compact

# Single file
php artisan test --compact tests/Feature/InventoryTrackingTest.php

# Filtered by name
php artisan test --compact --filter=testStockDecreases
```

## Technology Stack

### Backend

| Package | Version | Purpose |
|---------|---------|--------|
| Laravel Framework | 12.x | Application backbone |
| Filament | 5.x | Admin panel |
| PHP | 8.2+ | Language runtime |
| Livewire | 4.x | Full-stack interactivity |
| Spatie Permission | — | Role & permission system |
| barryvdh/laravel-dompdf | 3.x | PDF invoice generation |
| bezhansalleh/filament-shield | 4.x | Shield permission integration |
| flowframe/laravel-trend | 0.4 | Chart trend data |
| shuvroroy/filament-spatie-laravel-health | 3.x | Health monitoring |

### Frontend

| Tool | Purpose |
|------|---------|
| Tailwind CSS 4.x | Utility-first CSS |
| Alpine.js | Lightweight JS (via Filament) |
| Vite | Asset bundler |
| Blade | Templating engine |

## Troubleshooting

<details>
<summary><strong>Styles or JavaScript not loading</strong></summary>

```bash
npm run build
```

Or run `npm run dev` alongside `php artisan serve` during development.

</details>

<details>
<summary><strong>Storage / permission errors</strong></summary>

```bash
chmod -R 775 storage bootstrap/cache
php artisan storage:link
php artisan config:clear && php artisan cache:clear
```

</details>

<details>
<summary><strong>Database issues</strong></summary>

```bash
php artisan migrate:fresh --seed
```

Ensure `DB_*` values in `.env` are correct and the database exists.

</details>

<details>
<summary><strong>Page not found in admin panel</strong></summary>

If a page is accessible but not visible in the sidebar, it may be a permission mismatch. Contact your `super_admin` to check role assignments.

</details>

## Contributing

1. **Fork** the repository
2. **Create** a branch: `git checkout -b feature/my-feature`
3. **Follow** existing code conventions and patterns
4. **Add** tests for new functionality
5. **Run** quality checks: `composer run lint && composer run stan && composer run test`
6. **Commit** with clear messages following Conventional Commits
7. **Open** a Pull Request

## License

This project is open-source software licensed under the [MIT License](LICENSE). You are free to use, modify, and distribute this software in accordance with the license terms.

---

<div align="center">

**[⭐ Star this project](https://github.com/nirwanadoteth/cafe-pos)** if you find it useful!

Made with ❤️ for the cafe and restaurant community

</div>

---

<a name="bahasa-indonesia"></a>

# 🇮🇩 Bahasa Indonesia

**[Gambaran Umum](#gambaran-umum)** • **[Fitur](#fitur)** • **[Memulai](#memulai)** • **[Instalasi](#instalasi)** • **[Penggunaan](#penggunaan)** • **[Pengembangan](#pengembangan)**

---

## Gambaran Umum

Cafe POS System adalah solusi kasir (Point of Sale) lengkap yang dirancang khusus untuk kafe dan restoran. Dibangun dengan teknologi PHP modern, aplikasi ini menyediakan antarmuka admin yang intuitif, laporan secara real-time, dan manajemen pesanan yang handal.

Aplikasi ini menggunakan **Laravel 12** untuk backend dan **Filament 5** untuk panel admin, memberikan pengalaman yang nyaman bagi kasir maupun manajemen. Sistem ini cocok untuk kafe kecil hingga restoran yang lebih besar.

> [!TIP]
> **Mulai Cepat**: Sistem dapat dijalankan secara lokal dalam waktu kurang dari 5 menit menggunakan SQLite — tidak perlu konfigurasi database tambahan.

## Fitur

- **📊 Dasbor Real-time** — Statistik pendapatan, pesanan, dan pelanggan dengan perbandingan tren periode
- **🛒 Manajemen Pesanan** — Siklus pesanan lengkap: Baru → Diproses → Selesai / Dibatalkan
- **📝 Katalog Produk** — Manajemen produk dan kategori dengan dukungan gambar dan pelacakan stok
- **👥 Data Pelanggan** — Profil pelanggan yang terhubung dengan riwayat pesanan
- **💰 Pencatatan Pembayaran** — Tunai, Kartu, E-Wallet, dan Transfer Bank beserta status pembayaran
- **📈 Laporan Penjualan & Produk** — Analitik dengan filter rentang tanggal kustom
- **🔐 Kontrol Akses Berbasis Peran** — Peran `super_admin`, `kasir`, dan `inventaris` dengan izin granular
- **📱 Desain Responsif** — Berfungsi di komputer, tablet, dan ponsel
- **🌐 Siap Multibahasa** — Struktur terjemahan menggunakan `resources/lang`
- **⚡ Pelacakan Inventaris** — Pengurang dan pemulihan stok otomatis saat status pesanan berubah
- **🩺 Pemantauan Kesehatan Sistem** — Pengecekan database, cache, antrian, dan disk
- **📤 Impor / Ekspor** — Impor dan ekspor CSV massal untuk produk dan kategori

### Dasbor

- Pelacakan pendapatan dengan analisis tren periode ke periode
- Penghitung pelanggan baru dan pesanan baru
- Tabel pesanan terbaru
- Grafik pertumbuhan pesanan dan pelanggan

### Manajemen Pesanan

- Antarmuka pembuatan pesanan dengan pemilih produk langsung
- Validasi stok real-time (mencegah kelebihan penjualan)
- Tab status dengan jumlah badge langsung (Baru, Diproses, Selesai, Dibatalkan)
- Pencatatan pembayaran per pesanan (metode + status + nomor referensi)

### Laporan

- **Laporan Penjualan** — Min, Max, Jumlah, Rata-rata pendapatan dikelompokkan per tanggal
- **Laporan Produk** — Jumlah terjual dan pendapatan per produk, dengan ringkasan produk terlaris / paling sedikit terjual

## Memulai

### Prasyarat

- **PHP 8.2+** dengan ekstensi: `pdo`, `mbstring`, `json`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `gd`
- **Composer** — pengelola dependensi PHP
- **Node.js 20+** dan **NPM** — kompilasi aset frontend
- **Database** — SQLite (disarankan untuk pengembangan) atau MySQL 5.7+

### Mulai Cepat dengan SQLite

```bash
# 1. Clone repositori
git clone https://github.com/nirwanadoteth/cafe-pos.git
cd cafe-pos

# 2. Instal dependensi
composer install
npm install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate
php artisan storage:link

# 4. Setup database (SQLite — dibuat otomatis)
php artisan migrate --seed

# 5. Build aset frontend
npm run build

# 6. Jalankan server pengembangan
composer run dev
```

Buka **<http://localhost:8000>** di browser Anda.

> [!NOTE]
> `composer run dev` menjalankan server Laravel, queue worker, dan Vite secara bersamaan.

### Setup dengan MySQL

1. Buat database MySQL (contoh: `cafe_pos`)
2. Perbarui file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_pos
DB_USERNAME=username_anda
DB_PASSWORD=password_anda
```

1. Jalankan migrasi: `php artisan migrate --seed`

## Instalasi

<details>
<summary><strong>Langkah 1 — Clone dan Instal Dependensi</strong></summary>

```bash
git clone https://github.com/nirwanadoteth/cafe-pos.git
cd cafe-pos
composer install
npm install
```

</details>

<details>
<summary><strong>Langkah 2 — Konfigurasi Environment</strong></summary>

```bash
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

Pengaturan `.env` penting yang perlu diperiksa:

- `APP_URL` — atur ke domain Anda di produksi
- `DB_CONNECTION` — `sqlite` atau `mysql`
- `QUEUE_CONNECTION` — `sync` untuk pengembangan, `database` atau `redis` untuk produksi

</details>

<details>
<summary><strong>Langkah 3 — Setup Database</strong></summary>

```bash
# Menjalankan migrasi dan mengisi data contoh (produk, kategori, pengguna)
php artisan migrate --seed
```

</details>

<details>
<summary><strong>Langkah 4 — Buat Pengguna Admin</strong></summary>

```bash
php artisan db:seed --class=AdminUserSeeder
```

Anda akan diminta memasukkan:

- Alamat email admin
- Nama lengkap
- Kata sandi yang kuat (minimal 12 karakter)

Pengguna akan diberikan peran `super_admin` dengan akses penuh ke seluruh sistem.

</details>

<details>
<summary><strong>Langkah 5 — Mulai Pengembangan</strong></summary>

```bash
composer run dev
```

Menjalankan secara bersamaan:

- Server Laravel (`localhost:8000`)
- Queue worker
- Vite untuk hot-reload aset frontend

</details>

### Deployment Produksi

1. Atur `APP_ENV=production` dan `APP_DEBUG=false`
2. Gunakan MySQL dengan indeks yang tepat
3. Konfigurasi Redis untuk cache dan sesi
4. Pasang Supervisor untuk queue worker
5. Gunakan Nginx atau Apache dengan HTTPS

Lihat [dokumentasi deployment Laravel](https://laravel.com/docs/12.x/deployment) untuk panduan lengkap.

## Penggunaan

### Mengakses Panel Admin

Buka `/admin` dan masuk menggunakan kredensial Anda.

### Peran Pengguna

| Peran | Akses |
|-------|-------|
| `super_admin` | Akses penuh ke semua fitur |
| `kasir` | Membuat dan mengelola pesanan, mencatat pembayaran |
| `inventaris` | Mengelola produk dan kategori (impor/ekspor) |

### Alur Kerja Kasir

1. Buka **Pesanan → Pesanan Baru**
2. Pilih atau buat pelanggan baru
3. Atur jumlah produk di formulir pesanan
4. Simpan pesanan — status awal: **Baru**
5. Ubah status ke **Diproses** saat pesanan sedang disiapkan
6. Catat metode pembayaran dan tandai sebagai **Selesai**

### Mengelola Katalog

- Buka **Katalog → Kategori** dan buat kategori terlebih dahulu
- Buka **Katalog → Produk** dan tambahkan produk dengan harga, stok, dan gambar
- Aktifkan toggle **Visible** untuk mengatur produk yang tampil di halaman menu publik

### Melihat Laporan

- Buka **Laporan → Laporan Penjualan** untuk analisis pendapatan
- Buka **Laporan → Laporan Produk** untuk melihat produk terlaris
- Gunakan filter **Rentang Tanggal** untuk mempersempit hasil

## Pengembangan

### Struktur Proyek

```
app/
├── Filament/
│   ├── Resources/      # Panel CRUD (Pesanan, Produk, Kategori, Pengguna, Peran)
│   ├── Clusters/       # Halaman terkelompok (Laporan)
│   ├── Widgets/        # Widget dasbor
│   └── Pages/          # Halaman kustom (Dashboard, Welcome, HealthCheckResults)
├── Livewire/           # Komponen interaktif (daftar produk publik, tabel laporan)
├── Services/           # Logika bisnis (InventoryService, StatsOverviewCalculator, …)
├── Models/             # Model Eloquent
├── Enums/              # OrderStatus, PaymentMethod, PaymentStatus
└── Helpers/            # Fungsi utilitas

resources/
├── views/              # Template Blade
├── lang/en/            # Terjemahan bahasa Inggris
└── css/, js/           # File sumber frontend
```

### Skrip Composer

```bash
composer run dev        # Jalankan lingkungan pengembangan (server + queue + vite)
composer run test       # Jalankan suite pengujian PHPUnit
composer run lint       # Perbaiki gaya kode dengan Laravel Pint
composer run stan       # Analisis statis dengan PHPStan (level 8)
composer run cs         # Format dengan Pint + Prettier
```

### Standar Kualitas Kode

| Alat | Kegunaan |
|------|----------|
| **Laravel Pint** | Format kode PSR-12 |
| **PHPStan Level 8** | Analisis tipe statis |
| **PHPUnit 11** | Pengujian fitur dan unit |

### Menjalankan Pengujian

```bash
# Semua pengujian
php artisan test --compact

# File tertentu
php artisan test --compact tests/Feature/InventoryTrackingTest.php

# Filter berdasarkan nama
php artisan test --compact --filter=testStockDecreases
```

## Teknologi yang Digunakan

### Backend

| Paket | Versi | Kegunaan |
|-------|-------|----------|
| Laravel Framework | 12.x | Kerangka aplikasi |
| Filament | 5.x | Panel admin |
| PHP | 8.2+ | Runtime bahasa |
| Livewire | 4.x | Interaktivitas full-stack |
| Spatie Permission | — | Sistem peran & izin |
| barryvdh/laravel-dompdf | 3.x | Pembuatan PDF invoice |
| bezhansalleh/filament-shield | 4.x | Integrasi izin Shield |
| flowframe/laravel-trend | 0.4 | Data tren grafik |
| shuvroroy/filament-spatie-laravel-health | 3.x | Pemantauan kesehatan sistem |

### Frontend

| Alat | Kegunaan |
|------|----------|
| Tailwind CSS 4.x | CSS berbasis utilitas |
| Alpine.js | JS ringan (via Filament) |
| Vite | Bundler aset |
| Blade | Template engine |

## Pemecahan Masalah

<details>
<summary><strong>Tampilan atau JavaScript tidak termuat</strong></summary>

```bash
npm run build
```

Atau jalankan `npm run dev` bersamaan dengan `php artisan serve` saat pengembangan.

</details>

<details>
<summary><strong>Error permission pada storage</strong></summary>

```bash
chmod -R 775 storage bootstrap/cache
php artisan storage:link
php artisan config:clear && php artisan cache:clear
```

</details>

<details>
<summary><strong>Masalah database</strong></summary>

```bash
php artisan migrate:fresh --seed
```

Pastikan nilai `DB_*` di `.env` sudah benar dan database sudah dibuat.

</details>

<details>
<summary><strong>Halaman tidak muncul di sidebar panel admin</strong></summary>

Jika halaman dapat diakses tetapi tidak muncul di sidebar, kemungkinan ada ketidakcocokan izin (permission). Hubungi `super_admin` untuk memeriksa penetapan peran pengguna Anda.

</details>

## Kontribusi

1. **Fork** repositori ini
2. **Buat** branch baru: `git checkout -b feature/fitur-saya`
3. **Ikuti** konvensi dan pola kode yang sudah ada
4. **Tambahkan** pengujian untuk fungsionalitas baru
5. **Jalankan** pemeriksaan kualitas: `composer run lint && composer run stan && composer run test`
6. **Commit** dengan pesan yang jelas mengikuti Conventional Commits
7. **Buat** Pull Request

## Lisensi

Dilisensikan di bawah [Lisensi MIT](LICENSE). Bebas digunakan, dimodifikasi, dan didistribusikan.

---

<div align="center">

**[⭐ Beri bintang proyek ini](https://github.com/nirwanadoteth/cafe-pos)** jika bermanfaat!

Dibuat dengan ❤️ untuk komunitas kafe dan restoran

</div>
