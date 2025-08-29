# Technology Stack Blueprint - Cafe POS System

## Executive Summary

This comprehensive technology stack blueprint analyzes the Cafe POS system to provide implementation-ready guidance for consistent code generation. The system is built on Laravel 12.x with Filament 4.x for the admin interface, using PHP 8.2+ with modern features and following established architectural patterns.

## 1. Core Technology Stack Analysis

### PHP Backend Stack

**Primary Framework**: Laravel 12.1.1

- **PHP Version**: ^8.2 (production ready, CI uses 8.4)
- **Framework Features**:
  - Modern Laravel 12 features and syntax
  - Eloquent ORM with comprehensive type annotations
  - Service container with dependency injection
  - Artisan CLI with custom commands
  - Event-driven architecture

**Key Dependencies & Versions**:

```json
{
  "laravel/framework": "^12.1.1",
  "filament/filament": "~4.0",
  "bezhansalleh/filament-shield": "^4.0.0-beta2",
  "barryvdh/laravel-dompdf": "^3.1.1",
  "flowframe/laravel-trend": "^0.4.0",
  "malzariey/filament-daterangepicker-filter": "^4.0.5",
  "shuvroroy/filament-spatie-laravel-health": "^3.0.0-beta1",
  "spatie/security-advisories-health-check": "^1.2"
}
```

### Frontend Technology Stack

**Build Tooling**: Vite 7.0

- **Module System**: ES modules (type: "module" in package.json)
- **CSS Framework**: Tailwind CSS 4.1.12
- **Processing**: PostCSS with nesting support
- **Hot Reload**: Laravel Vite plugin integration
- **Asset Management**: Automatic file watching and hot module replacement

**Frontend Dependencies**:

```json
{
  "@tailwindcss/vite": "^4.1.12",
  "tailwindcss": "^4.1.12",
  "vite": "^7.0",
  "laravel-vite-plugin": "^2.0.0",
  "postcss-nesting": "^13.0.2"
}
```

### Database & Storage

**Primary Database**: SQLite (development/default)

- **Production Options**: MySQL, PostgreSQL, MariaDB support configured
- **Migration System**: Laravel migrations with proper relationship constraints
- **Seeding**: Factory-based data generation with Faker
- **ORM**: Eloquent with advanced relationship mapping

**Cache & Session**:

- **Cache Driver**: Database (configurable to Redis/Memcached)
- **Session Driver**: Database (with file, Redis alternatives)
- **Queue System**: Database driver (sync for development)

## 2. Architecture Patterns & Design Principles

### Layered Architecture Implementation

#### 1. Presentation Layer (Filament UI)

```php
app/Filament/
├── Resources/           # CRUD resource definitions
│   ├── Orders/
│   │   ├── OrderResource.php
│   │   ├── Components/
│   │   │   ├── OrderForm.php      # Static schema methods
│   │   │   ├── OrderTable.php     # Static column/filter methods
│   │   │   └── OrderInfolist.php  # Static infolist methods
│   │   ├── Pages/
│   │   └── Widgets/
│   └── Products/
├── Widgets/            # Dashboard components
├── Pages/              # Custom pages
└── Clusters/           # Resource grouping
```

#### 2. Application Services Layer

```php
app/Services/
├── ChartDataService.php          # Chart data aggregation
├── DateRangeService.php          # Date handling utilities
├── OrderCalculationService.php   # Business logic calculations
├── OrderFormValidator.php        # Validation rules
├── OrderStatsCalculator.php      # Statistics computation
└── NotificationBodyBuilder.php   # Message formatting
```

#### 3. Domain Layer (Models)

```php
app/Models/
├── Order.php          # Core business entity
├── OrderItem.php      # Order line items
├── Product.php        # Catalog items
├── Category.php       # Product categorization
├── Customer.php       # Customer data
├── Payment.php        # Payment tracking
└── User.php          # System users
```

#### 4. Infrastructure Layer

```php
app/Casts/             # Data transformation
app/Enums/             # Type-safe constants
app/Providers/         # Service registration
app/Policies/          # Authorization rules
```

