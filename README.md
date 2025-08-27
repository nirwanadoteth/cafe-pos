<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# Cafe POS System

A modern point-of-sale system built with Laravel for cafe and restaurant management.

## Documentation

- 📄 [Installation Guide](#setup-instructions)
- 💾 [Database File](cafe_pos.sql)

## Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 5.7+
- Git

## Setup Instructions

1. **Clone the Repository**

   ```bash
   git clone https://github.com/10122222/cafe-pos.git
   cd cafe-pos
   ```

2. **Install PHP Dependencies**

   ```bash
   composer install
   ```

3. **Environment Setup**

   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan storage:link
   ```

4. **Configure Database**
   - Create a new MySQL database
   - Update .env file with your database credentials:

     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=cafe_pos
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

   - Import the database from

     ```bash
     cafe_pos.sql
     ```

5. **Install Frontend Dependencies**

   ```bash
   npm install && npm run build
   ```

6. **Start the Development Server**

   ```bash
   composer run dev
   ```

## Troubleshooting

### Permission Issues

If you encounter storage or cache-related errors:

```bash
chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

## Admin User Setup (Secure)

For security, default plaintext credentials are not provided. Create an admin user with a strong password using the seeder:

```bash
php artisan db:seed --class=AdminUserSeeder
```

You will be prompted for the admin email, name, and a secure password (12+ characters). The user will be assigned the `super_admin` role.

## Developer Scripts

Use Composer scripts to standardize local workflows:

```bash
composer run lint      # PHP code style (Pint)
composer run stan      # Static analysis (PHPStan)
composer run test      # Test suite (PHPUnit)
composer run build     # Frontend build (Vite)
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
