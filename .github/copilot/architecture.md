# Project Architecture Blueprint - Cafe POS System

**Generated on:** August 29, 2025

## 1. Architecture Detection and Analysis

### Technology Stack

**Primary Framework**: Laravel 12.1.1 (PHP 8.2+)
**Admin Panel**: Filament 4.x
**Frontend**: Tailwind CSS 4.1.12, Vite 7.0
**Database**: SQLite (development), MySQL/MariaDB (production)
**Architectural Pattern**: Layered Architecture with Service-Oriented Business Logic

### Key Dependencies

- **UI Framework**: Filament 4.x with Shield for permissions
- **Data Visualization**: flowframe/laravel-trend for chart data
- **PDF Generation**: barryvdh/laravel-dompdf 3.1.1
- **Health Monitoring**: spatie/laravel-health
- **Static Analysis**: PHPStan Level 8, Laravel Pint

## 2. Architectural Overview

The Cafe POS system follows a **Layered Architecture** pattern with clear separation of concerns:

1. **UI Layer** (Filament Resources/Widgets) - User interface and presentation
2. **Application Service Layer** - Business logic orchestration
3. **Domain Layer** - Core business entities and rules
4. **Infrastructure Layer** - Data persistence and external services

The architecture emphasizes **Service Delegation** where complex business logic is extracted into dedicated service classes, keeping UI components thin and focused on presentation concerns.

### Guiding Principles

- **Separation of Concerns**: Clear boundaries between layers
- **Service Delegation**: Business logic centralized in Services
- **Type Safety**: Comprehensive PHPDoc with generic type annotations
- **Money Handling**: Integer cents storage with cast-based conversion
- **Resource Scoping**: Proper Filament resource queries for authorization

## 3. Architecture Visualization

```markdown
┌─────────────────────────────────────────────────────────────────┐
│                        UI LAYER                                 │
├─────────────────────────────────────────────────────────────────┤
│ Filament Resources    │ Filament Widgets   │ Livewire Components│
│ - OrderResource       │ - StatsOverview    │ - Home             │
│ - ProductResource     │ - OrdersChart      │ - Orders/*         │
│ - CategoryResource    │ - CustomersChart   │ - Products/*       │
│ - CustomerResource    │ - LatestOrders     │                    │
└─────────────────────────────────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────┐
│                    APPLICATION LAYER                            │
├─────────────────────────────────────────────────────────────────┤
│ Service Classes              │ Form Components                  │
│ - ChartDataService           │ - OrderForm                      │
│ - StatsOverviewCalculator    │ - OrderTable                     │
│ - OrderCalculationService    │ - ProductForm                    │
│ - OrderFormValidator         │ - ProductTable                   │
│ - DateRangeService           │                                  │
│ - EnvironmentService         │                                  │
└─────────────────────────────────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────┐
│                      DOMAIN LAYER                               │
├─────────────────────────────────────────────────────────────────┤
│ Core Models                  │ Enums & Value Objects            │
│ - Order (with soft deletes)  │ - OrderStatus (with Filament     │
│ - OrderItem                  │   contracts: HasColor, HasIcon,  │
│ - Product                    │   HasLabel)                      │
│ - Category                   │ - MoneyCast (integer cents)      │
│ - Customer                   │ - DateRange VO                   │
│ - Payment                    │                                  │
│ - User                       │                                  │
└─────────────────────────────────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────┐
│                   INFRASTRUCTURE LAYER                          │
├─────────────────────────────────────────────────────────────────┤
│ Data Persistence             │ External Services                │
│ - Eloquent ORM               │ - Mail (SMTP/Log)                │
│ - Migrations                 │ - Queue (Sync/Redis)             │
│ - Factories & Seeders        │ - Cache (File/Redis)             │
│ - SQLite/MySQL               │ - Storage (Local/S3)             │
│                              │ - PDF Generation (DomPDF)        │
│                              │ - Health Checks                  │
└─────────────────────────────────────────────────────────────────┘
```

## 4. Core Architectural Components

### 4.1 UI Layer Components

#### Filament Resources

- **Purpose**: CRUD interface generation for domain entities
- **Structure**: Resource classes delegate to Component classes for forms/tables
- **Pattern**: `OrderResource` → `Components/OrderForm.php`, `Components/OrderTable.php`
- **Interaction**: Static method delegation (`OrderForm::getSchema()`)
- **Extension**: Add new resources by following existing naming patterns

#### Filament Widgets