### Service Delegation Pattern

The system consistently delegates complex operations to dedicated services:

```php
// Stats Widget → Service
Filament\Widgets\StatsOverviewWidget::getStats() 
→ Services\OrderStatsCalculator::calculateStats()

// Chart Widget → Service  
Filament\Widgets\OrdersChart::getData()
→ Services\ChartDataService::getOrdersChartData()

// Form Validation → Service
Resources\Orders\Components\OrderForm::validation()
→ Services\OrderFormValidator::validate()

// Order Calculations → Service
Model\Order::saving()
→ Services\OrderCalculationService::calculateTotalPrice()
```

## 3. Implementation Patterns & Conventions

### Naming Conventions

**Classes & Types**:

- **PascalCase**: `OrderResource`, `ProductForm`, `OrderStatus`
- **Interfaces**: `HasShieldPermissions`, `CastsAttributes`
- **Enums**: `OrderStatus` with Filament contracts

**Methods & Properties**:

- **camelCase**: `calculateTotalPrice()`, `getOrdersChartData()`
- **Static Methods**: `OrderForm::getSchema()`, `OrderTable::getColumns()`

**Database Fields**:

- **snake_case**: `created_at`, `total_price`, `is_visible`
- **Foreign Keys**: `category_id`, `customer_id`, `order_id`

**File Organization**:

- **Namespaced Components**: `App\Filament\Resources\Orders\Components\OrderForm`
- **Grouped by Domain**: Orders, Products, Categories as primary domains

### Code Organization Patterns

**Filament Component Structure**:

```php
class OrderForm
{
    // Static schema definition methods
    public static function getSchema(): array
    {
        return [
            Group::make()->schema([
                static::getDetailsSection(),
                static::getItemsSection(),
            ])
        ];
    }

    // Private helper methods for schema building
    protected static function getDetailsSection(): Section { ... }
    protected static function getCustomerField(): Select { ... }
}
```

**Service Class Patterns**:

```php
class OrderCalculationService
{
    // Public static interface methods
    public static function calculateTotalPrice(Order $order): float { ... }
    public static function handleOrderDeletion(Order $order): void { ... }

    // Private calculation helpers
    private static function calculateItemTotal(...): float { ... }
}
```

**Model Enhancement Patterns**:

```php
class Order extends Model
{
    // Comprehensive PHPDoc with property types
    /**
     * @property int $id
     * @property float|null $total_price
     * @property OrderStatus $status
     * @property-read Customer|null $customer
     * @property-read Collection<int, OrderItem> $items
     */
    
    // Type-safe relationship definitions
    /** @return BelongsTo<Customer,$this> */
    public function customer(): BelongsTo { ... }
    
    /** @return HasMany<OrderItem,$this> */  
    public function items(): HasMany { ... }
    
    // Custom casts for data transformation
    protected $casts = [
        'total_price' => MoneyCast::class,
        'status' => OrderStatus::class,
    ];
}
```

### Error Handling & Validation

**Validation Through Services**:

```php
// Centralized validation logic
class OrderFormValidator
{
    public static function validate(array $data): array
    {
        // Business rule validation
        // Cross-field validation
        // Custom error messages
    }
}

// Used in Filament forms
Repeater::make('items')
    ->rules([
        function ($get, $set) {
            return OrderFormValidator::validateItems($get, $set);
        }
    ])
```

**Exception Handling**:

```php
// Model event handlers for cleanup
protected static function booted(): void
{
    static::saving(function (Order $order): void {
        $order->total_price = OrderCalculationService::calculateTotalPrice($order);
    });
    
    static::deleting(function (Order $order) {
        OrderCalculationService::handleOrderDeletion($order);
    });
}
```

## 4. Data Management Patterns

### Money Handling

**Storage Strategy**: Integer cents with custom cast

```php
class MoneyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): float
    {
        // Transform integer (cents) to float (dollars)
        return round((float) $value / 100, precision: 2);
    }
    
    public function set($model, string $key, $value, array $attributes): float
    {
        // Transform float (dollars) to integer (cents)
        return round((float) $value * 100);
    }
}
```

