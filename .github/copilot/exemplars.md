# Code Exemplars - Cafe POS System

## Introduction

This document identifies high-quality, representative code examples from the Cafe POS codebase that demonstrate our coding standards, architectural patterns, and best practices. These exemplars serve as references for maintaining consistency across the development team and provide guidance for implementing new features that align with existing patterns.

The project is built on **Laravel 12** with **Filament 4** admin panel, following a layered architecture with clear separation of concerns between presentation, business logic, and data access layers.

## Table of Contents

1. [Domain Models](#domain-models)
2. [Business Services](#business-services)
3. [Filament Resources](#filament-resources)
4. [UI Components](#ui-components)
5. [Enum Implementations](#enum-implementations)
6. [Custom Casts](#custom-casts)
7. [Widget Patterns](#widget-patterns)
8. [Provider Configuration](#provider-configuration)
9. [Architecture Observations](#architecture-observations)

---

## Domain Models

### 1. Order Model - Complete Domain Entity

**File:** `app/Models/Order.php`

**Why Exemplary:** Demonstrates comprehensive domain modeling with proper PHPDoc annotations, relationships, casts, and model events.

**Key Implementation Details:**

- Complete PHPDoc with all properties and relationships typed
- Proper use of custom casts (`MoneyCast`) for money handling
- Eloquent relationships with full type annotations: `@return BelongsTo<Customer,$this>`
- Model events for business logic delegation to services
- Soft deletes implementation

```php
/**
 * @property int $id
 * @property int|null $customer_id
 * @property string $number
 * @property float|null $total_price
 * @property OrderStatus $status
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Customer|null $customer
 * @property-read Collection<int, OrderItem> $items
 * @property-read int|null $items_count
 * @property-read Payment|null $payment
 */
class Order extends Model
{
    protected static function booted(): void
    {
        static::saving(static function (Order $order): void {
            $order->total_price = OrderCalculationService::calculateTotalPrice($order);
        });
        static::deleting(function (Order $order) {
            OrderCalculationService::handleOrderDeletion($order);
        });
    }

    /** @return BelongsTo<Customer,$this> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
```

---

## Business Services

### 2. OrderCalculationService - Clean Business Logic

**File:** `app/Services/OrderCalculationService.php`

**Why Exemplary:** Demonstrates the service layer pattern for extracting business logic from models, with clear responsibilities and static methods.

**Key Implementation Details:**

- Single responsibility principle - handles only order calculations
- Static methods for utility-style operations
- Clear method documentation
- Separation of concerns from the model layer

```php
class OrderCalculationService
{
    /**
     * Calculate total price for an order based on its items
     */
    public static function calculateTotalPrice(Order $order): float
    {
        return (float) $order->items()
            ->selectRaw('COALESCE(SUM(qty * unit_price), 0) as total')
            ->value('total');
    }

    /**
     * Handle order deletion cleanup
     */
    public static function handleOrderDeletion(Order $order): void
    {
        $order->payment()->delete();
    }
}
```

### 3. ChartDataService - Resource-Scoped Data Service

**File:** `app/Services/ChartDataService.php`

**Why Exemplary:** Shows proper use of Filament resource scoping with flowframe/laravel-trend for chart data generation.

**Key Implementation Details:**

- Uses `OrderResource::getEloquentQuery()` for proper Filament scoping instead of direct model queries
- Filters cancelled orders consistently: `->where('status', '!=', 'cancelled')`
- Leverages flowframe/laravel-trend for time-series data
- Clear return type annotations

```php
public static function getOrdersChartData(): array
{
    return self::buildTrendData(
        Trend::query(OrderResource::getEloquentQuery()->where('status', '!=', 'cancelled')),
        now()->startOfYear(),
        now()->endOfYear()
    );
}
```

---

## Filament Resources

### 4. OrderResource - Complete Resource Implementation

**File:** `app/Filament/Resources/Orders/OrderResource.php`

**Why Exemplary:** Demonstrates comprehensive Filament resource implementation with proper shield permissions, navigation configuration, and resource scoping.

**Key Implementation Details:**

- Implements `HasShieldPermissions` for authorization
- Uses component delegation pattern for forms and tables
- Proper navigation configuration with badges
- Eloquent query scoping for soft deletes
- Global search implementation with relationships

```php
class OrderResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Order::class;
    protected static ?string $recordTitleAttribute = 'number';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-bag';

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;
        return (string) $modelClass::where('status', 'new')->count();
    }

    /** @return Builder<Order> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
```

---

## UI Components

### 5. OrderForm Component - Modular Form Builder

**File:** `app/Filament/Resources/Orders/Components/OrderForm.php`

**Why Exemplary:** Shows the component separation pattern with static schema methods and proper business logic delegation.

**Key Implementation Details:**

- Static `getSchema()` method for reusable form components
- Delegates validation to `OrderFormValidator` service
- Uses translation keys for all user-facing strings
- Complex form logic with repeaters and dynamic sections
- Proper component organization and separation of concerns

```php
class OrderForm
{
    /**
     * @return array<Component>
     */
    public static function getSchema(): array
    {
        return [
            Group::make()
                ->schema([
                    Section::make(__('resources/order.details'))
                        ->schema(static::getDetailsFormSchema()),
                    Section::make(__('resources/order.items'))
                        ->schema([static::getItemsRepeater()]),
                ])
                ->columnSpan(['lg' => fn (?Order $record) => $record === null ? 3 : 2]),
        ];
    }
}
```

### 6. ProductTable Component - Advanced Table Configuration

**File:** `app/Filament/Resources/Products/Components/ProductTable.php`

**Why Exemplary:** Demonstrates advanced table features including filters, actions, bulk actions, and grouping.

**Key Implementation Details:**

- Comprehensive filter implementation with constraints
- Proper action and bulk action configuration
- Table grouping functionality
- Consistent filter layout configuration
- Return type annotations for all methods

```php
public static function getFilters(): array
{
    return [
        SelectFilter::make('category')
            ->relationship('category', 'name')
            ->searchable()
            ->preload(),

        ConstraintsFilter::make([
            NumberConstraint::make('price')
                ->label(__('resources/product.price'))
                ->icon('heroicon-m-currency-dollar'),
            BooleanConstraint::make('is_visible')
                ->label(__('resources/product.visibility')),
        ])
        ->constraintPickerColumns(2)
    ];
}
```

---

## Enum Implementations

### 7. OrderStatus Enum - Filament-Integrated Enum

**File:** `app/Enums/OrderStatus.php`

**Why Exemplary:** Perfect example of enum implementation with Filament contracts for UI integration.

**Key Implementation Details:**

- Implements `HasColor`, `HasIcon`, `HasLabel` for Filament integration
- Uses match expressions for enum methods
- Consistent color and icon patterns
- Proper string backing values

```php
enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{
    case New = 'new';
    case Processing = 'processing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getColor(): string
    {
        return match ($this) {
            self::New => 'info',
            self::Processing => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }
}
```

---

## Custom Casts

### 8. MoneyCast - Money Handling Pattern

**File:** `app/Casts/MoneyCast.php`

**Why Exemplary:** Demonstrates proper money handling by storing cents as integers and casting to floats for application use.

**Key Implementation Details:**

- Implements `CastsAttributes` with proper type annotations
- Converts between cents (storage) and dollars (application)
- Proper rounding for precision
- Clear documentation of the conversion process

```php
/**
 * @implements CastsAttributes<float, float>
 */
class MoneyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): float
    {
        // Transform the integer stored in the database into a float.
        return round((float) $value / 100, precision: 2);
    }

    public function set($model, string $key, $value, array $attributes): float
    {
        // Transform the float into an integer for storage.
        return round((float) $value * 100);
    }
}
```

---

## Widget Patterns

### 9. OrdersChart Widget - Service-Delegated Widget

**File:** `app/Filament/Widgets/OrdersChart.php`

**Why Exemplary:** Shows the widget delegation pattern where complex logic is extracted to services.

**Key Implementation Details:**

- Delegates data processing to `ChartDataService`
- Uses translation keys for all labels
- Clean, focused widget class with minimal logic
- Proper chart type configuration

```php
class OrdersChart extends ChartWidget
{
    protected static ?int $sort = 1;

    public function getHeading(): string | Htmlable | null
    {
        return __('widgets/orders-chart.heading');
    }

    protected function getData(): array
    {
        $data = ChartDataService::getOrdersChartData();
        return ChartDataService::buildChartResponse(
            $data,
            __('widgets/orders-chart.datasets.label'),
            __('widgets/orders-chart.labels')
        );
    }
}
```

### 10. StatsOverviewWidget - Filter-Aware Dashboard Widget

**File:** `app/Filament/Widgets/StatsOverviewWidget.php`

**Why Exemplary:** Demonstrates advanced widget features including page filter integration and value object usage.

**Key Implementation Details:**

- Uses `InteractsWithPageFilters` trait for dashboard filtering
- Leverages `DateRange` value object for date calculations
- Delegates complex calculations to `StatsOverviewCalculator`
- Proper money formatting with `Number` facade

---

## Provider Configuration

### 11. AdminPanelProvider - Comprehensive Panel Setup

**File:** `app/Providers/Filament/AdminPanelProvider.php`

**Why Exemplary:** Shows complete Filament panel configuration with all essential features and security considerations.

**Key Implementation Details:**

- Complete middleware stack configuration
- Plugin registration (FilamentShield, Health)
- Navigation group setup with translations
- Color scheme and UI customization
- SPA and profile page configuration

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('')
        ->login()
        ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
        ->navigationGroups([
            NavigationGroup::make()
                ->label(__('navigation.group.catalog')),
            NavigationGroup::make()
                ->label(__('navigation.group.transactions')),
        ])
        ->plugins([
            FilamentShieldPlugin::make(),
            FilamentSpatieLaravelHealthPlugin::make(),
        ])
        ->spa();
}
```

---

## Architecture Observations

### Consistency Patterns

1. **Translation Keys**: All user-facing strings use translation keys following the pattern `__('resources/model.field')` and `__('navigation.group.name')`

2. **Service Delegation**: Complex business logic is consistently extracted to `app/Services/*` classes, keeping UI components thin

3. **Money Handling**: Consistent use of `MoneyCast` for all monetary values, storing as integer cents

4. **Resource Scoping**: Always use `OrderResource::getEloquentQuery()` instead of direct model queries for proper Filament scoping

5. **Component Organization**: Forms, tables, and infolists are separated into dedicated component classes under `Resources/*/Components/`

### Architectural Principles

1. **Layered Architecture**: Clear separation between presentation (Filament), business logic (Services), and data (Models)

2. **Service Delegation Pattern**:
   - Widgets delegate to calculation services
   - Forms delegate validation to validator services
   - Models delegate complex operations to dedicated services

3. **Value Objects**: Use of `DateRange` for encapsulating date range logic

4. **Enum Integration**: Enums implement Filament contracts for seamless UI integration

### Implementation Conventions

1. **Naming**: PascalCase for classes, camelCase for methods, snake_case for database fields
2. **Documentation**: Comprehensive PHPDoc with complete type information and relationships
3. **Return Types**: Explicit return type declarations on all methods
4. **Relationship Types**: Full generic type annotations: `@return BelongsTo<Category,$this>`

### Anti-patterns to Avoid

1. **Direct Model Queries**: Never use `Order::query()` in dashboard widgets; always use `OrderResource::getEloquentQuery()`
2. **Hardcoded Strings**: Avoid hardcoded user-facing text; always use translation keys
3. **Fat Components**: Don't put business logic directly in Filament components; extract to services
4. **Missing Type Information**: Always include complete PHPDoc with property types and relationships

---

## Conclusion

These exemplars represent the established patterns and standards for the Cafe POS system. When implementing new features:

1. **Follow the Service Delegation Pattern**: Extract business logic to dedicated service classes
2. **Use Component Separation**: Organize Filament components into dedicated classes with static schema methods
3. **Maintain Type Safety**: Include comprehensive PHPDoc with complete type information
4. **Leverage Resource Scoping**: Always use resource queries for proper Filament authorization and scoping
5. **Implement Proper Money Handling**: Use `MoneyCast` and format with `Number` facade
6. **Follow Translation Patterns**: Use consistent translation key naming conventions

The codebase demonstrates mature Laravel and Filament patterns that should be maintained for consistency and maintainability.
