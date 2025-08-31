# Project Folders Structure Blueprint

**Generated:** August 31, 2025

---

## 1. Structural Overview

- **Project Type:** Laravel (PHP), with frontend assets (Blade, Filament, Vite, TailwindCSS)
- **Architecture:** Layered MVC, modular organization, admin UI via Filament (Server‑Driven UI)
- **Organization Principle:** By layer (domain, application, infrastructure, presentation), with feature/domain separation in models, policies, controllers
- **No monorepo or microservices detected**
- **Frontend:** Present as Blade views, Filament v4, Vite/TailwindCSS assets

- **Filament v4 directory model:** Resources and Clusters follow a panel‑scoped structure. A typical resource contains a Resource class and a nested `Pages/` folder; optionally `Schemas/` and `Tables/` folders are used if forms/tables aren’t embedded in the Resource class (configurable via file generation flags).

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
      - Clusters/
      - Exports/
      - Imports/
      - Pages/
      - Resources/
        - Example/
          - ExampleResource.php
          - Pages/
            - CreateExample.php
            - EditExample.php
            - ListExamples.php
          - (optional) Schemas/
          - (optional) Tables/
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
- **Filament/**: Admin UI (Filament v4)
  - **Resources/**: Eloquent‑backed CRUD. For each entity, Filament generates `{Entity}/{Entity}Resource.php` and a nested `Pages/` folder containing `List{Entity}.php`, `Create{Entity}.php`, `Edit{Entity}.php`. Optionally, `Schemas/` and `Tables/` are used when not embedding schemas/tables in the Resource class.
  - **Pages/**: Standalone panel pages.
  - **Widgets/**: Dashboard and data widgets (stats, charts, tables).
  - **Clusters/**: Navigation grouping for related resources/pages; cluster folders mirror the cluster name and contain `Pages/` and `Resources/` under it.
  - **Imports/** and **Exports/**: Bulk data import/export.
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
- **UI Components:** app/Filament/ (panel UI), app/Livewire/ (custom or non‑panel UI), resources/views/
- **Tests:** tests/Feature/, tests/Unit/
- **Migrations/Factories/Seeders:** database/migrations/, database/factories/, database/seeders/
- **Assets:** resources/js/, resources/css/, public/css/, public/js/, public/images/
- **Helpers/Casts:** app/Helpers/, app/Casts/

### Filament‑specific placement (v4)

- Resources:
  - `app/Filament/Resources/{Entity}/{Entity}Resource.php`
  - `app/Filament/Resources/{Entity}/Pages/*`
  - Optional: `app/Filament/Resources/{Entity}/Schemas/*`, `app/Filament/Resources/{Entity}/Tables/*`
- Pages: `app/Filament/Pages/*`
- Widgets: `app/Filament/Widgets/*`
- Clusters: `app/Filament/Clusters/{ClusterName}/*` with nested `Pages/` and `Resources/`
- Imports/Exports: `app/Filament/Imports/*`, `app/Filament/Exports/*`

---

## 5. Naming and Organization Conventions

- **Files:** PascalCase for classes, snake_case for migrations, camelCase for variables/methods
- **Folders:** Singular for domain (Model, Policy), plural for collections (Resources, Widgets)
- **Namespaces:** PSR-4 autoloading, matches folder structure
- **Grouping:** By layer and feature/domain

---

## 6. Navigation and Development Workflow

- **Entry Points:** public/index.php (web), routes/web.php (routing)
- **Common Development Tasks:**
  - Add Model: app/Models/
  - Add Controller: app/Http/Controllers/
  - Add Policy: app/Policies/
  - Add Filament Resource: app/Filament/Resources/{Entity} (plus nested `Pages/`)
  - Add Filament Page: app/Filament/Pages/
  - Add Filament Widget: app/Filament/Widgets/
  - Add Filament Cluster: app/Filament/Clusters/
  - Add Import/Export: app/Filament/Imports/, app/Filament/Exports/
  - Add Livewire component: app/Livewire/
  - Add Migration/Factory: database/migrations/, database/factories/
  - Add Test: tests/Feature/, tests/Unit/
- **Configuration:** config/*.php, .env
- **Dependencies:** composer.json (PHP), package.json (JS)
- **DI Registration:** app/Providers/ (panel providers may live under `app/Providers/Filament/`)

---

## 7. Build and Output Organization

- **Build Scripts:** composer.json (PHP), package.json (JS), vite.config.js (frontend)
- **Output:** public/css/, public/js/, public/images/
- **Environment:** .env, config/*.php
- **Development vs Production:** Vite/TailwindCSS for asset builds, Laravel for backend

---

## 8. Extension and Evolution

- **Extension Points:**
  - Add new model/controller/policy/UI component in respective folders
  - Add new domain folders, extend Filament/Livewire components
- **Scalability Patterns:**
  - Extend by adding new domain/feature folders
  - Refactor by moving logic to services/helpers, updating policies, reorganizing folders as needed
  - Use Filament Clusters to group related resources/pages in navigation.
  - For larger teams, consider separate `Schemas/` and `Tables/` subfolders per resource; otherwise embed in the Resource class to reduce class sprawl (v4 option).

---

## 9. Structure Templates

### New Feature Template

```text
app/Models/NewFeature.php
app/Http/Controllers/NewFeatureController.php
app/Policies/NewFeaturePolicy.php
app/Filament/Resources/NewFeature/NewFeatureResource.php
app/Filament/Resources/NewFeature/NewFeatureResource/Pages/CreateNewFeature.php
app/Filament/Resources/NewFeature/NewFeatureResource/Pages/EditNewFeature.php
app/Filament/Resources/NewFeature/NewFeatureResource/Pages/ListNewFeatures.php
app/Filament/Pages/CustomPage.php                   # optional standalone panel page
app/Filament/Widgets/NewFeatureStats.php            # optional widget
app/Filament/Clusters/Settings/SettingsCluster.php  # optional cluster
app/Livewire/NewFeatureComponent.php                # optional Livewire component
resources/views/new-feature.blade.php
database/migrations/xxxx_xx_xx_xxxxxx_create_new_features_table.php
database/factories/NewFeatureFactory.php
tests/Feature/NewFeatureTest.php
tests/Unit/NewFeatureUnitTest.php
```

### Cluster Template (optional)

```text
app/Filament/Clusters/Settings/SettingsCluster.php
app/Filament/Clusters/Settings/Pages/ManageBranding.php
app/Filament/Clusters/Settings/Pages/ManageNotifications.php
app/Filament/Clusters/Settings/Resources/ColorResource.php
app/Filament/Clusters/Settings/Resources/ColorResource/Pages/CreateColor.php
app/Filament/Clusters/Settings/Resources/ColorResource/Pages/EditColor.php
app/Filament/Clusters/Settings/Resources/ColorResource/Pages/ListColors.php
```

---

## 10. Structure Enforcement

- **Structure Validation:**
  - PHPStan, Pint, and code reviews enforce structure
  - Build checks for PSR-4 autoloading compliance
- **Documentation Practices:**
  - Structure changes documented in README and architecture.md
  - Architectural decisions recorded in architecture.md
  - Structure evolution tracked in version control
  - Filament v4 includes tooling to standardize panel directories. Consider:
    - `php artisan filament:upgrade-directory-structure-to-v4 --dry-run`
    - `php artisan filament:upgrade-directory-structure-to-v4`
  - Filament v4 file generation flags can embed schemas/tables into the Resource class or place classes outside directories. Configure via the Filament config file as needed.

---

**Summary:**

- Layered, modular folder structure
- Clear separation by domain, layer, and feature
- Consistent naming and placement conventions
- Easy navigation for development and extension
- Build/output organization supports frontend and backend workflows
- Templates provided for new features/components
- Structure enforcement via static analysis, code reviews, and documentation
- Last updated: August 31, 2025
