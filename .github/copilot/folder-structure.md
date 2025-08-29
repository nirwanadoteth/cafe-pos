# Project Folder Structure Blueprint - Cafe POS System

**Last Updated:** August 29, 2025
**Project Type:** Laravel 12 + Filament 4 + Tailwind CSS 4 Point of Sale System
**Architecture:** Layered Monolithic Web Application

## 1. Structural Overview

This is a modern **Laravel 12.1.1** Point of Sale (POS) system built with **Filament 4.x** admin panel framework. The project follows a **layered architectural approach** with clear separation of concerns between UI, business logic, and data layers.

### Core Architectural Principles

- **Domain-Driven Organization**: Features are organized by business domain (Orders, Products, Categories, Customers)
- **Component-Based UI Structure**: Filament components are extracted into reusable, testable classes
- **Service Layer Pattern**: Business logic is centralized in dedicated Service classes
- **Resource-Centric Navigation**: Admin interface is organized around CRUD resources with proper scoping

### Technology Stack Detection

- **Backend Framework**: Laravel 12.1.1 (PHP 8.2+)
- **Admin Panel**: Filament 4.x with Laravel Livewire
- **Frontend Build**: Vite 7.x with Tailwind CSS 4.1.12
- **Database**: SQLite (development/testing), configurable for production
- **Authentication**: Laravel Auth with Spatie Permissions via Filament Shield
- **File Management**: Spatie Media Library for product images
- **PDF Generation**: DOMPDF for invoice generation
- **Health Monitoring**: Spatie Laravel Health
- **Chart Data**: Flowframe Laravel Trend

## 2. Directory Visualization

```markdown
cafe-pos/
├── app/                           # Application core logic
│   ├── Casts/                     # Eloquent custom casts
│   │   └── MoneyCast.php          # Money handling (integer cents)
│   ├── Enums/                     # Business domain enums
│   │   └── OrderStatus.php        # Order status with Filament contracts
│   ├── Filament/                  # Filament admin panel components
│   │   ├── Clusters/              # Feature groupings (empty in current state)
│   │   ├── Exports/               # Data export definitions
│   │   ├── Imports/               # Data import definitions
│   │   ├── Pages/                 # Custom admin pages
│   │   ├── Resources/             # CRUD resource definitions
│   │   │   ├── Categories/        # Category management
│   │   │   ├── Orders/            # Order management
│   │   │   ├── Products/          # Product management
│   │   │   ├── Roles/             # Permission roles
│   │   │   └── Users/             # User management
│   │   └── Widgets/               # Dashboard widgets
│   ├── Helpers/                   # Utility classes and functions
│   │   ├── DateRange.php          # Value object for date ranges
│   │   └── helpers.php            # Global helper functions
│   ├── Http/                      # HTTP layer (minimal usage)
│   │   ├── Controllers/           # Traditional controllers (sparse)
│   │   └── Responses/             # Custom response types
│   ├── Livewire/                  # Livewire components
│   │   ├── Home.php               # Public-facing homepage
│   │   ├── Orders/                # Order-related components
│   │   └── Products/              # Product-related components
│   ├── Models/                    # Eloquent domain models
│   │   ├── Category.php           # Product categories
│   │   ├── Customer.php           # Customer information
│   │   ├── Order.php              # Order aggregates
│   │   ├── OrderItem.php          # Order line items
│   │   ├── Payment.php            # Payment records
│   │   ├── Product.php            # Product catalog
│   │   └── User.php               # System users
│   ├── Policies/                  # Authorization policies
│   ├── Providers/                 # Service providers
│   │   ├── AppServiceProvider.php # Main application services
│   │   └── Filament/              # Filament-specific providers
│   └── Services/                  # Business logic services
├── bootstrap/                     # Application bootstrap
├── config/                        # Configuration files
├── database/                      # Database layer
│   ├── database.sqlite            # Development database
│   ├── factories/                 # Model factories
│   ├── migrations/                # Schema migrations
│   └── seeders/                   # Data seeders
├── docs/                          # Project documentation
├── public/                        # Web-accessible assets
├── resources/                     # Frontend resources
│   ├── css/                       # Stylesheets
│   ├── js/                        # JavaScript files
│   ├── lang/                      # Internationalization
│   └── views/                     # Blade templates
├── routes/                        # Route definitions
├── storage/                       # File storage
├── tests/                         # Test suites
│   ├── Feature/                   # Integration tests
│   └── Unit/                      # Unit tests
└── vendor/                        # Composer dependencies
```

