# GitHub Copilot Instructions — Cafe POS System

## Priority Guidelines

When generating code for this repository:

1. **Version Compatibility**: Always detect and respect the exact versions of languages, frameworks, and libraries used in this project
2. **Context Files**: Prioritize patterns and standards defined in the .github/copilot directory
3. **Codebase Patterns**: When context files don't provide specific guidance, scan the codebase for established patterns
4. **Architectural Consistency**: Maintain our layered architectural style and established boundaries
5. **Code Quality**: Prioritize maintainability, performance, security, and testability in all generated code

## Technology Version Detection

Before generating code, scan the codebase to identify:

1. **Language Versions**:
   - PHP: ^8.2 (CI uses 8.4) - Never use language features beyond PHP 8.2 for compatibility
   - JavaScript/TypeScript: ES modules only (type: "module" in package.json)
   - Never use language features beyond the detected version

2. **Framework Versions**:
   - Laravel: ^12.1.1 - Use Laravel 12 specific features and syntax
   - Filament: ~4.0 - Use Filament 4.x APIs and component structure
   - Tailwind CSS: ^4.1.12 - Use Tailwind 4.x class names and features
   - Vite: ^7.0 - Use Vite 7.x configuration patterns
   - Respect version constraints when generating code

3. **Key Library Versions**:
   - flowframe/laravel-trend: ^0.4.0 for chart data
   - bezhansalleh/filament-shield: ^4.0.0-beta2 for permissions
   - spatie/laravel-health: health checks integration
   - barryvdh/laravel-dompdf: ^3.1.1 for PDF generation

## Context Files

Prioritize the following files in .github/copilot directory (if they exist):

- **architecture.md**: System architecture guidelines
- **tech-stack.md**: Technology versions and framework details
- **coding-standards.md**: Code style and formatting standards
- **folder-structure.md**: Project organization guidelines
- **exemplars.md**: Exemplary code patterns to follow

## Codebase Scanning Instructions

When context files don't provide specific guidance:

1. Identify similar files to the one being modified or created
2. Analyze patterns for:
   - Naming conventions (PascalCase for classes, camelCase for methods, snake_case for database fields)
   - Code organization (Services for business logic, Components for Filament UI parts)
   - Error handling (consistent with existing patterns)
   - Logging approaches (match existing patterns)
   - Documentation style (comprehensive PHPDoc with property types and relationships)
   - Testing patterns (Feature tests with RefreshDatabase, Unit tests for pure logic)

3. Follow the most consistent patterns found in the codebase
4. When conflicting patterns exist, prioritize patterns in newer files or files with higher test coverage
5. Never introduce patterns not found in the existing codebase

## Code Quality Standards

### Maintainability

- Write self-documenting code with clear naming conventions matching existing patterns
- Follow established patterns: PascalCase for classes, camelCase for methods, snake_case for database fields
- Extract complex logic into `app/Services/*` classes, keep Filament Resources/Widgets thin
- Keep functions focused on single responsibilities
- Limit function complexity and length to match existing patterns
- Use comprehensive PHPDoc comments with property types and relationships

### Performance

- Always use `OrderResource::getEloquentQuery()` instead of `Order::query()` for proper Filament scoping
- Follow existing patterns for database queries and relationships
- Match existing patterns for handling computationally expensive operations
- Use flowframe/laravel-trend for chart data with proper resource scoping
- Apply caching consistently with existing patterns

### Security

- Follow existing patterns for input validation using Services (e.g., `OrderFormValidator`)
- Apply the same sanitization techniques used in the codebase
- Use parameterized queries matching existing patterns
- Follow established authentication and authorization patterns with filament-shield
- Handle sensitive data according to existing patterns

### Testability

- Follow established patterns for testable code in `tests/` directory
- Use `RefreshDatabase` trait for Feature tests
- Match dependency injection approaches used in the codebase
- Apply the same patterns for managing dependencies in Services
- Follow established mocking and test double patterns
- Use in-memory SQLite for testing (configured in phpunit.xml)

## Documentation Requirements