- **Purpose**: Dashboard data visualization and statistics
- **Structure**: Widget classes delegate to Service classes for data processing
- **Pattern**: `StatsOverviewWidget` → `StatsOverviewCalculator`
- **Interaction**: Service method calls with date range filtering
- **Extension**: Create new widgets by implementing BaseWidget and adding service delegates

#### Livewire Components

- **Purpose**: Interactive frontend components outside admin panel
- **Structure**: Component classes in `app/Livewire/`
- **Pattern**: Page-based organization (`Home.php`, `Orders/*`, `Products/*`)
- **Extension**: Follow Livewire conventions with Blade view templates

### 4.2 Application Service Layer

#### Chart Data Services

- **ChartDataService**: Centralized chart data generation using flowframe/laravel-trend
- **Responsibility**: Transform database queries into chart-ready arrays
- **Key Pattern**: Uses `OrderResource::getEloquentQuery()` for proper authorization scoping
- **Integration**: Called by widget classes for data visualization

#### Calculation Services

- **OrderCalculationService**: Order total calculation and lifecycle management
- **Responsibility**: Calculate totals, handle order deletion cleanup
- **Integration**: Called from `Order::saving()` and `Order::deleting()` model events
- **Pattern**: Static methods for stateless calculations

#### Validation Services

- **OrderFormValidator**: Centralized business rule validation
- **Responsibility**: Form validation logic separated from UI components
- **Integration**: Called from Filament form validation hooks
- **Extension**: Add new validation methods following existing patterns

#### Statistics Services

- **StatsOverviewCalculator**: Dashboard statistics with trend comparison
- **Responsibility**: Calculate current vs previous period metrics
- **Integration**: Used by `StatsOverviewWidget` for dashboard display
- **Pattern**: Trend calculation with configurable date ranges

### 4.3 Domain Layer

#### Core Models

**Order Model**:

- Soft deletes enabled
- Money casting via `MoneyCast`
- Status enum casting to `OrderStatus`
- Model events for calculation delegation
- Comprehensive PHPDoc with relationship types

**OrderItem Model**:

- Pivot table implementation
- Money casting for `unit_price`
- Model events trigger parent order updates
- Proper relationship documentation

**Product Model**:

- Visibility flags for catalog management
- Category relationships
- Factory support for testing

#### Value Objects and Enums

**OrderStatus Enum**:

- Implements Filament contracts: `HasColor`, `HasIcon`, `HasLabel`
- Match expressions for enum methods
- UI integration through Filament form components

**MoneyCast**:

- Integer cents storage (multiplied by 100)
- Float display conversion (divided by 100)
- Consistent money handling across the application

**DateRange Value Object**:

- Period comparison calculations
- Helper methods for Carbon date manipulation
- Label generation for UI display

## 5. Architectural Layers and Dependencies

### Layer Structure

```markdown
UI Layer (Filament/Livewire)
    ↓ delegates to
Application Layer (Services)
    ↓ orchestrates
Domain Layer (Models/Enums)
    ↓ persists via
Infrastructure Layer (Eloquent/External Services)
```

### Dependency Rules

1. **UI → Application**: UI components delegate complex logic to Services
2. **Application → Domain**: Services orchestrate domain model operations
3. **Domain → Infrastructure**: Models use Eloquent for persistence
4. **No Upward Dependencies**: Lower layers never depend on higher layers

### Abstraction Mechanisms

- **Service Classes**: Extract business logic from UI components
- **Model Events**: Decouple calculation logic from direct method calls
- **Resource Scoping**: `OrderResource::getEloquentQuery()` provides authorized query base
- **Casts**: Abstract storage format from domain representation

## 6. Data Architecture

### Domain Model Structure

```markdown
User (1) ──────┐
               │
Customer (1) ──┼── Order (N) ── OrderItem (N) ── Product (N)
               │      │                             │
               │      └── Payment (1)               │
               │                                    │
               └────────────────── Category (1) ────┘
```

### Entity Relationships

- **Order**: `belongsTo(Customer)`, `hasMany(OrderItem)`, `hasOne(Payment)`
- **OrderItem**: `belongsTo(Order)`, `belongsTo(Product)`
- **Product**: `belongsTo(Category)`, `hasMany(OrderItem)`
- **Customer**: `hasMany(Order)`

### Data Access Patterns

- **Repository Pattern**: Not explicitly implemented, uses Eloquent directly
- **Query Scoping**: Filament resources provide scoped query methods
- **Resource Queries**: `OrderResource::getEloquentQuery()` for authorization
- **Trend Queries**: `flowframe/laravel-trend` for time-series data

### Data Transformation