**Display Formatting**:

```php
// Using Laravel Number facade with IDR currency
TextColumn::make('total_price')
    ->money('IDR')  // Formats with "Rp" prefix
```

### Enum Implementation

**Filament Integration**:

```php
enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{
    case New = 'new';
    case Processing = 'processing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    
    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Processing => 'Processing',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }
    
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

### Date Range Handling

**Unified Date Processing**:

```php
class DateRangeService
{
    /**
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    public static function getCarbonInstancesFromDateString(?string $dateString): array
    {
        // Parse date strings into Carbon instances
        // Determine appropriate period label (perDay|perWeek|perMonth|perYear)
        // Return structured data for trend analysis
    }
}

// Value Object for type safety
readonly class DateRange
{
    public function __construct(
        public Carbon $start,
        public Carbon $end,
        public string $label
    ) {}
    
    public function previous(): self
    {
        // Calculate previous period for comparisons
    }
}
```

## 5. Filament 4.x Specific Patterns

### Resource Organization

**Component Separation**:

```php
// OrderResource.php - Main resource definition
class OrderResource extends Resource
{
    public static function form(Schema $schema): Schema
    {
        return $schema->components(OrderForm::getSchema());
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns(OrderTable::getColumns())
            ->filters(OrderTable::getFilters())
            ->recordActions(OrderTable::getActions());
    }
}

// Components/OrderForm.php - Form schema
class OrderForm
{
    public static function getSchema(): array
    {
        return [
            static::getDetailsSection(),
            static::getItemsSection(),
        ];
    }
}

// Components/OrderTable.php - Table configuration
class OrderTable
{
    public static function getColumns(): array { ... }
    public static function getFilters(): array { ... }
    public static function getActions(): array { ... }
}
```

### Widget Integration

**Stats Widgets with Service Delegation**:

```php
class OrderStats extends StatsOverviewWidget
{
    use InteractsWithPageTable;
    
    protected function getStats(): array
    {
        $baseQuery = $this->getPageTableQuery();
        $baseTrendQuery = OrderResource::getEloquentQuery();
        
        return OrderStatsCalculator::calculateStats($baseQuery, $baseTrendQuery);
    }
}
```

**Chart Widgets with Trend Integration**:

```php
class OrdersChart extends ChartWidget
{
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

### Resource Scoping Pattern

**Always Use Resource Queries**:

```php
// CORRECT: Uses proper Filament scoping
OrderResource::getEloquentQuery()->where('status', '!=', 'cancelled')

// INCORRECT: Bypasses Filament authorization
Order::query()->where('status', '!=', 'cancelled')
```

## 6. Development Workflow & Tools

### Code Quality Tools

**Laravel Pint Configuration**:

```json
{
    "preset": "laravel",
    "rules": {
        "blank_line_before_statement": true,
        "concat_space": {"spacing": "one"},
        "method_argument_space": true,
        "single_trait_insert_per_statement": true,
        "types_spaces": {"space": "single"}
    }
}
```

**PHPStan Configuration**:

```yaml
# phpstan.neon
includes:
    - ./vendor/larastan/larastan/extension.neon
    - ./vendor/phpstan/phpstan-deprecation-rules/rules.neon

parameters:
    paths: [app]
    level: 8
```

**Composer Scripts**:

```json
{
    "dev": "npx concurrently \"php artisan serve\" \"php artisan queue:listen\" \"php artisan pail\" \"npm run dev\"",
    "cs": ["pint", "npm run prettier"],
    "stan": "phpstan analyse -c phpstan.neon",
    "test": ["@php artisan config:clear", "@php artisan test"]
}
```

### Testing Configuration

**PHPUnit Setup**:

```xml
<!-- phpunit.xml -->
<phpunit>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="CACHE_STORE" value="array"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="MAIL_MAILER" value="array"/>
    </php>
</phpunit>
```

**Test Structure Patterns**:

```php
// Feature Tests - HTTP/Database interactions
class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_order(): void
    {
        // Test order creation workflow
    }
}

// Unit Tests - Pure logic testing
class OrderCalculationServiceTest extends TestCase
{
    public function test_calculates_total_price_correctly(): void
    {
        // Test calculation logic in isolation
    }
}
```

## 7. Translation & Internationalization

### Translation Key Patterns

**Resource Translations**:

```php
// Pattern: resources/{domain}.{key}
__('resources/order.single')      // "Order"
__('resources/order.plural')      // "Orders"
__('resources/order.nav.group')   // "Transactions"
__('resources/order.details')     // "Order Details"
```

**Widget Translations**:

```php
// Pattern: widgets/{widget-name}.{key}
__('widgets/latest-orders.heading')           // "Latest Orders"
__('widgets/orders-chart.datasets.label')    // "Orders"
```

**Navigation Translations**:

```php
// Pattern: navigation.group.{name}
__('navigation.group.catalog')    // "Catalog"
__('navigation.group.transactions') // "Transactions"
```

## 8. Security & Authorization

### Filament Shield Integration

**Permission Structure**:

```php
// Resource permissions
'view_order', 'view_any_order', 'create_order', 'update_order',
'delete_order', 'delete_any_order', 'force_delete_order',
'restore_order'

// Widget permissions
'widget_LatestOrders'

// Page permissions
'page_SalesReports', 'page_ProductReports'
```

**Role-Based Access**:

```php
// Seeded roles with specific permissions
'super_admin' => ['all permissions'],
'kasir' => ['view orders', 'create orders', 'sales reports'],
'inventaris' => ['manage products', 'manage categories']
```

## 9. Performance Patterns

### Database Query Optimization

**Relationship Loading**:

```php
// Eager loading for performance
$record = $record->load('customer', 'items.product', 'payment');

// Scoped queries with proper filtering
OrderResource::getEloquentQuery()
    ->where('status', '!=', 'cancelled')
    ->with(['customer', 'items.product'])
```

**Trend Data with Resource Scoping**:

```php
// Use flowframe/laravel-trend with proper scoping
Trend::query(OrderResource::getEloquentQuery())
    ->between(start: now()->subYear(), end: now())
    ->perMonth()
    ->count()
```

### Caching Strategy

**Configuration-Based Caching**:

```php
// config/cache.php
'default' => env('CACHE_STORE', 'database'),
'stores' => [
    'database' => ['driver' => 'database'],
    'redis' => ['driver' => 'redis'],
    'array' => ['driver' => 'array'], // Testing
]
```

## 10. Implementation Templates & Blueprints

### New Resource Creation Template

```php
// 1. Create Model with comprehensive PHPDoc
/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property-read Collection<int, RelatedModel> $relations
 */
class NewModel extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => MoneyCast::class,
        'is_active' => 'boolean',
    ];

    /** @return BelongsTo<ParentModel,$this> */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class);
    }
}