- Follow the exact documentation format found in the codebase with comprehensive PHPDoc
- Match the style and completeness of existing comments, especially in Models and Services
- Document parameters, returns, and exceptions in the same style
- Follow existing patterns for @var annotations with complete type information
- Include relationship documentation: `@return BelongsTo<Category,$this>`
- Document model properties with full type annotations and relationships

## Testing Approach

### Unit Testing

- Match the exact structure and style of existing unit tests in `tests/Unit/`
- Follow the same naming conventions for test classes and methods
- Use the same assertion patterns found in existing tests
- Apply the same mocking approach used in the codebase
- Follow existing patterns for test isolation

### Feature Testing

- Follow the same feature test patterns found in `tests/Feature/`
- Use `RefreshDatabase` trait for database interactions
- Match existing patterns for test data setup and teardown
- Use in-memory SQLite as configured in phpunit.xml
- Test environment: `APP_ENV=testing`, array drivers for cache/session/mail

## Laravel & Filament Specific Guidelines

### Laravel 12 Guidelines

- Use Laravel 12 specific features and syntax patterns
- Follow the exact dependency injection patterns found in Services
- Match exception handling patterns from existing code
- Use the same Eloquent patterns found in Models with proper type annotations
- Apply the service container patterns evident in existing code
- Follow existing patterns for Events, Jobs, and Queues

### Filament 4 Guidelines

- Use Filament 4.x component structure and APIs exclusively
- Follow component organization: `OrderResource` → `Components/OrderForm.php`, `Components/OrderTable.php`
- Use static methods for reusable schema definitions: `OrderForm::getSchema()`, `OrderTable::getColumns()`
- Separate concerns: forms, tables, actions, and filters in dedicated component classes
- Match existing patterns for Resource, Page, and Widget structure
- Apply the same approach for navigation groups and permissions

### PHP 8.2+ Guidelines

- Use PHP 8.2 features like readonly classes (seen in `DateRange`) but stay compatible
- Follow the same type declaration patterns found in the codebase
- Match enum implementation patterns like `OrderStatus` with Filament contracts
- Use proper return type declarations matching existing patterns
- Apply the same approach to nullable types and union types

## Architecture Patterns

### Layered Architecture

- **Filament UI Layer**: Resources/Pages/Widgets for user interface
- **Application Services Layer**: Business logic in `app/Services/*` classes
- **Domain Layer**: Eloquent models with proper casts and relationships
- **Infrastructure Layer**: Database, queues, storage, external services

### Service Delegation Pattern

- Stats: `Filament\Widgets\StatsOverviewWidget` delegates to `Services\StatsOverviewCalculator`
- Charts: `Filament\Widgets\OrdersChart` uses `Services\ChartDataService`
- Order form: `Resources\Orders\Components\OrderForm` defers validation to `Services\OrderFormValidator`
- Totals: computed by `Services\OrderCalculationService` in `Order::saving()`

### Money and Data Patterns

- Money: stored as integer cents, cast via `App\Casts\MoneyCast` (integer cents)
- Format money with `Illuminate\Support\Number` facade and `Rp` prefix
- Date ranges: use `getCarbonInstancesFromDateString()` helper and `App\Helpers\DateRange` VO
- Labels: `perDay|perWeek|perMonth|perYear` for date range periods

### Translation and Internationalization

- Use translation keys for all user-facing strings: `__('resources/order.details')`
- Follow existing pattern: `__('navigation.group.catalog')` for navigation groups
- Never use hardcoded strings in UI components

## Domain Model Patterns

### Key Domains

- `Order`, `OrderItem`, `Product`, `Payment`, `Category`, `Customer`, `User`
- All models use comprehensive PHPDoc with property types and relationships
- Money fields use `MoneyCast` for integer cents storage
- Soft deletes on key models (Order)
- Factory pattern for all models with proper relationships

### Enum Implementation

- Enums implement Filament contracts: `OrderStatus` implements `HasColor`, `HasIcon`, `HasLabel`
- Use match expressions for enum methods
- Follow the exact pattern seen in `OrderStatus` enum

### Model Relationships

- Use proper type annotations: `@return BelongsTo<Category,$this>`
- Document all relationships with complete type information
- Follow existing patterns for relationship method naming