- **Money Conversion**: `MoneyCast` handles integer ↔ float conversion
- **Status Display**: `OrderStatus` enum provides UI-ready labels/colors
- **Date Formatting**: Carbon with timezone conversion in components
- **Number Formatting**: `Illuminate\Support\Number` facade with 'Rp' prefix

### Caching Strategies

- **File-based**: Default development cache driver
- **Redis**: Recommended for production
- **Query Caching**: Not explicitly implemented, relies on database optimization

### Validation Patterns

- **Form Validation**: Delegated to Service classes (`OrderFormValidator`)
- **Model Validation**: Implemented through Eloquent events and service calls
- **Business Rules**: Centralized in dedicated service methods

## 7. Cross-Cutting Concerns Implementation

### Authentication & Authorization

**Security Model**:

- Laravel's built-in authentication system
- Filament Shield integration for role-based permissions
- Policy-based authorization (`OrderPolicy`, `ProductPolicy`, etc.)

**Permission Enforcement**:

- Resource-level permissions through Filament Shield
- Method-level authorization in Policy classes
- Resource query scoping for data access control

**Identity Management**:

- User model with standard Laravel authentication
- Role/permission system via Filament Shield
- Session-based authentication for admin panel

### Error Handling & Resilience

**Exception Handling**:

- Laravel's global exception handler
- Service classes isolate business logic errors
- Filament form validation provides user-friendly error display

**Validation Strategy**:

- Service-based validation (`OrderFormValidator`)
- Model-level constraints through database and Eloquent
- Form-level validation in Filament components

**Graceful Degradation**:

- Health checks via spatie/laravel-health
- Environment-specific error reporting
- Fallback values in calculation services

### Logging & Monitoring

**Instrumentation**:

- Laravel's built-in logging system
- Health check monitoring for system status
- Filament's built-in error reporting

**Observability**:

- Health checks for database, cache, queue, disk
- Security advisory monitoring
- Performance monitoring through Laravel Telescope (if configured)

**Diagnostic Information**:

- Comprehensive PHPDoc for development debugging
- Static analysis via PHPStan Level 8
- Code quality enforcement via Laravel Pint

### Configuration & Secret Management

**Configuration Sources**:

- Environment-based configuration via `.env` files
- Laravel configuration files in `config/` directory
- Filament-specific configuration in `config/filament.php`

**Environment-Specific Configuration**:

- Development: SQLite, file cache, sync queue
- Production: MySQL/MariaDB, Redis cache, Redis/SQS queue
- Staging: Managed service equivalents

**Secret Management**:

- Environment variables for sensitive data
- No secrets committed to version control
- Production secret management via deployment environment

## 8. Service Communication Patterns

### Service Boundaries

- **Chart Services**: Data transformation for visualization
- **Calculation Services**: Business logic for order processing
- **Validation Services**: Business rule enforcement
- **Statistics Services**: Dashboard metric calculation

### Communication Protocols

- **Synchronous**: Direct method calls between services
- **Event-Driven**: Model events trigger service methods
- **Static Methods**: Stateless service operations

### Service Discovery

- **Laravel Service Container**: Dependency injection container
- **Static Method Calls**: Direct class method invocation
- **Service Provider Registration**: Bootstrap services in `AppServiceProvider`

## 9. Technology-Specific Architectural Patterns

### Laravel 12 Architectural Patterns

- **Application Bootstrap**: Standard Laravel application structure
- **Service Container**: Dependency injection through Laravel container
- **Eloquent ORM**: Active Record pattern for data access
- **Model Events**: Lifecycle hooks for business logic delegation
- **Middleware Pipeline**: Request processing pipeline for admin panel

### Filament 4 Architectural Patterns

- **Component Composition**: Resource → Form/Table components
- **Static Schema Methods**: Reusable form/table schema definitions
- **Resource Organization**: Separate concerns into dedicated component classes
- **Navigation Groups**: Hierarchical menu organization
- **Action System**: Declarative action definitions with closures

### PHP 8.2+ Architectural Patterns

- **Enum Implementations**: Type-safe status values with contracts
- **Type Declarations**: Comprehensive type safety with generics
- **Readonly Properties**: Immutable value objects like `DateRange`
- **Match Expressions**: Pattern matching in enum methods

## 10. Implementation Patterns

### Interface Design Patterns

- **Filament Contracts**: Enums implement `HasColor`, `HasIcon`, `HasLabel`
- **Cast Interfaces**: `MoneyCast` implements `CastsAttributes`
- **Service Interfaces**: Static method contracts for stateless operations

