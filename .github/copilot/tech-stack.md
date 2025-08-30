# Technology Stack Blueprint

**Generated:** August 30, 2025

---

## 1. Technology Identification Phase

- **Primary Technologies Detected:**
  - **Backend:** PHP (Laravel 12.0)
  - **Frontend:** Blade, Filament (4.0), Vite (7.0), TailwindCSS (4.1), JavaScript (ESM)
  - **Database:** MySQL/SQLite
  - **Testing:** PHPUnit (11.5), PHPStan (level 8), Pint (1.24)
  - **Build Tools:** Composer, NPM
  - **Other:** Spatie Media Library, Filament plugins, FakerPHP

- **Programming Languages:** PHP, JavaScript, CSS
- **Configuration Files:** composer.json, package.json, phpstan.neon, phpunit.xml, pint.json, vite.config.js, tailwind.config.js
- **Version Information:**
  - PHP: ^8.2
  - Laravel: ^12.0 (MIT License)
  - Filament: ~4.0 (MIT License)
  - Vite: ^7.0 (MIT License)
  - TailwindCSS: ^4.1 (MIT License)
  - PHPUnit: ^11.5 (MIT License)
  - Pint: ^1.24 (MIT License)
  - PHPStan: ^3.6 (MIT License)
  - FakerPHP: ^1.23 (MIT License)
  - All other dependencies: see composer.json and package.json

---

## 2. Core Technologies Analysis

### PHP/Laravel

- **Framework:** Laravel 12.x
- **ORM:** Eloquent
- **Testing:** PHPUnit, PHPStan, Pint
- **Auth:** Laravel Auth, Spatie Roles/Permissions
- **Admin UI:** Filament v4
- **Build:** Composer
- **Configuration:** .env, config/*.php

### JavaScript/Node

- **Build Tool:** Vite
- **Styling:** TailwindCSS, PostCSS
- **Linting/Formatting:** Prettier, Pint
- **Module System:** ESM
- **Testing:** Not explicit

### CSS

- **Framework:** TailwindCSS v4
- **Presets:** Filament v4 preset

---

## 3. Implementation Patterns & Conventions

### Naming Conventions

- **Classes/Types:** PascalCase (e.g., User, Order)
- **Methods/Functions:** camelCase
- **Variables:** camelCase
- **Files:** snake_case for migrations, PascalCase for models/controllers
- **Interfaces/Abstracts:** Prefixed with I or Abstract

### Code Organization

- **Folders:**
  - app/Models, app/Http/Controllers, app/Policies, app/Providers, app/Enums
  - resources/views, resources/js, resources/css
  - database/migrations, database/factories, database/seeders
- **Component Boundaries:**
  - Models, Controllers, Policies, Providers, Enums
- **Separation:**
  - Business logic in models/services, thin controllers, views for presentation

### Common Patterns

- **Error Handling:** Laravel exception handling, try/catch in PHP
- **Logging:** Laravel logging, Filament health plugins
- **Configuration:** .env, config/*.php
- **Auth:** Policies, Spatie Roles/Permissions
- **Validation:** Form/request validation, model validation
- **Testing:** PHPUnit, PHPStan, Factories

---

## 4. Usage Examples

### API Implementation Example

```php
// Controller
public function store(Request $request) {
    $validated = $request->validate([...]);
    $order = Order::create($validated);
    return response()->json($order);
}
```

### Data Access Example

```php
// Model
class Product extends Model {
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
```

### Service Layer Example

```php
// Service Provider
class AppServiceProvider extends ServiceProvider {
    public function register() {
        // Bind services
    }
}
```

### UI Component Example

```blade
<!-- Blade View -->
<x-filament::table :records="$orders" />
```

---

## 5. Technology Stack Map

### Core Framework Usage

- **Laravel:** Routing, ORM, Auth, Policies, Service Providers
- **Filament:** Admin UI, dashboards, widgets
- **Vite:** Asset bundling, hot reload
- **TailwindCSS:** Utility-first styling

### Integration Points

- **Auth:** Laravel Auth, Spatie Roles/Permissions
- **Data:** Eloquent ORM, Factories
- **UI:** Blade, Filament
- **Build:** Composer, NPM, Vite

### Development Tooling

- **IDE:** VS Code (recommended)
- **Linters/Formatters:** Pint, Prettier
- **Testing:** PHPUnit, PHPStan
- **Build:** Vite, Composer

### Infrastructure

- **Deployment:** PHP server, MySQL
- **Containerization:** Not explicit
- **Cloud:** Not explicit
- **Monitoring:** Filament health plugins

---

## 6. Technology-Specific Implementation Details

### PHP/Laravel

- **Dependency Injection:** Service container, providers
- **Controller Patterns:** Abstract base, route-bound, request validation
- **Data Access:** Eloquent ORM, relationships, factories
- **API Design:** RESTful, JSON responses
- **Language Features:** Traits, enums, type hints

### JavaScript/Vite

- **Build:** Vite config, ESM modules
- **Styling:** TailwindCSS, presets

---

## 7. Technology Decision Context

- **Reasons for Choices:**
  - Laravel for rapid development, ecosystem, maintainability
  - Filament for admin UI, extensibility
  - Vite/TailwindCSS for modern frontend workflow
  - Composer/NPM for dependency management
- **Legacy/Deprecated:** None detected
- **Constraints:** PHP 8.2+, MySQL 5.7+, Node.js
- **Upgrade Paths:** Laravel, Filament, Vite, TailwindCSS all support regular upgrades

---

**Categorization:** Technology Type

---

**Licenses:** All major dependencies are MIT licensed.

---

**For implementation-ready templates, follow the conventions and examples above.**