## Testing Configuration

### Environment Setup

- PHPUnit configured for in-memory SQLite testing (`phpunit.xml`)
- Test environment variables: `APP_ENV=testing`, `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`
- Array drivers for cache, session, mail in testing
- Use `RefreshDatabase` trait for Feature tests

### Test Structure

- Unit tests: `tests/Unit/` for pure logic testing
- Feature tests: `tests/Feature/` for HTTP/DB interactions
- Match existing test naming and organization patterns

## Frontend Development Patterns

### Vite Configuration

- Use Vite 7.x with Laravel Vite plugin
- Tailwind CSS 4.x with PostCSS nesting
- File watching includes: `app/Filament/**`, `app/Livewire/**`, etc.
- Scripts: `npm run dev` (hot reload), `npm run build` (production)

### Asset Management

- Follow existing patterns for CSS and JavaScript organization
- Use Tailwind 4.x class names and configuration
- Match existing component styling patterns

## Development Workflow Patterns

### Composer Scripts

- `composer run dev`: Concurrent development with server, queue, logs, and Vite
- `composer run pint`: Code style formatting (Laravel preset with custom rules)
- `composer run stan`: Static analysis with PHPStan level 8
- `composer run test`: Clear config and run tests

### Code Quality Tools

- Laravel Pint with custom configuration in `pint.json`
- PHPStan level 8 analysis with deprecation rules
- Prettier for JavaScript/TypeScript formatting

## Key Conventions

### Database Queries

- Always filter cancelled orders in dashboard queries: `->where('status', '!=', 'cancelled')`
- Use resource queries for auth scoping: `OrderResource::getEloquentQuery()`
- Never use direct model queries in Filament components when resource scoping is needed

### Code Organization

- Extract complex logic into `app/Services/*` classes
- Keep Filament Resources/Widgets thin, delegate to Services
- Centralize validation and business rules in Services
- Don't edit `vendor/` or auto-generated assets

### Error Handling

- Follow existing patterns for exception handling
- Use consistent validation patterns through Services
- Match existing error message patterns and translation keys

## Project-Specific Guidance

### Service Patterns

- Chart data: `ChartDataService` handles Trend queries with proper resource scoping
- Order calculations: `OrderCalculationService` for totals and cleanup logic
- Date ranges: `DateRangeService` for period comparisons and labels
- Validation: `OrderFormValidator` centralizes business rules
- Environment: `EnvironmentService` for environment checks

### PDF Generation

- Use barryvdh/laravel-dompdf for invoice generation
- Follow existing pattern in `OrderTable::getPdfAction()` for PDF downloads
- Sanitize filenames: `preg_replace('/[^A-Za-z0-9\-]/', '', $record->number)`

### Health Checks

- Use spatie/laravel-health with multiple configured checks
- Follow existing patterns in `AppServiceProvider` for health check registration

## Version Control Guidelines

- Follow Semantic Versioning patterns as evident in composer.json
- Match existing patterns for documenting changes
- Use conventional commit patterns if established in the project

## General Best Practices

- Follow naming conventions exactly as they appear in existing code
- Match code organization patterns from similar files
- Apply error handling consistent with existing patterns
- Follow the same approach to testing as seen in the codebase
- Match logging patterns from existing code
- Use the same approach to configuration as seen in the codebase
- Respect existing architectural boundaries without exception
- When in doubt, prioritize consistency with existing code over external best practices

## Important Reminders

- Scan the codebase thoroughly before generating any code
- Always use `OrderResource::getEloquentQuery()` for dashboard queries instead of direct model access
- Money formatting: use `Number` facade with `Rp` prefix
- Translation keys: `__('resources/order.details')` pattern for all UI strings
- Service delegation: extract business logic to Services, keep UI components thin
- Enum contracts: implement `HasColor`, `HasIcon`, `HasLabel` for Filament enums
- Type safety: use comprehensive PHPDoc with complete type information and relationships

Follow these patterns and reference the specific files when making similar changes. Prioritize consistency with the existing codebase over external best practices or newer language features.