### Service Implementation Patterns

- **Static Service Classes**: Stateless operations via static methods
- **Delegation Pattern**: UI components delegate to service methods
- **Event-Driven Updates**: Model events trigger service calculations
- **Resource Scoping**: Services use resource queries for authorization

### Repository Implementation Patterns

- **Eloquent Direct Access**: No explicit repository layer
- **Resource Query Methods**: Filament resources provide scoped queries
- **Model Relationships**: Eloquent relationships for data access
- **Trend Queries**: Specialized queries via flowframe/laravel-trend

### Controller/API Implementation Patterns

- **Filament Resources**: Replace traditional controllers for admin CRUD
- **Livewire Components**: Handle interactive UI without traditional controllers
- **Resource Actions**: Declarative action definitions in resource classes

## 11. Testing Architecture

### Testing Strategy

- **Feature Tests**: End-to-end testing with `RefreshDatabase` trait
- **Unit Tests**: Pure logic testing for service classes
- **In-Memory SQLite**: Fast test database with configured `phpunit.xml`

### Test Boundary Patterns

- **Unit Testing**: Service method testing in isolation
- **Integration Testing**: Model relationship and data access testing
- **Feature Testing**: Full request lifecycle testing through Filament

### Test Data Strategies

- **Model Factories**: Eloquent factories for all domain models
- **Database Seeding**: Structured test data via seeders
- **Relationship Factories**: Proper foreign key and relationship setup

### Testing Tools Integration

- **PHPUnit 11.5**: Primary testing framework
- **Laravel Testing**: Framework testing utilities
- **Mockery**: Mocking framework for dependencies

## 12. Deployment Architecture

### Deployment Topology

- **Single Application**: Monolithic Laravel application
- **Admin Interface**: Filament-based administrative panel
- **Static Assets**: Vite-built CSS/JS served via Laravel

### Environment Adaptations

- **Development**: SQLite, file-based cache/sessions, sync queue
- **Production**: MySQL/MariaDB, Redis cache/sessions, Redis/SQS queue
- **Staging**: Managed service equivalents for databases and queues

### Configuration Management

- **Environment Variables**: Database, cache, queue, mail configuration
- **Feature Flags**: Environment-based feature toggles
- **Asset Building**: Vite for production asset compilation

### Containerization Approach

- **Laravel Sail**: Docker-based development environment
- **Production**: Standard Laravel deployment patterns
- **Asset Pipeline**: Vite build process for static assets

## 13. Extension and Evolution Patterns

### Feature Addition Patterns

- **New Resources**: Create Resource class + Form/Table components
- **New Services**: Add service class in `app/Services/` directory
- **New Models**: Create model with proper PHPDoc and relationships
- **New Widgets**: Create widget class with service delegation

### Modification Patterns

- **Service Extension**: Add methods to existing service classes
- **Component Updates**: Modify form/table schemas in component classes
- **Model Evolution**: Add properties with proper casts and documentation
- **Resource Enhancement**: Extend resource methods while maintaining delegation

### Integration Patterns

- **External Services**: Add service classes for external API integration
- **New UI Components**: Create Livewire components following existing patterns
- **Database Extensions**: Add migrations with proper relationship constraints
- **Health Checks**: Register new health checks in `AppServiceProvider`

## 14. Architectural Pattern Examples

### Layer Separation Example

```php
// UI Layer - Filament Widget
class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Delegate to Application Layer
        return StatsOverviewCalculator::calculateTrendComparison(
            'orders', 'total_price', $dateRange
        );
    }
}

// Application Layer - Service
class StatsOverviewCalculator
{
    public static function calculateTrendComparison(string $table, ?string $column, DateRange $range): array
    {
        // Orchestrate Domain Layer operations
        $current = self::getCurrentValue($table, $column, $range);
        return compact('current', 'diff', 'trend');
    }
}
```

### Service Delegation Example

```php
// Domain Layer - Model Event
protected static function booted(): void
{
    static::saving(static function (Order $order): void {
        // Delegate calculation to Application Layer
        $order->total_price = OrderCalculationService::calculateTotalPrice($order);
    });
}

// Application Layer - Service
class OrderCalculationService
{
    public static function calculateTotalPrice(Order $order): float
    {
        return (float) $order->items()
            ->selectRaw('COALESCE(SUM(qty * unit_price), 0) as total')
            ->value('total');
    }
}
```

### Component Communication Example

