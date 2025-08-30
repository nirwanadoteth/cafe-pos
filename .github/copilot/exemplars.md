# Code Exemplars Blueprint

**Generated:** August 30, 2025

---

## Introduction

This document identifies high-quality, representative code examples from the codebase. These exemplars demonstrate coding standards, architectural patterns, and best practices for consistent development. Use these as references when implementing new features or refactoring existing code.

---

## Table of Contents

- [Code Exemplars Blueprint](#code-exemplars-blueprint)
  - [Introduction](#introduction)
  - [Table of Contents](#table-of-contents)
  - [Presentation Layer](#presentation-layer)
    - [1. Livewire Component: Orders List](#1-livewire-component-orders-list)
    - [2. Filament Page: Dashboard](#2-filament-page-dashboard)
  - [Business Logic Layer](#business-logic-layer)
    - [1. Order Model](#1-order-model)
    - [2. AppServiceProvider](#2-appserviceprovider)
  - [Data Access Layer](#data-access-layer)
    - [1. Migration: Orders Table](#1-migration-orders-table)
    - [2. Helper Function: Date Range Parsing](#2-helper-function-date-range-parsing)
  - [Cross-Cutting Concerns](#cross-cutting-concerns)
    - [1. Policy: Order Authorization](#1-policy-order-authorization)
  - [Testing Patterns](#testing-patterns)
    - [1. Feature Test Example](#1-feature-test-example)
    - [2. Unit Test Example](#2-unit-test-example)
  - [Consistency Patterns](#consistency-patterns)
  - [Architecture Observations](#architecture-observations)
  - [Anti-patterns to Avoid](#anti-patterns-to-avoid)
  - [Conclusion](#conclusion)

---

## Presentation Layer

### 1. Livewire Component: Orders List

- **File:** `app/Livewire/Orders/ListOrders.php`
- **Description:** Dynamic UI for listing completed orders, filtering, and summarizing data for admin dashboard.
- **Pattern:** UI component, workflow orchestration
- **Key Details:**
  - Uses Eloquent query with status filter
  - Table columns and summarizers for reporting
  - Implements HasForms, HasTable for Filament integration

- **Code Snippet:**

```php
public function table(Table $table): Table
{
    return $table
        ->query(
            Order::query()
                ->where('status', '=', OrderStatus::Completed)
        )
        ->columns([
            Tables\Columns\TextColumn::make('created_at'),
            // ...
        ]);
}
```

### 2. Filament Page: Dashboard

- **File:** `app/Filament/Pages/Dashboard.php`
- **Description:** Admin dashboard page with custom filters and date range picker.
- **Pattern:** UI component, filter form
- **Key Details:**
  - Uses Filament's Form and Section components
  - Integrates date range picker for analytics

- **Code Snippet:**

```php
public function filtersForm(Form $form): Form
{
    return $form
        ->schema([
            Section::make()
                ->schema([
                    DateRangePicker::make('created_at')
                        ->label('Date Range')
                        ->defaultThisMonth()
                        ->alwaysShowCalendar(false)
                        ->autoApply(),
                ]),
        ]);
}
```

---

## Business Logic Layer

### 1. Order Model

- **File:** `app/Models/Order.php`
- **Description:** Domain model for orders, encapsulates relationships and business logic.
- **Pattern:** Domain entity, relationship mapping
- **Key Details:**
  - Uses Eloquent ORM, HasFactory, SoftDeletes
  - Relationships: customer, items, payment
  - Custom casts and enums

- **Code Snippet:**

```php
class Order extends Model
{
    use HasFactory, SoftDeletes;
    // ...
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
```

### 2. AppServiceProvider

- **File:** `app/Providers/AppServiceProvider.php`
- **Description:** Registers application services, binds contracts, and configures Filament hooks.
- **Pattern:** Service provider, dependency injection
- **Key Details:**
  - Binds LogoutResponse contract
  - Registers Filament render hook for custom footer

- **Code Snippet:**

```php
public function register(): void
{
    $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    FilamentView::registerRenderHook(
        PanelsRenderHook::BODY_END,
        fn (): View => view('components.footer.index'),
    );
}
```

---

## Data Access Layer

### 1. Migration: Orders Table

- **File:** `database/migrations/2024_11_10_071032_create_orders_table.php`
- **Description:** Defines schema for orders table, including relationships and soft deletes.
- **Pattern:** Migration, schema definition
- **Key Details:**
  - Foreign key to customer
  - Enum for status
  - Soft deletes and timestamps

- **Code Snippet:**

```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
    $table->string('number', 32)->unique();
    $table->unsignedInteger('total_price')->nullable();
    $table->enum('status', ['new', 'processing', 'completed', 'cancelled'])->default('new');
    $table->text('notes')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

### 2. Helper Function: Date Range Parsing

- **File:** `app/Helpers/helpers.php`
- **Description:** Utility for parsing date strings into Carbon instances and labels.
- **Pattern:** Utility function
- **Key Details:**
  - Handles null/default values
  - Returns range and label for analytics

- **Code Snippet:**

```php
function getCarbonInstancesFromDateString(?string $dateString): array
{
    $format = 'd/m/Y';
    [$from, $to] = $dateString ? explode(' - ', $dateString) : [now()->format($format), now()->format($format)];
    $from = Carbon::createFromFormat($format, $from) ?? now();
    $to = Carbon::createFromFormat($format, $to) ?? now();
    $diff = $from->diffInDays($to);
    $label = $diff >= 365 ? 'perMonth' : ($diff >= 30 ? 'perWeek' : 'perDay');
    return [$from, $to, $label];
}
```

---

## Cross-Cutting Concerns

### 1. Policy: Order Authorization

- **File:** `app/Policies/OrderPolicy.php`
- **Description:** Centralizes authorization logic for order actions.
- **Pattern:** Policy, authorization
- **Key Details:**
  - Uses HandlesAuthorization trait
  - Methods for view, create, update, delete
  - Checks user permissions via can()

- **Code Snippet:**

```php
public function update(User $user, Order $order): bool
{
    return $user->can('update_order');
}
```

---

## Testing Patterns

### 1. Feature Test Example

- **File:** `tests/Feature/ExampleTest.php`
- **Description:** Basic feature test for application response.
- **Pattern:** Feature test
- **Key Details:**
  - Uses TestCase
  - Asserts HTTP status

- **Code Snippet:**

```php
public function test_the_application_returns_a_successful_response(): void
{
    $response = $this->get('/');
    $response->assertStatus(200);
}
```

### 2. Unit Test Example

- **File:** `tests/Unit/ExampleTest.php`
- **Description:** Basic unit test for assertion.
- **Pattern:** Unit test
- **Key Details:**
  - Uses PHPUnit TestCase
  - Simple assertion

- **Code Snippet:**

```php
public function test_that_true_is_true(): void
{
    $this->assertTrue(true);
}
```

---

## Consistency Patterns

- Use of Eloquent ORM for all models
- Consistent naming: PascalCase for classes, camelCase for methods/variables
- Policies for authorization
- Service providers for DI and configuration
- Filament/Livewire for UI workflows
- Factories for test data
- SoftDeletes for resilience

---

## Architecture Observations

- Layered MVC with clear separation of concerns
- Modular organization by domain, layer, and feature
- Use of enums, traits, and contracts for abstraction
- Centralized error handling and logging
- Automated testing and code quality tools (PHPStan, Pint, PHPUnit)

---

## Modern Development Workflow (Laravel 12.x/Filament 4.x/Tailwind v4)

### 1. Unified Development Environment

**File:** `composer.json` - `dev` script
**Description:** Concurrently runs all development services for optimal developer experience

```json
{
  "scripts": {
    "dev": [
      "Composer\\Config::disableProcessTimeout",
      "npx concurrently -c \"#93c5fd,#c4b5fd,#fb7185,#fdba74\" \"php artisan serve\" \"php artisan queue:listen --tries=1\" \"php artisan pail --timeout=0\" \"npm run dev\" --names=server,queue,logs,vite --kill-others"
    ]
  }
}
```

### 2. Modern Asset Pipeline

**File:** `vite.config.js` - Vite 7.x configuration
**Description:** Optimized build configuration with Tailwind v4 integration

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

### 3. CSS-First Tailwind Configuration

**File:** `resources/css/app.css` - Tailwind v4 approach
**Description:** Modern CSS-first configuration replacing JavaScript config

```css
@import "tailwindcss";
```

### 4. Quality Assurance Workflow

**File:** `composer.json` - Quality scripts
**Description:** Streamlined commands for code quality and testing

```json
{
  "scripts": {
    "test": [
      "@php artisan config:clear --ansi",
      "@php artisan test"
    ],
    "cs": [
      "pint",
      "npm run prettier"
    ],
    "pint": "pint --parallel",
    "stan": "phpstan analyse -c phpstan.neon"
  }
}
```

### Development Best Practices

- **Hot Reload:** Vite 7.x provides instant asset updates during development
- **Concurrent Services:** Single `composer dev` command starts all required services
- **Code Quality:** Automated formatting with Pint and static analysis with PHPStan Level 8
- **Asset Optimization:** Tailwind v4 delivers smaller bundles and faster compilation
- **Testing Integration:** Unified test suite with database setup and fixtures

---

## Anti-patterns to Avoid

- Placing business logic in views
- Skipping authorization checks in controllers/components
- Not validating user input
- Duplicating code across models/controllers
- Ignoring test coverage for new features

---

## Conclusion

These exemplars represent the coding standards and architectural patterns of the project. Refer to them when implementing new features, refactoring, or onboarding. Maintain consistency by following these patterns and avoiding noted anti-patterns.