## 3. Key Directory Analysis

### 3.1 Filament Admin Panel Structure (`app/Filament/`)

The core admin interface follows Filament 4.x architectural patterns:

#### **Resources Organization**

- **Domain-Based Folders**: Each business domain has its own folder (`Categories/`, `Orders/`, `Products/`, `Users/`)
- **Component Separation**: Complex resources extract UI logic into `Components/` subdirectories
- **Page Customization**: Standard CRUD pages are customized in `Pages/` subdirectories

**Pattern Example**: `app/Filament/Resources/Products/`

```markdown
Products/
├── ProductResource.php          # Main resource definition
├── Components/                  # Reusable UI components
│   ├── ProductForm.php          # Form schema definition
│   ├── ProductTable.php         # Table configuration
│   └── ProductInfolist.php      # Detail view configuration
├── Pages/                       # Custom page implementations
│   ├── CreateProduct.php        # Creation page
│   ├── EditProduct.php          # Edit page
│   ├── ListProducts.php         # Listing page with widgets
│   └── ViewProduct.php          # View page
└── Widgets/                     # Resource-specific widgets
    └── ProductStats.php         # Product statistics widget
```

#### **Component Architecture Benefits**

- **Reusability**: Form schemas can be shared between create/edit pages
- **Testability**: Individual components can be unit tested
- **Maintainability**: Changes to UI logic are localized
- **Consistency**: Shared patterns across similar resources

### 3.2 Business Logic Layer (`app/Services/`)

Centralized business logic following the Service Layer pattern:

- **`StatsOverviewCalculator.php`**: Dashboard statistics computation
- **`ChartDataService.php`**: Chart data aggregation with Laravel Trend
- **`OrderCalculationService.php`**: Order totals and tax calculations
- **`OrderFormValidator.php`**: Business rule validation
- **`DateRangeService.php`**: Date period handling and comparisons
- **`AuthenticationService.php`**: Authentication workflow management
- **`EnvironmentService.php`**: Environment detection utilities
- **`FilamentConfigurationService.php`**: Dynamic Filament configuration

**Service Delegation Pattern**: Filament components delegate complex logic to services, keeping UI classes thin and focused.

### 3.3 Domain Model Layer (`app/Models/`)

Rich domain models with comprehensive type annotations:

#### **Model Characteristics**

- **Comprehensive PHPDoc**: Full property type documentation with relationships
- **Custom Casts**: Money handling via `MoneyCast` (stores as integer cents)
- **Enum Integration**: Status fields use enum classes with Filament contracts
- **Soft Deletes**: Key models support soft deletion (Orders)
- **Factory Support**: All models have corresponding factories for testing

**Example Model Structure**:

```php
/**
 * @property int $id
 * @property int|null $customer_id
 * @property string $number
 * @property float|null $total_price
 * @property OrderStatus $status
 * @property-read Customer|null $customer
 * @property-read Collection<int, OrderItem> $items
 * @property-read Payment|null $payment
 */
class Order extends Model
{
    protected $casts = [
        'total_price' => MoneyCast::class,
        'status' => OrderStatus::class,
    ];
}
```

### 3.4 Frontend Asset Management (`resources/`, `public/`)

Modern frontend toolchain with Vite 7.x:

#### **Asset Organization**

- **`resources/css/`**: Tailwind CSS 4.x stylesheets with PostCSS nesting
- **`resources/js/`**: JavaScript modules (ES modules only)
- **`resources/views/`**: Blade templates (minimal, mostly Filament-driven)
- **`resources/lang/`**: Internationalization files with translation keys
- **`public/`**: Compiled assets and static files

