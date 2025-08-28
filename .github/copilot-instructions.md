# Copilot Instructions for Cafe POS

These instructions guide AI coding agents. Keep changes small, safe, and aligned with existing patterns.

## Big picture
- Stack: Laravel 12 + Filament 4, PHP ^8.2 (CI uses 8.4), Vite (npm). Charts via flowframe/laravel-trend.
- Structure:
  - Models in `app/Models` (Order, OrderItem, Product, Payment, Category, Customer, User). Money via `App\Casts\MoneyCast` (integer cents).
  - Filament under `app/Filament/**`: Components, Pages, Widgets.
  - Services under `app/Services` encapsulate heavy logic (stats, charts, validation, auth/env, notifications, date ranges, order totals).
  - Helpers in `app/Helpers` (see `helpers.php`, `DateRange.php`).

## Research first (authoritative sources)
- Before proposing changes, consult:
  - Top-level README: [README.md](../README.md) for setup, scripts, and security notes (e.g., admin seeding).
  - Project docs: [docs/architecture.md](../docs/architecture.md), [docs/guidelines.md](../docs/guidelines.md), [docs/tasks.md](../docs/tasks.md), [docs/plan.md](../docs/plan.md).
  - CI setup: [.github/workflows/copilot-setup-steps.yml](workflows/copilot-setup-steps.yml) — mirror its steps in automation/examples.
- Quick search examples (Windows PowerShell):
  - Find guidance: Select-String -Path README.md, docs/*.md -Pattern 'migrate|seed|Filament|workflow'
  - Open files and follow the documented conventions over ad-hoc guesses.

## Conventions and patterns
- Extract complexity into Services:
  - `OrderStatsCalculator`, `StatsOverviewCalculator`, `ChartDataService`
  - `OrderCalculationService`, `OrderFormValidator`
  - `AuthenticationService`, `EnvironmentService`, `FilamentConfigurationService`, `NotificationBodyBuilder`, `DateRangeService`
- Filament Resources delegate to `Resources/<Domain>/Components/*` (e.g., `OrderForm`, `OrderTable`).
- Dates/ranges: `DateRangeService::getCarbonInstancesFromDateString()` returns [from, to, label], label in `perDay|perWeek|perMonth|perYear`.
- Localization: Prefer `__('resources/...')` over literals.

## Build, run, and test
- Local:
  - `cp .env.example .env && php artisan key:generate`
  - Configure DB (MySQL or SQLite), then: `php artisan migrate --force` and `php artisan db:seed --force`
  - Frontend: `npm install && npm run dev` (or `npm run build`)
  - Storage: `php artisan storage:link`
- CI/Copilot setup (follow the workflow):
  - PHP 8.4, Node 22; composer install (cached), `npm ci`
  - SQLite bootstrap:
    - `cp .env.example .env || true`
    - `php artisan config:clear && php artisan cache:clear`
    - `rm -f database/database.sqlite && touch database/database.sqlite`
    - `php artisan key:generate --force`
    - `php artisan storage:link`
    - `php artisan migrate --force`
    - `php artisan db:seed --force`
  - Non-interactive admin seed (env-driven):
    - Set `ADMIN_EMAIL`, `ADMIN_NAME`, `ADMIN_PASSWORD` (environment secret)
    - `php artisan db:seed --class=AdminUserSeeder --no-interaction`

## Safe-edit checklist
- Run checks locally:
  - Style: `composer run pint`
  - Types: `composer run stan`
  - Tests: `composer run test`
- Avoid editing vendor/generated files. Make migrations/seeders idempotent.
- Package removal:
  - Ensure no code references (search README/docs for guidance to avoid regressions).
  - `php artisan config:clear && php artisan cache:clear`
  - `composer remove maintainer/package`
  - Re-run: `composer run pint` and `composer run stan`

### Example: remove a package (swisnl/filament-backgrounds)
- Verify no references in code and docs (`filament-backgrounds|swisnl` across repo).
- Clear caches:
  - `php artisan config:clear`
  - `php artisan cache:clear`
- Remove: `composer remove swisnl/filament-backgrounds`
- Re-check: `composer run pint` and `composer run stan`
- Clean views/assets (e.g., [resources/views/filament/pages/welcome.blade.php](../resources/views/filament/pages/welcome.blade.php))

## Examples
- Stats: [app/Filament/Widgets/StatsOverviewWidget.php](../app/Filament/Widgets/StatsOverviewWidget.php) -> [app/Services/StatsOverviewCalculator.php](../app/Services/StatsOverviewCalculator.php)
- Charts: [app/Filament/Widgets/OrdersChart.php](../app/Filament/Widgets/OrdersChart.php) -> [app/Services/ChartDataService.php](../app/Services/ChartDataService.php)
- Validation: [app/Filament/Resources/Orders/Components/OrderForm.php](../app/Filament/Resources/Orders/Components/OrderForm.php) -> [app/Services/OrderFormValidator.php](../app/Services/OrderFormValidator.php)
- Totals: [app/Models/Order.php](../app/Models/Order.php) -> [app/Services/OrderCalculationService.php](../app/Services/OrderCalculationService.php)

If unclear where logic should live, check README/docs and prefer a service-first change referencing similar files above.
