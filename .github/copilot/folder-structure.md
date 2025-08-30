# Project Folders Structure Blueprint

**Generated:** August 30, 2025

---

## 1. Structural Overview

- **Project Type:** Laravel (PHP), with frontend assets (Blade, Filament, Vite, TailwindCSS)
- **Architecture:** Layered MVC, modular organization, admin UI via Filament
- **Organization Principle:** By layer (domain, application, infrastructure, presentation), with feature/domain separation in models, policies, controllers
- **No monorepo or microservices detected**
- **Frontend:** Present as Blade views, Filament, Vite/TailwindCSS assets

---

## 2. Directory Visualization (Markdown List, Depth 3)

- /
  - app/
    - Models/
    - Http/
      - Controllers/
      - Responses/
    - Policies/
    - Providers/
    - Enums/
    - Filament/
      - Pages/
      - Resources/
      - Widgets/
    - Livewire/
      - Orders/
      - Products/
      - Home.php
    - Helpers/
    - Casts/
  - bootstrap/
  - config/
    - app.php
    - auth.php
    - ...
  - database/
    - migrations/
    - factories/
    - seeders/
  - public/
    - index.php
    - css/
    - js/
    - images/
  - resources/
    - views/
    - js/
    - css/
    - lang/
  - routes/
    - web.php
    - console.php
  - storage/
    - app/
    - framework/
    - logs/
  - tests/
    - Feature/
    - Unit/
    - TestCase.php
  - composer.json
  - package.json
  - README.md

---

## 3. Key Directory Analysis

### app/

- **Models/**: Domain entities (User, Product, Order, etc.), Eloquent ORM, relationships, factories
- **Http/Controllers/**: Handles HTTP requests, orchestrates business logic
- **Policies/**: Authorization logic per model
- **Providers/**: Service providers, dependency injection
- **Enums/**: Domain enums (OrderStatus, etc.)
- **Filament/**: Admin UI (Pages, Resources, Widgets)
- **Livewire/**: UI components for dynamic workflows
- **Helpers/**: Utility functions
- **Casts/**: Custom attribute casting

### database/

- **migrations/**: Schema definitions
- **factories/**: Test data generation
- **seeders/**: Initial data population

### resources/

- **views/**: Blade templates
- **js/**: Frontend scripts
- **css/**: Stylesheets
- **lang/**: Localization files

### public/

- **index.php**: Entry point
- **css/js/images/**: Compiled assets and static files

### tests/

- **Feature/**: End-to-end and integration tests
- **Unit/**: Unit tests
- **TestCase.php**: Base test class

---

## 4. File Placement Patterns

- **Configuration Files:** config/*.php, .env, composer.json, package.json
- **Models/Entities:** app/Models/
- **Controllers:** app/Http/Controllers/
- **Policies:** app/Policies/
- **Providers:** app/Providers/
- **Enums:** app/Enums/
- **UI Components:** app/Filament/, app/Livewire/, resources/views/
- **Tests:** tests/Feature/, tests/Unit/
- **Migrations/Factories/Seeders:** database/migrations/, database/factories/, database/seeders/
- **Assets:** resources/js/, resources/css/, public/css/, public/js/, public/images/
- **Helpers/Casts:** app/Helpers/, app/Casts/

---

## 5. Naming and Organization Conventions

- **Files:** PascalCase for classes, snake_case for migrations, camelCase for variables/methods
- **Folders:** Singular for domain (Model, Policy), plural for collections (Resources, Widgets)
- **Namespaces:** PSR-4 autoloading, matches folder structure
- **Grouping:** By layer and feature/domain

---

## 6. Navigation and Development Workflow

- **Entry Points:** public/index.php (web), routes/web.php (routing)
- **Add Features:**
  - Model: app/Models/
  - Controller: app/Http/Controllers/
  - Policy: app/Policies/
  - UI: app/Filament/ or app/Livewire/
  - Migration/Factory: database/migrations/, database/factories/
  - Test: tests/Feature/, tests/Unit/
- **Configuration:** config/*.php, .env
- **Dependencies:** composer.json (PHP), package.json (JS)
- **DI Registration:** app/Providers/

---

## 7. Build and Output Organization

- **Build Scripts:** composer.json (PHP), package.json (JS), vite.config.js (frontend)
- **Output:** public/css/, public/js/, public/images/
- **Environment:** .env, config/*.php
- **Development vs Production:** Vite/TailwindCSS for asset builds, Laravel for backend

---

## 8. Extension and Evolution

- **Add Features:** Create new model/controller/policy/UI component in respective folders
- **Scalability:** Add new domain folders, extend Filament/Livewire components
- **Refactoring:** Move logic to services/helpers, update policies, reorganize folders as needed

---

## 9. Structure Templates

### New Feature Template

```text
app/Models/NewFeature.php
app/Http/Controllers/NewFeatureController.php
app/Policies/NewFeaturePolicy.php
app/Filament/Resources/NewFeatureResource.php
app/Livewire/NewFeatureComponent.php
resources/views/new-feature.blade.php
database/migrations/xxxx_xx_xx_xxxxxx_create_new_features_table.php
database/factories/NewFeatureFactory.php
tests/Feature/NewFeatureTest.php
tests/Unit/NewFeatureUnitTest.php
```

---

**Summary:**

- Layered, modular folder structure
- Clear separation by domain, layer, and feature
- Consistent naming and placement conventions
- Easy navigation for development and extension
- Build/output organization supports frontend and backend workflows
- Templates provided for new features/components