#### **Build Configuration**

```javascript
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'app/Filament/**',     // Auto-reload on Filament changes
                'app/Livewire/**',     // Auto-reload on Livewire changes
                'app/Forms/Components/**',
                'app/Infolists/Components/**',
            ],
        }),
        tailwindcss(),  // Tailwind CSS 4.x integration
    ],
});
```

### 3.5 Testing Infrastructure (`tests/`)

Comprehensive testing setup with PHPUnit:

#### **Test Organization**

- **`tests/Unit/`**: Pure logic testing (Services, Helpers, Casts)
- **`tests/Feature/`**: HTTP and database integration tests
- **In-Memory SQLite**: Fast test database configured in `phpunit.xml`
- **`RefreshDatabase`**: Trait usage for feature tests

#### **Test Configuration**

```xml
<!-- phpunit.xml -->
<env name="APP_ENV" value="testing"/>
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
<env name="CACHE_DRIVER" value="array"/>
<env name="SESSION_DRIVER" value="array"/>
<env name="MAIL_DRIVER" value="array"/>
```

## 4. File Placement Patterns

### 4.1 Configuration Files

- **Framework Config**: `config/app.php`, `config/database.php`, etc.
- **Filament Config**: `config/filament.php`, `config/filament-shield.php`
- **Package Config**: Published configurations in `config/`
- **Environment Config**: `.env` files for environment-specific settings

### 4.2 Model and Entity Definitions

- **Domain Models**: `app/Models/{DomainName}.php`
- **Enums**: `app/Enums/{BusinessConcept}.php` with Filament contracts
- **Custom Casts**: `app/Casts/{CastName}.php` for data transformation
- **Value Objects**: `app/Helpers/{ValueObject}.php` for domain concepts

### 4.3 Business Logic Placement

- **Service Classes**: `app/Services/{DomainName}Service.php`
- **Form Validators**: `app/Services/{DomainName}FormValidator.php`
- **Calculation Logic**: `app/Services/{DomainName}Calculator.php`
- **Data Aggregation**: `app/Services/{DomainName}DataService.php`

### 4.4 UI Component Organization

- **Filament Resources**: `app/Filament/Resources/{Domain}/{DomainName}Resource.php`
- **Resource Components**: `app/Filament/Resources/{Domain}/Components/{ComponentType}.php`
- **Custom Pages**: `app/Filament/Pages/{PageName}.php`
- **Widgets**: `app/Filament/Widgets/{WidgetName}.php`
- **Livewire Components**: `app/Livewire/{Domain}/{ComponentName}.php`

### 4.5 Test File Organization

- **Unit Tests**: `tests/Unit/{Domain}/{ClassName}Test.php`
- **Feature Tests**: `tests/Feature/{Domain}/{FeatureName}Test.php`
- **Test Utilities**: `tests/TestCase.php` for shared test functionality

## 5. Naming and Organization Conventions

### 5.1 File Naming Patterns

- **Classes**: PascalCase (`OrderCalculationService`, `ProductResource`)
- **Files**: Match class names exactly (`OrderCalculationService.php`)
- **Directories**: PascalCase for namespaces (`Products/`, `Categories/`)
- **Database Files**: snake_case (`create_orders_table.php`)

### 5.2 Component Naming Conventions

- **Resources**: `{Domain}Resource.php` (`ProductResource`, `OrderResource`)
- **Components**: `{Domain}{ComponentType}.php` (`ProductForm`, `OrderTable`)
- **Services**: `{Domain}{Purpose}Service.php` or `{Purpose}Calculator.php`
- **Pages**: `{Action}{Domain}.php` (`CreateProduct`, `ListOrders`)
- **Widgets**: `{Purpose}Widget.php` (`StatsOverviewWidget`, `LatestOrders`)

### 5.3 Translation Key Patterns

