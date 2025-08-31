# Project Architecture Blueprint

**Generated:** August 30, 2025

---

## 1. Architecture Detection and Analysis

**Technology Stack:**

- **Backend:** Laravel 12.x (PHP 8.2+)
- **Frontend:** Blade templates, Filament 4.x (Server‑Driven UI admin panel), Vite 7.x, TailwindCSS v4, JavaScript
- **Database:** MySQL/SQLite
- **Testing:** PHPUnit 11.5, PHPStan Level 8, Pint 1.24
- **Other:** Composer, Node.js, Spatie Media Library, Filament plugins

**Architectural Pattern:**

- Layered MVC (Model-View-Controller) with Service/Repository patterns
- Modular organization (app/Models, app/Http/Controllers, app/Policies, app/Providers)
- Filament SDUI for admin UI (server‑driven, Livewire‑based)

---

## 2. Architectural Overview

- **Guiding Principles:** Separation of concerns, modularity, extensibility, security (policy-based authorization)
- **Boundaries:** Models, Controllers, Policies, Providers, Views, Enums, Factories, Migrations
- **Hybrid Patterns:** Filament implements Server‑Driven UI (SDUI) via Livewire‑backed components (Resources, Pages, Widgets) layered on Laravel MVC

---

## 3. Architecture Visualization (Textual)

- **Subsystems:**
  - Domain (Models, Enums)
  - Application (Controllers, Providers)
  - Infrastructure (Migrations, Factories, Policies)
  - Presentation (Blade Views, Filament Pages)
- **Dependency Flow:**
  - Controllers → Models/Services
  - Models → Database
  - Policies → Models/User
  - Views → Controllers/Models
- **Data Flow:**
  - HTTP Request → Route → Controller → Model/Service → View/Response

---

## 4. Core Architectural Components

### Models

- **Purpose and Responsibility:** Represent domain entities (User, Product, Order, etc.)
- **Internal Structure:** Eloquent ORM, Factories, SoftDeletes, Custom Casts
- **Interaction Patterns:** Relationships (HasMany, BelongsTo), Factories, Media Library
- **Evolution Patterns:** Extendable via traits, custom casts, relationships

### Controllers

- **Purpose and Responsibility:** Handle HTTP requests, orchestrate business logic
- **Internal Structure:** Abstract base, route-bound
- **Interaction Patterns:** Call models/services, return views/responses
- **Evolution Patterns:** Extend base, add new endpoints

### Policies

- **Purpose and Responsibility:** Authorization logic
- **Internal Structure:** Per-model policies, HandlesAuthorization trait
- **Interaction Patterns:** Used by controllers/services for permission checks
- **Evolution Patterns:** Add new abilities, integrate with roles/permissions

### Filament Components