// 2. Create Resource with component delegation
class NewModelResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = NewModel::class;
    
    public static function form(Schema $schema): Schema
    {
        return $schema->components(NewModelForm::getSchema());
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns(NewModelTable::getColumns())
            ->filters(NewModelTable::getFilters())
            ->recordActions(NewModelTable::getActions());
    }
}

// 3. Create Component classes with static methods
class NewModelForm
{
    public static function getSchema(): array
    {
        return [
            static::getDetailsSection(),
            static::getAssociationsSection(),
        ];
    }
    
    protected static function getDetailsSection(): Section { ... }
}

class NewModelTable  
{
    public static function getColumns(): array { ... }
    public static function getFilters(): array { ... }
    public static function getActions(): array { ... }
}
```

### Service Class Template

```php
class NewModelService
{
    /**
     * Business logic method with comprehensive documentation
     *
     * @param  NewModel  $model
     * @return array<string, mixed>
     */
    public static function processBusinessLogic(NewModel $model): array
    {
        // Implement business rules
        // Handle calculations
        // Return structured data
    }
    
    /**
     * Private helper methods for complex operations
     */
    private static function calculateComplexValue(...): float
    {
        // Complex calculation logic
    }
}
```

### Widget Creation Template

```php
class NewModelStats extends StatsOverviewWidget
{
    use InteractsWithPageTable;
    