- **Resource Labels**: `resources/{domain}.{field}` (`resources/order.status`)
- **Navigation**: `navigation.group.{group_name}` (`navigation.group.catalog`)
- **Widgets**: `widgets/{widget-name}.{key}` (`widgets/stats-overview.revenue`)
- **Actions**: `actions.{action_name}` (`actions.create`, `actions.edit`)

### 5.4 Database Conventions

- **Table Names**: snake_case plural (`orders`, `order_items`, `product_categories`)
- **Column Names**: snake_case (`total_price`, `created_at`, `is_visible`)
- **Foreign Keys**: `{table}_id` (`customer_id`, `product_id`)
- **Pivot Tables**: `{table1}_{table2}` alphabetically ordered

## 6. Navigation and Development Workflow

### 6.1 Entry Points

- **Application Entry**: `public/index.php` → `bootstrap/app.php`
- **Admin Panel**: Configured in `app/Providers/Filament/AdminPanelProvider.php`
- **API Routes**: `routes/api.php` (minimal usage in this project)
- **Web Routes**: `routes/web.php` (mainly for Livewire public components)

### 6.2 Common Development Tasks

#### **Adding a New Resource**

1. Create model in `app/Models/{Domain}.php`
2. Generate migration in `database/migrations/`
3. Create resource in `app/Filament/Resources/{Domain}/`
4. Extract components to `Components/` subdirectory
5. Add policies in `app/Policies/{Domain}Policy.php`
6. Create tests in `tests/Feature/{Domain}/` and `tests/Unit/{Domain}/`

#### **Adding Business Logic**

1. Create service in `app/Services/{Purpose}Service.php`
2. Register in `AppServiceProvider` if needed
3. Inject into Filament components or Livewire components
4. Add unit tests in `tests/Unit/Services/`

#### **Extending UI Components**

1. Create component class in `app/Filament/Resources/{Domain}/Components/`
2. Use static methods for schema definition (`getSchema()`, `getColumns()`)
3. Import and use in Resource classes
4. Add widget support in `app/Filament/Widgets/` if needed

### 6.3 Dependency Flow Patterns

```markdown
Filament UI Layer
       ↓
Service Layer (Business Logic)
       ↓
Model Layer (Domain Objects)
       ↓
Database Layer
```

**Import Patterns**:

- UI components import Services for business logic
- Services import Models for data access
- Models are isolated and don't import Services
- Tests can import any layer for verification

## 7. Build and Output Organization

### 7.1 Build Configuration

- **Vite Config**: `vite.config.js` with Laravel plugin and Tailwind integration
- **Package Scripts**: `package.json` defines build and development commands
- **Composer Scripts**: Custom scripts in `composer.json` for development workflow

### 7.2 Development Scripts

```json
// composer.json scripts
{
    "dev": "concurrently \"php artisan serve\" \"php artisan queue:listen\" \"php artisan pail\" \"npm run dev\"",
    "pint": "pint --config=pint.json",
    "stan": "phpstan analyse --memory-limit=2G",
    "test": "php artisan config:clear && php artisan test"
}
```

### 7.3 Output Structure

- **Compiled Assets**: `public/build/` (generated by Vite)
- **Storage**: `storage/app/` for file uploads
- **Logs**: `storage/logs/` for application logs
- **Cache**: `bootstrap/cache/` for optimized files

### 7.4 Environment-Specific Configuration

- **Development**: `.env` with local database and debugging enabled
- **Testing**: Environment variables in `phpunit.xml`
- **Production**: Environment-specific `.env` with optimizations

## 8. Laravel + Filament Specific Organization

### 8.1 Laravel 12 Structure Patterns

#### **Service Container Usage**

- Services are auto-discovered through constructor injection
- Complex dependencies are resolved in `AppServiceProvider`
- Filament components receive services through constructor injection

#### **Eloquent Patterns**

```php
// Model with comprehensive annotations
/**
 * @property-read BelongsTo<Category,$this> $category
 * @property-read HasMany<OrderItem> $items
 */
class Order extends Model
{
    protected $casts = [
        'total_price' => MoneyCast::class,
        'status' => OrderStatus::class,
    ];
}
```

