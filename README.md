# Cafe POS System

A modern, extensible Point-of-Sale (POS) application for cafes, built with Laravel 12.x, Filament 4.x (Server‑Driven UI on Livewire/Alpine/Tailwind), and Tailwind CSS v4.x. It provides robust order management, reporting, and admin features with a clean, modular architecture and developer-friendly workflow.

---

## Technology Stack

- **Backend:** PHP 8.2+ (Laravel 12.x)
- **Frontend:** Blade, Filament (4.x), Vite (7.x), TailwindCSS (4.1), JavaScript (ESM)
- **Database:** MySQL/SQLite
- **Testing:** PHPUnit (11.5), PHPStan (level 8), Pint (1.24)
- **Build Tools:** Composer, NPM
- **Other:** Spatie Media Library, Filament plugins, FakerPHP

See [tech-stack.md](.github/copilot/tech-stack.md) for details.

---

## Project Architecture

- Layered MVC (Model-View-Controller) with Service/Repository patterns
- Modular organization: Models, Controllers, Policies, Providers, Enums, Factories, Migrations
- Filament 4.x for admin UI as Server‑Driven UI (Resources, Pages, Widgets) powered by Livewire/Alpine/Tailwind
- Clear separation of concerns, extensibility, and security via policy-based authorization

See [architecture.md](.github/copilot/architecture.md) for full overview and diagrams.

---

## Getting Started

### Prerequisites

- PHP 8.2+
- MySQL 5.7+ or SQLite
- Node.js (for frontend assets)

### Installation

```sh
composer install
npm install
```

### Setup

- Copy `.env.example` to `.env` and configure database and environment variables

```sh
cp .env.example .env
```

- Generate app key

```sh
php artisan key:generate
```

- Run migrations and seeders:

```sh
php artisan migrate --seed
```

- Run all development services concurrently

```sh
composer dev
```

- Or individually:

```sh
php artisan serve         # Laravel development server
npm run dev               # Vite dev server with Tailwind v4
php artisan queue:listen  # Queue worker
php artisan pail          # Real-time log monitoring
```

---

## Project Structure

See [folder-structure.md](.github/copilot/folder-structure.md) for full details.

```text
app/
  Models/           # Domain entities
  Http/Controllers/ # Request handling
  Policies/         # Authorization logic
  Providers/        # Service providers
  Filament/         # Admin UI (Filament v4)
    Resources/      # Eloquent-backed resources
      Orders/
        OrderResource.php
        Pages/      # List/Create/Edit pages
        Widgets/    # Resource widgets
        Schemas/    # Extracted schemas
        Tables/     # Extracted tables
    Pages/          # Standalone panel pages (e.g., Dashboard)
    Widgets/        # Dashboard widgets
    Clusters/       # Optional navigation clusters
    Imports/        # Bulk imports (optional)
    Exports/        # Bulk exports (optional)
  Livewire/         # UI workflows
  Helpers/          # Utility functions
  Casts/            # Custom attribute casting
resources/
  views/            # Blade templates
  js/               # Frontend scripts
  css/              # Stylesheets
  lang/             # Localization
public/             # Entry point and assets
config/             # Configuration files
routes/             # Route definitions
storage/            # App storage
tests/              # Feature and unit tests
database/           # Migrations, factories, seeders
```

---

## Key Features

- **Modern Admin Interface:** Filament 4.x with enhanced UI/UX and improved performance
- **Advanced Order Management:** Complete order lifecycle with real-time updates
- **Comprehensive Reporting:** Analytics dashboard with visual insights
- **Role-based Authorization:** Secure access control with policies and permissions
- **Responsive Design:** Tailwind CSS v4 with optimized build performance
- **Modular Architecture:** Clean, extensible codebase following Laravel best practices
- **Automated Testing:** PHPUnit with PHPStan static analysis and Pint code formatting
- **Hot Reload Development:** Vite 7.x with lightning-fast asset compilation
- **Database Flexibility:** Support for MySQL and SQLite with comprehensive seeding

---

## Development Workflow

- **Modern Stack:** Laravel 12.x + Filament 4.x + Tailwind v4 + Vite 7.x
- **Component Development:** Modular Livewire and Filament components
- **Data Access:** Eloquent ORM with relationships and factories
- **Authorization:** Policy-based security with Spatie permissions
- **Quality Assurance:** Automated testing with PHPUnit, PHPStan Level 8, and Pint
- **Asset Pipeline:** Vite with hot reload and optimized Tailwind v4 compilation
- **Development Commands:** Unified `composer dev` script for concurrent services
- **Branching:** Feature branches with pull requests and code review

