# Cafe POS System

[![Build Status](https://img.shields.io/badge/build-passing-brightgreen?style=flat-square)](https://github.com/nirwanadoteth/cafe-pos)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-777bb4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-ff2d20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-4.x-f59e0b?style=flat-square)](https://filamentphp.com)
[![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)](LICENSE)

> A modern, feature-rich point-of-sale system built with Laravel and Filament for cafes and restaurants.

**[Getting Started](#getting-started)** • **[Features](#features)** • **[Installation](#installation)** • **[Usage](#usage)** • **[Development](#development)**

---

## Overview

The Cafe POS System is a comprehensive point-of-sale solution designed specifically for cafes and restaurants. Built with modern PHP technologies, it provides an intuitive admin interface, real-time reporting, and robust order management capabilities.

This application leverages Laravel 12 for the backend architecture and Filament 4 for the admin panel, offering a seamless experience for both staff and management. Whether you're running a small cafe or a larger restaurant, this system scales to meet your needs.

> [!TIP]
> **Quick Start**: You can have the system running locally in under 5 minutes using SQLite (no database setup required).

## Features

- **📊 Real-time Dashboard**: Live statistics, charts, and performance metrics
- **🛒 Order Management**: Complete order lifecycle from creation to completion
- **📝 Product Catalog**: Comprehensive product and category management
- **👥 Customer Management**: Customer profiles and order history
- **💰 Payment Processing**: Multi-payment method support with detailed tracking
- **📈 Analytics & Reporting**: Advanced reporting with date range filtering
- **🧾 Invoice Generation**: Automated PDF invoice generation
- **🔐 Role-based Access**: Secure user management with permission controls
- **📱 Responsive Design**: Works seamlessly on desktop, tablet, and mobile
- **🌐 Multi-language Support**: Built-in internationalization framework
- **⚡ Performance Optimized**: Efficient queries and caching strategies
- **🔍 Advanced Filtering**: Powerful search and filter capabilities across all modules

### Dashboard Features

- Revenue tracking with trend analysis
- Order statistics and performance metrics
- Customer growth analytics
- Real-time order status monitoring
- Monthly/yearly comparison charts

### Order Management

- Intuitive order creation interface
- Real-time inventory integration
- Order status tracking (New → Processing → Completed)
- Bulk order operations
- Order history and search

### Reporting System

- Sales reports with date range filtering
- Product performance analytics
- Customer behavior insights
- Export capabilities (PDF, Excel)
- Visual charts and graphs

## Getting Started

There are multiple ways to get started with this project, depending on your preference and environment.

### Prerequisites

- **PHP 8.2+** with required extensions
- **Composer** for PHP dependency management
- **Node.js 20+** and **NPM** for frontend assets
- **Git** for version control
- **Database**: SQLite (recommended for development) or MySQL 5.7+

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

### Admin Panel

Access the admin panel at `/admin` using your admin credentials. The interface is organized into several main sections:

- **Dashboard**: Overview of key metrics and recent activity
- **Orders**: Complete order management and tracking
- **Products**: Product catalog and inventory management
- **Customers**: Customer database and order history
- **Reports**: Analytics and reporting tools
- **Settings**: System configuration and user management

### Creating Orders

1. Navigate to **Orders > Create New Order**
2. Select customer (or create new customer)
3. Add products to the order using the product selector
4. Adjust quantities as needed
5. Process payment and complete the order
6. Generate invoice (PDF download available)

### Managing Products

1. Go to **Products** section
2. Create categories for organization
3. Add products with details:
   - Name, description, and pricing
   - Category assignment
   - Visibility settings
4. Use bulk actions for efficient management

### Generating Reports

1. Access **Reports** from the navigation
2. Select report type (Sales, Products, etc.)
3. Apply date range filters
4. View real-time analytics
5. Export data in various formats

## Development

### Project Structure

The project follows Laravel's conventional structure with additional organization:

```
app/
├── Filament/           # Admin panel components
│   ├── Resources/      # CRUD interfaces
│   ├── Widgets/        # Dashboard widgets
│   └── Pages/          # Custom pages
├── Services/           # Business logic layer
├── Models/             # Eloquent models
├── Enums/              # Type-safe enumerations
└── Helpers/            # Utility functions

resources/
├── views/              # Blade templates
├── lang/               # Translations
└── js/                 # Frontend assets
```

### Development Commands

The project includes several Composer scripts for development workflow:

```bash
# Code quality
composer run lint       # Fix code style (Laravel Pint)
composer run stan       # Static analysis (PHPStan Level 8)
composer run test       # Run test suite (PHPUnit)

# Development
composer run dev        # Start development environment
composer run build     # Build production assets

# Database
php artisan migrate     # Run database migrations
php artisan db:seed     # Seed sample data
```

### Code Quality Standards

This project maintains high code quality through:

- **Laravel Pint**: Automated code formatting
- **PHPStan Level 8**: Static analysis for type safety
- **PHPUnit**: Comprehensive testing coverage
- **Architectural patterns**: Service layer separation
- **Type declarations**: Full PHP 8.2+ type coverage

### Testing

Run the test suite to ensure code quality:

```bash
# Run all tests
composer run test

# Run specific test types
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# With coverage (requires Xdebug)
php artisan test --coverage
```

### API Documentation

The system uses standard Laravel patterns. Key endpoints include:

- **Orders**: RESTful order management
- **Products**: Product catalog operations  
- **Customers**: Customer management
- **Reports**: Analytics and reporting

All API interactions are handled through Filament's built-in mechanisms.

## Technology Stack

### Backend

- **Laravel 12.x**: Modern PHP framework with latest features
- **Filament 4.x**: Powerful admin panel builder
- **PHP 8.2+**: Latest PHP with type declarations and performance improvements
- **SQLite/MySQL**: Flexible database options
- **Eloquent ORM**: Laravel's elegant database abstraction

### Frontend

- **Tailwind CSS 4.x**: Utility-first CSS framework
- **Alpine.js**: Lightweight JavaScript framework (via Filament)
- **Vite 7.x**: Modern frontend build tool
- **Blade**: Laravel's templating engine

### Key Packages

- **flowframe/laravel-trend**: Chart data and analytics
- **barryvdh/laravel-dompdf**: PDF generation for invoices
- **bezhansalleh/filament-shield**: Role-based permissions
- **spatie/laravel-health**: Application health monitoring
- **malzariey/filament-daterangepicker-filter**: Advanced date filtering

## Performance

The system is optimized for performance through:

- **Efficient queries**: Proper eager loading and query optimization
- **Caching strategies**: Smart caching for frequently accessed data
- **Database indexing**: Optimized indexes for common query patterns
- **Asset optimization**: Minified and compressed frontend assets
- **Queue processing**: Background processing for heavy operations

## Security

Security features include:

- **Authentication**: Secure user authentication with bcrypt hashing
- **Authorization**: Role-based access control with granular permissions
- **Input validation**: Comprehensive input sanitization and validation
- **SQL injection protection**: Eloquent ORM prevents SQL injection
- **CSRF protection**: Built-in CSRF token validation
- **Security advisories**: Automated security vulnerability checking

## Troubleshooting

### Common Issues

<details>
<summary><strong>Permission Errors</strong></summary>

If you encounter storage or cache permission issues:

```bash
# Fix permissions
chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

</details>

<details>
<summary><strong>Database Issues</strong></summary>

For database connection problems:

1. Verify database credentials in `.env`
2. Ensure database exists (for MySQL)
3. Check database permissions
4. Try recreating the database:

   ```bash
   php artisan migrate:fresh --seed
   ```

</details>

<details>
<summary><strong>Frontend Asset Issues</strong></summary>

If styles or JavaScript aren't working:

```bash
# Rebuild assets
npm run build

# For development with hot reload
npm run dev
```

</details>

### Getting Help

If you encounter issues not covered here:

1. Check the [Laravel documentation](https://laravel.com/docs)
2. Review [Filament documentation](https://filamentphp.com/docs)
3. Search existing [GitHub issues](https://github.com/nirwanadoteth/cafe-pos/issues)
4. Create a new issue with detailed information

## Contributing

We welcome contributions to improve the Cafe POS System. Please follow these guidelines:

1. **Fork** the repository
2. **Create** a feature branch: `git checkout -b feature/amazing-feature`
3. **Follow** the existing code style and patterns
4. **Add** tests for new functionality
5. **Run** quality checks: `composer run lint && composer run stan && composer run test`
6. **Commit** with clear messages: `git commit -m "Add amazing feature"`
7. **Push** to your branch: `git push origin feature/amazing-feature`
8. **Create** a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Write comprehensive PHPDoc comments
- Add tests for new features
- Maintain backward compatibility
- Use semantic versioning for releases

## License

This project is open-source software licensed under the [MIT License](LICENSE). You are free to use, modify, and distribute this software in accordance with the license terms.

---

<div align="center">

**[⭐ Star this project](https://github.com/nirwanadoteth/cafe-pos)** if you find it useful!

Made with ❤️ for the cafe and restaurant community

</div>