#### **Event-Driven Architecture**

- Model events in `boot()` methods for business logic
- Service delegation from model observers
- Queue integration for background processing

### 8.2 Filament 4 Architecture Patterns

#### **Resource Structure**

```php
class ProductResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema(ProductForm::getSchema());
    }

    public static function table(Table $table): Table
    {
        return ProductTable::getTable($table);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return ProductInfolist::getInfolist($infolist);
    }
}
```

#### **Component Extraction Pattern**

- Form schemas in `{Domain}Form::getSchema()`
- Table definitions in `{Domain}Table::getColumns()`
- Info lists in `{Domain}Infolist::getComponents()`
- Separation enables reusability and testing

#### **Widget Integration**

- Dashboard widgets in `app/Filament/Widgets/`
- Resource-specific widgets in resource directories
- Service delegation for data computation
- Permission integration with Filament Shield

### 8.3 Permission and Security Patterns

#### **Filament Shield Integration**

```php
// config/filament-shield.php
'permission_prefixes' => [
    'resource' => [
        'view', 'view_any', 'create', 'update',
        'restore', 'restore_any', 'delete', 'delete_any'
    ],
],
```

#### **Policy Organization**

- Standard Laravel policies in `app/Policies/`
- Resource-specific policies following Filament Shield conventions
- Shield contracts implementation on resources

## 9. Extension and Evolution Patterns

### 9.1 Adding New Features

#### **New Domain Template**

```markdown
app/Filament/Resources/{NewDomain}/
├── {NewDomain}Resource.php
├── Components/
│   ├── {NewDomain}Form.php
│   ├── {NewDomain}Table.php
│   └── {NewDomain}Infolist.php
├── Pages/
│   ├── Create{NewDomain}.php
│   ├── Edit{NewDomain}.php
│   ├── List{NewDomains}.php
│   └── View{NewDomain}.php
└── Widgets/
    └── {NewDomain}Stats.php
```

#### **Service Layer Extension**

1. Create service in `app/Services/{NewDomain}Service.php`
2. Add validation service if complex rules exist
3. Create calculator service for computational logic
4. Register service bindings in `AppServiceProvider`

### 9.2 Scalability Patterns

#### **Component Composition**

- Extract reusable form sections into separate classes
- Create base component classes for common patterns
- Use traits for shared functionality across components

#### **Service Composition**

- Break large services into focused smaller services
- Use service contracts for complex integrations
- Implement repository pattern for complex data access

### 9.3 Internationalization Scaling

- Language files organized by domain in `resources/lang/`
- Translation keys follow consistent patterns
- Pluralization support for dynamic content
- Region-specific formatting for numbers and dates

## 10. Structure Templates

### 10.1 New Resource Template

```php
// app/Filament/Resources/{Domain}/{Domain}Resource.php
<?php

namespace App\Filament\Resources\{Domain};

use App\Filament\Resources\{Domain}\Components\{Domain}Form;
use App\Filament\Resources\{Domain}\Components\{Domain}Table;
use App\Filament\Resources\{Domain}\Components\{Domain}Infolist;
use App\Models\{Domain};
use Filament\Resources\Resource;

class {Domain}Resource extends Resource
{
    protected static ?string $model = {Domain}::class;

    public static function form(Form $form): Form
    {
        return $form->schema({Domain}Form::getSchema());
    }

    public static function table(Table $table): Table
    {
        return {Domain}Table::getTable($table);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return {Domain}Infolist::getInfolist($infolist);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\List{Domain}s::route('/'),
            'create' => Pages\Create{Domain}::route('/create'),
            'view' => Pages\View{Domain}::route('/{record}'),
            'edit' => Pages\Edit{Domain}::route('/{record}/edit'),
        ];
    }
}
```

### 10.2 Service Class Template