    protected function getStats(): array
    {
        $baseQuery = $this->getPageTableQuery();
        $baseTrendQuery = NewModelResource::getEloquentQuery();
        
        return NewModelStatsCalculator::calculateStats($baseQuery, $baseTrendQuery);
    }
}

class NewModelChart extends ChartWidget
{
    protected function getData(): array
    {
        $data = ChartDataService::getNewModelChartData();
        
        return ChartDataService::buildChartResponse(
            $data,
            __('widgets/new-model-chart.datasets.label'),
            __('widgets/new-model-chart.labels')
        );
    }
}
```

## 11. Key Dependencies & Integration Points

### Core Framework Dependencies

**Laravel 12.x Features Used**:

- Modern Eloquent with enhanced type support
- Service container with auto-wiring
- Event system with model observers
- Queue system for background processing
- Blade templating for PDF generation
- Artisan console with custom commands

**Filament 4.x Integration**:

- Resource-based CRUD operations
- Widget system for dashboards
- Form builder with advanced components
- Table builder with filtering/sorting
- Shield for role-based permissions
- Import/Export functionality

### Third-Party Service Integration

**PDF Generation**:

```php
// barryvdh/laravel-dompdf integration
Pdf::loadHtml(Blade::render('invoice', ['order' => $record]))
    ->stream()
```

**Health Monitoring**:

```php
// spatie/laravel-health integration
Health::checks([
    CacheCheck::new(),
    DatabaseCheck::new(),
    UsedDiskSpaceCheck::new()->warnWhenUsedSpaceIsAbovePercentage(70),
    // Additional checks configured in AppServiceProvider
])
```

**Trend Analysis**:

```php
// flowframe/laravel-trend integration
Trend::query(OrderResource::getEloquentQuery())
    ->between(start: $start, end: $end)
    ->perMonth()
    ->count()
```

## 12. Technology Decision Rationale

### Architecture Decisions

**Service Delegation Pattern**: Keeps Filament UI components thin while centralizing business logic in dedicated services for reusability and testability.

**Component Separation**: Separates Filament forms, tables, and infolists into dedicated classes with static methods for better organization and reuse.

**Resource Query Scoping**: Always uses `OrderResource::getEloquentQuery()` instead of direct model queries to ensure proper authorization and scoping.

**Money as Integer Cents**: Stores monetary values as integer cents to avoid floating-point precision issues while providing float interface through custom casts.

### Technology Choices

**SQLite for Development**: Simplifies setup and testing while supporting production databases (MySQL, PostgreSQL) without code changes.

**Filament 4.x**: Provides rapid admin interface development with modern UI components and extensive customization options.

**Vite 7.x**: Modern build tool with excellent hot module replacement and optimized production builds.

**Tailwind CSS 4.x**: Utility-first CSS framework with excellent Laravel integration and minimal bundle size.

## Conclusion

This technology stack blueprint provides comprehensive guidance for implementing features consistent with the established patterns in the Cafe POS system. The architecture emphasizes maintainability, performance, and developer productivity through clear separation of concerns, comprehensive type safety, and modern PHP/Laravel patterns.

Key implementation principles:

1. **Service Delegation**: Extract business logic to Services, keep UI components thin
2. **Resource Scoping**: Always use `Resource::getEloquentQuery()` for proper authorization
3. **Component Separation**: Split Filament resources into dedicated Form/Table/Infolist classes
4. **Type Safety**: Use comprehensive PHPDoc with complete type information
5. **Translation**: Use structured translation keys for all user-facing strings
6. **Money Handling**: Store as integer cents, display with Number facade
7. **Enum Contracts**: Implement Filament contracts for UI integration

This blueprint ensures new code follows established patterns while leveraging the full power of the Laravel 12 and Filament 4 ecosystem.
