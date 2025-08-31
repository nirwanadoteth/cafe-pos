# Technology Stack Blueprint

**Generated:** August 30, 2025

---

## 1. Technology Identification Phase

- **Primary Technologies Detected:**
  - **Backend:** PHP (Laravel 12.0)
  - **Frontend:** Blade, Filament (4.0, Server‑Driven UI), Vite (7.0), TailwindCSS (4.1), JavaScript (ESM)
  - **Database:** MySQL/SQLite
  - **Testing:** PHPUnit (11.5), PHPStan (level 8), Pint (1.24)
  - **Build Tools:** Composer, NPM
  - **Other:** Spatie Media Library, Filament plugins, FakerPHP

- **Programming Languages:** PHP, JavaScript, CSS
- **Configuration Files:** composer.json, package.json, phpstan.neon, phpunit.xml, pint.json, vite.config.js, tailwind.config.js
- **Version Information:**
  - PHP: ^8.2
  - Laravel: ^12.0 (MIT License)
  - Filament: ^4.0 (MIT License)
  - Vite: ^7.0 (MIT License)
  - TailwindCSS: ^4.1 (MIT License)
  - PHPUnit: ^11.5 (MIT License)
  - Pint: ^1.24 (MIT License)
  - PHPStan: ^3.6 (MIT License)
  - FakerPHP: ^1.23 (MIT License)
  - All other dependencies: see composer.json and package.json

---

## 2. Core Technologies Analysis

### PHP/Laravel details

- **Framework:** Laravel 12.x
- **ORM:** Eloquent
- **Testing:** PHPUnit, PHPStan, Pint
- **Auth:** Laravel Auth, Spatie Roles/Permissions
- **Admin UI:** Filament v4
- **Build:** Composer
- **Configuration:** .env, config/*.php

### Filament (Server‑Driven UI)

- **Nature:** Server‑Driven UI (SDUI) framework for Laravel that defines UIs entirely in PHP using structured configuration objects rather than traditional templating.
- **Foundation:** Built on Livewire, Alpine.js, and Tailwind CSS; ships opinionated components for admin panels, dashboards, tables, forms, and widgets.
- **DX:** Build full‑featured interfaces without custom JavaScript; server manages state/behavior while Livewire/Alpine hydrate interactivity on the client.
- **Docs:** [Filament v4 Documentation](https://filamentphp.com/docs/4.x)

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
- **Filament (SDUI):** Server‑driven admin UI, dashboards, tables, forms, and widgets built in PHP (powered by Livewire + Alpine + Tailwind)
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

## 7. Blueprint for New Code Implementation

- **File/Class Templates:**
  - Use PascalCase for models/controllers, snake_case for migrations
  - Service providers extend ServiceProvider
  - Blade components use <x-*> syntax
- **Code Snippets:**
  - See usage examples above for controller, model, service, and UI patterns
- **Implementation Checklist:**
  - Add new model/controller/service in appropriate folder
  - Register service providers in app/Providers
  - Use request validation in controllers
  - Write tests for new features
- **Integration Points:**
  - Use Eloquent for data access
  - Use Filament for admin UI
  - Use Laravel Auth/Spatie for authentication/authorization
- **Testing Requirements:**
  - Write PHPUnit tests for new code
  - Use factories for test data
  - Prefer PHPUnit 11+ attributes over docblock annotations (e.g., DataProvider) to avoid deprecations
  - Use in-memory SQLite per phpunit.xml; refresh DB between tests via TestCase
  - For header assertions, follow redirects and assert on the terminal response
  - For Filament/Livewire, keep interactions at HTTP level in Feature tests; unit test pure logic separately
- **Documentation Requirements:**
  - Document new features in README or technical docs

---

## 8. Technology Decision Context

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

---

## 9. Project-Specific Guidance (Laravel 12 • Filament 4 • Tailwind v4)

### Testing (PHPUnit 11+)

- Use attributes instead of docblocks for PHPUnit metadata (e.g., DataProvider) to be forward-compatible with PHPUnit 12.
- Use model factories for test data; leverage in-memory SQLite for speed and isolation.
- When testing redirects and headers (e.g., security headers), assert against the final response after following redirects.
- Keep feature tests focused on HTTP flows; isolate complex calculations into unit tests.

### Security Headers & CSP

- App-wide SecurityHeaders middleware sets: Content-Security-Policy (CSP), Strict-Transport-Security (HSTS in prod over HTTPS), X-Content-Type-Options, X-Frame-Options, Referrer-Policy, and Permissions-Policy.
- CSP is environment-aware: dev allows Vite/HMR and ws:; production is stricter. Prefer dropping 'unsafe-inline' in production with nonces/hashes when feasible.
- Consider adding `frame-ancestors 'self';` in CSP; you can keep X-Frame-Options temporarily for legacy compatibility.
- HSTS only in production and only when the request is HTTPS; evaluate includeSubDomains/preload carefully before enabling.

### Tailwind CSS v4 Notes

- CSS-first setup: import Tailwind in CSS with `@import "tailwindcss"`; use the `@tailwindcss/vite` plugin in Vite 7.
- Content scanning is simplified in v4; avoid legacy purge/content configs. Safelist any dynamic classes if generated at runtime.
- Prefer utility classes and keep custom CSS minimal; verify Filament 4 styles remain intact after pruning.