```php
// app/Services/{Domain}Service.php
<?php

namespace App\Services;

use App\Models\{Domain};
use Illuminate\Database\Eloquent\Collection;

class {Domain}Service
{
    public function __construct(
        private {Domain}Calculator $calculator,
        private {Domain}Validator $validator,
    ) {}

    public function create(array $data): {Domain}
    {
        $this->validator->validate($data);

        return {Domain}::create($data);
    }

    public function update({Domain} ${domain}, array $data): {Domain}
    {
        $this->validator->validate($data);

        ${domain}->update($data);

        return ${domain};
    }
}
```

### 10.3 Component Template

```php
// app/Filament/Resources/{Domain}/Components/{Domain}Form.php
<?php

namespace App\Filament\Resources\{Domain}\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class {Domain}Form
{
    /**
     * @return array<Component>
     */
    public static function getSchema(): array
    {
        return [
            static::getDetailsSection(),
            static::getStatusSection(),
        ];
    }

    protected static function getDetailsSection(): Section
    {
        return Section::make(__('resources/{domain}.details'))
            ->schema([
                static::getNameField(),
            ]);
    }

    protected static function getNameField(): TextInput
    {
        return TextInput::make('name')
            ->label(__('resources/{domain}.name'))
            ->required()
            ->maxLength(255);
    }
}
```

### 10.4 Test Structure Template

```php
// tests/Feature/{Domain}/{Domain}ResourceTest.php
<?php

namespace Tests\Feature\{Domain};

use App\Models\{Domain};
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class {Domain}ResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_can_list_{domain}s(): void
    {
        {Domain}::factory()->count(3)->create();

        $response = $this->get('/admin/{domains}');

        $response->assertSuccessful();
    }

    public function test_can_create_{domain}(): void
    {
        $data = {Domain}::factory()->make()->toArray();

        $response = $this->post('/admin/{domains}', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('{domains}', $data);
    }
}
```

## 11. Structure Enforcement and Maintenance

### 11.1 Automated Quality Checks

#### **Code Style Enforcement**

```json
// pint.json
{
    "preset": "laravel",
    "rules": {
        "blank_line_before_statement": {
            "statements": ["return", "throw", "try"]
        },
        "method_argument_space": {
            "on_multiline": "ensure_fully_multiline"
        }
    }
}
```

#### **Static Analysis**

```neon
# phpstan.neon
parameters:
    level: 8
    paths:
        - app
    excludePaths:
        - app/Http/Middleware/Authenticate.php
    ignoreErrors:
        - '#Access to an undefined property#'
```

### 11.2 Development Workflow

#### **Pre-commit Checks**

1. Code formatting with Laravel Pint
2. Static analysis with PHPStan
3. Test suite execution
4. Security vulnerability scanning

#### **Documentation Maintenance**

- Architecture decisions recorded in `docs/`
- README updates for major structural changes
- Component documentation in class docblocks
- API documentation generated from code

### 11.3 Structural Validation

#### **Namespace Validation**

- PSR-4 autoloading enforces directory structure
- IDE inspections catch namespace mismatches
- Composer validation ensures proper autoloading

#### **Dependency Analysis**

- Services should not depend on UI components
- Models should not import Services
- Policies should only depend on Models
- Tests can import any layer for verification

---

## Summary

This Laravel + Filament POS system follows modern PHP development practices with clear architectural boundaries:

- **UI Layer**: Filament Resources with extracted Components
- **Service Layer**: Business logic in dedicated Service classes
- **Domain Layer**: Rich Models with comprehensive type annotations
- **Infrastructure Layer**: Database, storage, and external services

The structure supports rapid feature development while maintaining code quality through:

- Consistent naming conventions
- Service delegation patterns
- Component extraction for reusability
- Comprehensive testing infrastructure
- Automated quality enforcement

**Key Success Factors:**

1. Extract complex UI logic into Components
2. Delegate business logic to Services
3. Use comprehensive type annotations
4. Follow established naming patterns
5. Maintain clear architectural boundaries

This blueprint should be reviewed and updated as the project evolves and new patterns emerge.