- **Purpose and Responsibility:** Server‑driven admin panels, dashboards, and form/table‑based apps authored entirely in PHP; minimizes custom JavaScript while delivering rich interactivity.
- **Internal Structure:** Panels, Resources (List/Create/Edit/View pages for Eloquent models), Custom Pages, and Widgets. Built on Livewire (components), Alpine.js (lightweight client reactivity), and Tailwind CSS (utility styling). Provides first‑class form and table builders.
- **Interaction Patterns:** State and actions run on the server inside Livewire components with incremental requests; Alpine hydrates interactive behavior client‑side. Tables/forms support validation, actions, bulk operations, filters, and summarizers.
- **Evolution Patterns:** Extend by adding or customizing Panels, Resources, Pages, and Widgets; configure forms/tables/navigation in PHP. See the [Filament v4 Documentation](https://filamentphp.com/docs/4.x).

---

## 5. Architectural Layers and Dependencies

- **Layers:**
  - Presentation (Blade, Filament)
  - Application (Controllers, Providers)
  - Domain (Models, Enums)
  - Infrastructure (Migrations, Factories, Policies)
- **Dependency Rules:**
  - Lower layers do not depend on upper layers
  - Dependency injection via Laravel service container
- **Abstraction:**
  - Interfaces, traits, enums
- **Violations:**
  - No circular dependencies detected

---

## 6. Data Architecture

- **Domain Model Structure:** User, Product, Order, OrderItem, Payment, Category, Customer
- **Entity Relationships:**
  - Order → OrderItems, Payment, Customer
  - Product → Category, OrderItems
  - Category → Products
- **Data Access Patterns:** Eloquent ORM, Factories
- **Transformation:** Custom Casts (MoneyCast)
- **Caching Strategies:** Not explicit, relies on Laravel cache
- **Validation Patterns:** Request validation in controllers, model-level validation

---

## 7. Cross-Cutting Concerns Implementation

- **Authentication & Authorization:**
  - Laravel Auth, Policies, Spatie Roles/Permissions
- **Error Handling & Resilience:**
  - Exception handling via Laravel, SoftDeletes for resilience
- **Logging & Monitoring:**
  - Laravel logging, Filament health plugins
- **Validation:**
  - Form/request validation, model validation
- **Configuration Management:**
  - .env files, config/*.php, environment-specific configs

---

## 8. Service Communication Patterns

- **Service Boundaries:**
  - Internal: Controllers, Models, Policies
  - External: Database, Filament plugins
- **Protocols:** HTTP (web), Livewire component requests (AJAX), internal PHP calls
- **Sync/Async:** Mostly synchronous, some async via queues
- **API Versioning:** Not explicit
- **Service Discovery:** Not required (monolith)
- **Resilience:** SoftDeletes, error handling

---

## 9. Technology-Specific Architectural Patterns

### Laravel

- Service container, dependency injection
- Eloquent ORM, Factories, Migrations
- Policy-based authorization
- Blade templating, Filament SDUI (Livewire/Alpine/Tailwind)

### JavaScript/Node

- Vite for asset bundling
- TailwindCSS for styling

---

## 10. Implementation Patterns

- **Interface Design Patterns:** Traits, contracts, enums
- **Service Implementation Patterns:** Providers, Controllers
- **Repository Implementation Patterns:** Eloquent ORM
- **Controller/API Implementation Patterns:** Route-bound, request validation, response formatting
- **Domain Model Implementation:** Entities, value objects, events (not explicit)

---

## 11. Testing Architecture

- **Strategies:** Unit (tests/Unit), Feature (tests/Feature)
- **Test Boundary Patterns:** Per-layer, per-component
- **Test Doubles and Mocking Approaches:** Factories, mocking via PHPUnit
- **Test Data Strategies:** Factories
- **Tools:** PHPUnit

---

## 12. Deployment Architecture

- **Topology:** Monolithic, deployable via PHP server
- **Environment Adaptation:** .env, config files
- **Runtime Dependency Resolution Patterns:** Composer, NPM
- **Configuration Management Across Environments:** .env, config/*.php
- **Containerization:** Not explicit
- **Cloud Service Integration Patterns:** Not explicit

---

## 13. Extension and Evolution Patterns

- **Feature Addition Patterns:** Add new models, controllers, policies, Filament resources/pages
- **Modification Patterns:** Extend models/controllers, update policies
- **Integration Patterns:** Add new plugins, adapters, service providers

---

## 14. Architectural Pattern Examples

### Layer Separation Examples

```php
// app/Models/Product.php
class Product extends Model { /* ... */ }
// app/Http/Controllers/Controller.php
abstract class Controller { /* ... */ }
```

### Component Communication Examples

```php
// app/Policies/OrderPolicy.php
public function update(User $user, Order $order): bool {
    return $user->can('update_order');
}
```

### Extension Point Examples

```php
// app/Providers/AppServiceProvider.php
class AppServiceProvider extends ServiceProvider { /* ... */ }
```

---

## 15. Architectural Decision Records

- **Architectural Style Decisions:** Layered MVC chosen for maintainability, extensibility, and Laravel convention
- **Technology Selection Decisions:** Laravel for rapid development, Filament for admin UI, Spatie for permissions/media
- **Implementation Approach Decisions:** Eloquent ORM for data, policies for security, Blade/Filament for UI
- **Context:** Cafe POS domain, need for modularity and extensibility
- **Consequences:** Easy to extend, maintain, onboard; monolithic limits horizontal scaling

---

## 16. Architecture Governance

- **Consistency:** Enforced via Laravel conventions, PSR-4 autoloading
- **Automated Checks for Architectural Compliance:** PHPStan, Pint, PHPUnit
- **Review Processes:** Code reviews, plugin updates
- **Documentation Practices:** README, user manual, technical report

---

## 17. Blueprint for New Development

- **Development Workflow:**
  - Create model, migration, factory
  - Add controller, routes, policy
  - Add Filament panel/resource/page if admin UI needed
  - Write tests (unit/feature)
- **Implementation Templates:**
  - Model: extends Eloquent Model, uses HasFactory
  - Controller: extends base Controller
  - Policy: HandlesAuthorization trait
- **Common Pitfalls:**
  - Avoid logic in views
  - Keep controllers thin
  - Use policies for all authorization
  - Test all new features

---

## 18. Modern Development Workflow (Post-Upgrade)

### Technology Stack Benefits

- **Laravel 12.x:** Enhanced performance, security patches, modern PHP features
- **Filament 4.x:** Improved admin UI components, better developer experience
- **Tailwind v4:** CSS-first configuration, faster compilation, smaller bundles
- **Vite 7.x:** Lightning-fast builds, enhanced hot reload, optimized asset pipeline

### Development Commands

```bash
# Unified development environment
composer dev          # Runs all services concurrently (server, queue, logs, vite)

# Individual services
php artisan serve      # Laravel development server
npm run dev           # Vite dev server with Tailwind v4 hot reload
php artisan queue:listen  # Queue worker
php artisan pail      # Real-time log monitoring

# Quality assurance
composer cs           # Code style (Pint + Prettier)
composer stan         # Static analysis (PHPStan Level 8)
composer test         # PHPUnit test suite
```

### Build Configuration

- **Vite 7.x:** Modern asset bundling with `@tailwindcss/vite` plugin
- **Tailwind v4:** CSS-first configuration using `@import "tailwindcss"`
- **Hot Reload:** Enhanced development experience with instant updates
- **Production Builds:** Optimized CSS (473KB) and JS (35KB) bundles

### Migration Notes

The application has been successfully upgraded through a three-phase process:

1. **Phase 1:** Dependency analysis and preparation
2. **Phase 2:** Package upgrades and breaking change resolution
3. **Phase 3:** Testing, validation, and finalization

All legacy code has been refactored for compatibility with the new technology stack while maintaining architectural consistency.

---

**Keep this blueprint updated as the architecture evolves.**