```php
// UI Component
class OrderForm
{
    public static function getSchema(): array
    {
        return [
            Section::make(__('resources/order.details'))
                ->schema(static::getDetailsFormSchema()),
            // Form delegates validation to service
        ];
    }
}

// Service validates business rules
class OrderFormValidator
{
    public static function validateOrderItems(array $items): array
    {
        // Business rule validation logic
        return $validatedItems;
    }
}
```

## 15. Architecture Governance

### Architectural Consistency Maintenance

- **Static Analysis**: PHPStan Level 8 enforces type safety
- **Code Formatting**: Laravel Pint ensures consistent code style
- **Documentation Standards**: Comprehensive PHPDoc requirements
- **Service Patterns**: Consistent delegation patterns across components

### Automated Compliance Checks

- **CI Pipeline**: Automated testing, static analysis, and formatting checks
- **Composer Scripts**: Development workflow automation
- **Git Hooks**: Pre-commit validation (if configured)

### Architectural Review Process

- **Service Extraction**: Complex logic must be extracted to service classes
- **Resource Scoping**: Filament components must use resource queries
- **Type Safety**: All methods require proper PHPDoc with types
- **Money Handling**: All monetary values must use `MoneyCast`

## 16. Blueprint for New Development

### Development Workflow

#### Adding New Domain Entity

1. **Create Model**: Add Eloquent model with comprehensive PHPDoc
2. **Add Relationships**: Define proper relationship methods with types
3. **Create Factory**: Add model factory for testing
4. **Add Migration**: Create database migration with constraints
5. **Create Resource**: Add Filament resource with component delegation
6. **Add Components**: Create Form/Table components with static schemas
7. **Add Services**: Extract business logic to dedicated service classes
8. **Add Tests**: Create feature and unit tests following patterns

#### Adding New Business Logic

1. **Identify Layer**: Determine if logic belongs in Service or Model
2. **Create Service**: Add service class in `app/Services/` directory
3. **Use Static Methods**: Implement stateless operations as static methods
4. **Add Documentation**: Include comprehensive PHPDoc with types
5. **Add Tests**: Create unit tests for service methods
6. **Integrate**: Call service from appropriate UI or Model layer

#### Adding New UI Component

1. **Choose Pattern**: Filament Resource, Widget, or Livewire Component
2. **Follow Delegation**: Delegate complex logic to service classes
3. **Use Resource Queries**: Always use `Resource::getEloquentQuery()` for data
4. **Add Translations**: Use translation keys for all user-facing strings
5. **Format Money**: Use `Number` facade with 'Rp' prefix for money display

### Implementation Templates

#### Base Service Class Template

```php
<?php

namespace App\Services;

class NewBusinessService
{
    /**
     * Primary business operation
     *
     * @param  array<string,mixed>  $data
     * @return array<string,mixed>
     */
    public static function processBusinessLogic(array $data): array
    {
        // Implement business logic here
        return $processedData;
    }
}
```

#### Base Filament Component Template

```php
<?php

namespace App\Filament\Resources\Entity\Components;

class EntityForm
{
    /**
     * @return array<Component>
     */
    public static function getSchema(): array
    {
        return [
            // Define form schema
        ];
    }

    /**
     * @return array<Component>
     */
    public static function getDetailsFormSchema(): array
    {
        return [
            // Detailed form fields
        ];
    }
}
```

### Common Pitfalls to Avoid

#### Architecture Violations

- **Direct Model Queries**: Never use `Order::query()` in Filament components, use `OrderResource::getEloquentQuery()`
- **Business Logic in UI**: Extract complex logic to service classes
- **Missing Resource Scoping**: Always use resource queries for authorization
- **Hardcoded Strings**: Use translation keys for all user-facing text

#### Performance Considerations

- **N+1 Queries**: Use eager loading with `->with()` for relationships
- **Heavy Calculations**: Cache expensive operations in service methods
- **Large Result Sets**: Implement pagination and filtering in table components

#### Testing Blind Spots

- **Service Testing**: Unit test all service methods independently
- **Relationship Testing**: Test model relationships with proper factories
- **Authorization Testing**: Test resource scoping and permissions

### Blueprint Maintenance

This blueprint was generated on August 29, 2025, based on the current codebase structure. To keep it updated:

1. **Review Monthly**: Check for new architectural patterns or violations
2. **Update on Major Changes**: Regenerate after significant architectural modifications
3. **Validate Patterns**: Ensure new code follows documented patterns
4. **Document Decisions**: Record architectural decision rationale for future reference

The architecture emphasizes maintainability, type safety, and clear separation of concerns while leveraging Laravel and Filament best practices for rapid development and deployment.