### Code Quality & Testing

```sh
# Run all quality checks
composer cs           # Code style (Pint + Prettier)
composer stan         # Static analysis (PHPStan Level 8)
composer test         # PHPUnit test suite

# Individual commands
./vendor/bin/pint     # Laravel Pint formatting
./vendor/bin/phpstan  # Static analysis
php artisan test      # Run tests
```

See [workflow.md](.github/copilot/workflow.md) for workflow details.

---

## Coding Standards

- PascalCase for classes, camelCase for methods/variables
- snake_case for migrations
- PSR-4 autoloading and folder structure
- Separation of concerns: business logic in models/services, thin controllers
- Consistent error handling and validation

See [exemplars.md](.github/copilot/exemplars.md) for code examples and [architecture.md](.github/copilot/architecture.md) for standards.

---

## Testing

- **Unit Tests:** `tests/Unit/` — Isolated component tests
- **Feature Tests:** `tests/Feature/` — End-to-end workflow tests  
- **Test Data:** Factories and seeders for consistent environments
- **Quality Assurance:** PHPStan Level 8 static analysis
- **Code Style:** Laravel Pint formatting
- **Performance:** Optimized database setup for test runs

### Running Tests

```sh
# Full test suite with quality checks
composer test         # PHPUnit tests
composer stan         # PHPStan static analysis
composer cs           # Code style formatting

# Individual test commands
php artisan test                   # Run all tests
php artisan test --filter=Unit     # Unit tests only
php artisan test --filter=Feature  # Feature tests only
```

See [exemplars.md](.github/copilot/exemplars.md) and [architecture.md](.github/copilot/architecture.md) for patterns.

---

## Contributing

- **Standards:** Follow coding standards using established patterns ([exemplars.md](.github/copilot/exemplars.md))
- **Development:** Use feature branches with pull requests and code review
- **Testing:** Write comprehensive tests for new functionality (unit and feature tests)
- **Documentation:** Update relevant documentation and blueprint files
- **Quality:** Ensure all code passes PHPStan Level 8 and Pint formatting
- **Guidelines:** See [copilot-instructions.md](.github/copilot/copilot-instructions.md) for detailed guidelines

### Upgrade Documentation

The project has been successfully upgraded to the latest technology stack. See comprehensive upgrade documentation:

- **[Upgrade Plan](plan/upgrade-laravel-filament-tailwind-1.md)** - Complete three-phase upgrade strategy
- **[Phase 1 Report](docs/upgrade/phase-1-completion-report.md)** - Preparation and dependency review
- **[Phase 2 Report](docs/upgrade/phase-2-implementation-report.md)** - Package upgrades and refactoring  
- **[Phase 3 Report](docs/upgrade/phase-3-completion-report.md)** - Testing, validation, and finalization

---

## Security headers

This app adds standard security headers via `App\Http\Middleware\SecurityHeaders` and applies them to Filament pages as well:

- Content-Security-Policy (CSP), X-Content-Type-Options=nosniff, X-Frame-Options=SAMEORIGIN
- Referrer-Policy=no-referrer, Permissions-Policy for common features
- Strict-Transport-Security (HSTS) in production over HTTPS

CSP defaults: development allows localhost/ws for Vite/Livewire; production is stricter and limited to self with minimal inline allowances required by Filament/Livewire.

Override CSP (choose one):

- Edge/web server: set the Content-Security-Policy header in Nginx/Apache/CDN; the middleware won’t overwrite an existing header.
- App-level: register your own middleware earlier in `bootstrap/app.php` or the Filament panel provider; or adjust `buildCsp()` in `app/Http/Middleware/SecurityHeaders.php`.
- Per-route: apply a route or group middleware to set a different policy for specific pages.

Tests assert these headers on core and Filament routes. If you move headers to the edge, ensure they remain present or update the tests accordingly.

---

## Production Readiness

✅ **Latest Technology Stack:** Laravel 12.x, Filament 4.x, Tailwind v4.x  
✅ **Security:** All vulnerabilities patched, PHPStan Level 8 compliance  
✅ **Performance:** Optimized build pipeline, faster asset compilation  
✅ **Testing:** Comprehensive automated tests  
✅ **Documentation:** Complete upgrade documentation and developer guides  
✅ **Code Quality:** Enforced static analysis and consistent formatting

---

## License

MIT License. See [tech-stack.md](.github/copilot/tech-stack.md) for details.
