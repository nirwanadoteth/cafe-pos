# Copilot Instructions for Cafe POS

These instructions guide AI coding agents working in this repository. Keep changes small, safe, and aligned with current patterns.

## Big picture
- Stack: Laravel 12 + Filament 4 admin, PHP 8.2, Vite (npm). Data in MySQL. Trend charts use flowframe/laravel-trend.
- Structure highlights:
  - Domain models in `app/Models` (Order, OrderItem, Product, Payment, Category, Customer, User). Money is cast with `App\Casts\MoneyCast`.
  - Filament resources, widgets, pages in `app/Filament/**`. UI logic is split into Components (`Components/`), Pages (`Pages/`), and Widgets (`Widgets/`).
  - Services in `app/Services` encapsulate complex logic: statistics, charts, authentication, environment, notifications, date ranges, order totals.
  - Helpers in `app/Helpers` expose global helpers (autoloaded via composer.json).
- Philosophy: reduce cyclomatic complexity by extracting logic to dedicated services; keep Resources/Widgets lean and declarative.

## Conventions and patterns
- Prefer services over big methods. Existing services include:
  - `OrderStatsCalculator`, `StatsOverviewCalculator`, `ChartDataService`
  - `OrderCalculationService`, `OrderFormValidator`
  - `AuthenticationService`, `EnvironmentService`, `FilamentConfigurationService`, `NotificationBodyBuilder`, `DateRangeService`
- Filament Resource layout:
  - Resource classes delegate to component classes under `Resources/<Domain>/Components/` (e.g., `OrderForm`, `OrderTable`).
  - Widgets prefer calculator/services for data; avoid complex queries inline.
- Money and numbers:
  - Prices stored as integer cents. Use `MoneyCast` and `Illuminate\Support\Number::currency()` for display.
- Dates and ranges:
  - `DateRangeService::getCarbonInstancesFromDateString()` returns [from, to, label] where label is one of `perDay|perWeek|perMonth|perYear`.
  - Trend charts use `flowframe/laravel-trend` with `between(...)->perX()->count()/sum()`.
- Authorization:
  - Filament Shield (`BezhanSalleh\FilamentShield`) manages roles/permissions; policies under `app/Policies`. Use `$user->can('<permission>')`.
  - Role management via `app/Filament/Resources/Roles/RoleResource.php` extends base Shield resource.

## Build, run, and test
- Database setup (choose one):
  - Quick: Import provided data: `mysql -u <user> -p <db> < cafe_pos.sql`
  - Clean: Use migrations: `php artisan migrate --seed` (requires seeders)
- Composer scripts:
  - `composer run dev` launches: PHP server, queue listener, logs, and Vite via concurrently.
  - `composer run lint` runs Pint. `composer run stan` runs PHPStan. `composer run test` runs PHPUnit.
- Frontend: `npm install && npm run build` (or `npm run dev`). Note: dependencies may show UNMET initially.
- Storage link: ensure `php artisan storage:link` during setup.
- Testing: Use SQLite in-memory for Feature tests (see docs/guidelines.md). Unit tests work without DB.

## Integration points
- Filament:
  - Panels configured via `app/Providers/Filament/AdminPanelProvider.php` and `FilamentConfigurationService`.
  - Pages like `Welcome.php` render Livewire `home` component.
  - Health checks via `ShuvroRoy\FilamentSpatieLaravelHealth` plugin.
- Charts and stats:
  - `StatsOverviewWidget` delegates to `StatsOverviewCalculator`.
  - `OrdersChart` and `CustomersChart` use `ChartDataService` and translate labels from `resources/lang`.
- Orders domain:
  - `Order` computes total in `booted()` via `OrderCalculationService::calculateTotalPrice()`.
  - `OrderStats` widget uses `OrderStatsCalculator::calculateStats()` with tab-aware filtering.

## Coding guidance for agents
- When a method grows complex (nested conditionals, multiple responsibilities), extract:
  - Queries -> a dedicated service or query scope
  - Calculations/aggregation -> service in `app/Services`
  - Validation -> validator service (see `OrderFormValidator`)
- Keep Filament classes concise: compose schemas/tables, call services for data.
- Add precise PHPDoc generics for arrays and Eloquent Builders when feasible; match existing style (e.g., `@return array<int,int>`; `@param Builder<App\Models\Order>`).
- Use repository helpers and enums: `App\Enums\OrderStatus` implements Filament label/icon/color.
- Localization: Use translation keys like `__('resources/order....')` instead of literals.

## Safe-edit checklist
- After edits: run locally
  - Pint (style): `composer run lint`
  - PHPStan (types): `composer run stan`
  - Tests (if altered behavior): `composer run test`
- Avoid touching vendor or generated files. For migrations or seed updates, ensure idempotency.
- If removing a Composer package, do NOT edit composer.json or composer.lock manually. First ensure there are no code references. Then run, in order:
  - `php artisan config:clear` and `php artisan cache:clear`
  - `composer remove maintainer/package`
  - Optionally: `composer install` (CI will do this) and re-run `composer run lint` / `composer run stan`

### Example: remove a package (swisnl/filament-backgrounds)
- Verify no code references remain (search for `filament-backgrounds|swisnl`).
- Clear caches:
  - `php artisan config:clear`
  - `php artisan cache:clear`
- Remove the package:
  - `composer remove swisnl/filament-backgrounds`
- Re-run local checks:
  - `composer run lint`
  - `composer run stan`
- Clean up any straggling assets/usages:
  - Remove CSS/images under `public/` if previously published.
  - Update views to remove background usage (see `resources/views/filament/pages/welcome.blade.php`).

## Examples
- Stats extraction: see `app/Filament/Widgets/StatsOverviewWidget.php` using `StatsOverviewCalculator`.
- Chart data: `app/Filament/Widgets/OrdersChart.php` delegates to `ChartDataService`.
- Form validation: `OrderForm` uses `OrderFormValidator` for items repeater rules.
- Component delegation: `OrderResource` uses `Components/OrderForm.php` and `Components/OrderTable.php`.

If anything is unclear (e.g., where a calculation should live or how to structure a new widget), propose a small service-first change and reference similar files above.
