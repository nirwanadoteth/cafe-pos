# Project Workflow Blueprint

**Generated:** August 30, 2025

---

## Workflow 1: Order Completion and Reporting

### 1. Workflow Overview

- **Name:** Order Completion and Reporting

- **Files/Classes Involved:**
  - `app/Filament/Resources/Orders/OrderResource.php`
  - `app/Filament/Resources/Orders/Pages/ListOrders.php`
  - `app/Filament/Resources/Orders/Tables/OrdersTable.php`
  - `app/Filament/Resources/Orders/Schemas/OrderForm.php`
  - `app/Models/Order.php`, `app/Models/OrderItem.php`, `app/Models/Product.php`, `app/Models/Customer.php`, `app/Models/Payment.php`
  - `app/Enums/OrderStatus.php`
  - `app/Policies/OrderPolicy.php`

### 2. Entry Point Implementation

- **Entry Point:** Filament Resource List page (`OrderResource` → `Pages\ListOrders`)
- **Methods:**
  - `table(Table $table): Table` to define columns, filters, actions, pagination
  - `getEloquentQuery(): Builder` (on `OrderResource`) to globally scope queries
- **Query:**
  - Scope to completed orders via `getEloquentQuery()` or a table `Filter`
  - Uses Eloquent ORM; supports search, sort, pagination out of the box
- **Authorization (policy-driven):**
  - Respects Laravel model policies automatically. Key methods used by Filament: `viewAny` (hides from nav), `view`, `create`, `update`, `delete`/`deleteAny`, `restore`/`restoreAny`, `forceDelete`/`forceDeleteAny`, `reorder`
- **Validation:**
  - Resource forms (Create/Edit pages) validate via Filament Forms; List page actions validate via Action modals when applicable

### 3. Service Layer Implementation

- **Service:** Eloquent model methods and Filament Tables (columns, filters, actions, summarizers)
- **Business Logic:**
  - Table-level reporting via summarizers (e.g., sum/min/max over `total_price`) and filters by status/date

### 4. Data Mapping Patterns

- **Mapping:**
  - Eloquent ORM maps database rows to model objects
  - Filament Tables map model attributes to UI columns; supports relationship fields via dot-notation (e.g., `customer.name`)
  - `Order::query()`, `OrderItem::belongsTo(Order)`, `Order::hasMany(OrderItem)`

### 5. Data Access Implementation

- **Repositories:**
  - Eloquent models act as repositories
- **Queries:**
  - Prefer `OrderResource::getEloquentQuery()` for global resource scoping (e.g., Completed only), optionally removing global scopes when necessary
  - Additional per-table constraints via Filters and search
- **Entities:**
  - `Order`, `OrderItem`, `Product`, `Customer`, `Payment`
- **Transactions:**
  - Implicit via Eloquent
- **Soft deletes:**
  - If enabled, expose restore/force-delete via bulk actions; use policy pairs (`restore`/`restoreAny`, `forceDelete`/`forceDeleteAny`)

### 6. Response Construction

- **Response DTO:**
  - Filament Table definitions (columns, filters, actions, summarizers)
- **Mapping:**
  - Model properties mapped to UI via Table configuration; clickable rows/record URLs when needed
- **Status Codes:**
  - Not applicable (UI component)
- **Error Response:**
  - Handled by Filament Actions and Laravel exception handler

### 7. Error Handling Patterns

- **Exceptions:**
  - Laravel exceptions, validation errors (form/action)
- **Try/Catch:**
  - Implicit in Livewire/Laravel
- **Global Handlers:**
  - Laravel exception handler
- **Logging:**
  - Laravel logging
- **Retry/Compensation:**
  - Not applicable

### 8. Asynchronous Processing Patterns

- **Background Jobs:**
  - Not used in this workflow
- **Events:**
  - Not used
- **Message Queues:**
  - Not used

### 9. Testing Approach

- **Unit Tests:**
  - Test Eloquent queries and model relationships
- **Feature Tests:**
  - Test Filament Resource List page renders, table columns/filters/actions present, and summarizers compute expected values
- **Mocking:**
  - Use model factories for test data; use in-memory SQLite for speed
- **Integration Tests:**
  - Verify policy-gated navigation (viewAny), per-action authorization, and filters/search/sort behavior

### 10. Sequence Diagram

```text
User (Admin) -> OrderResource List Page: View Completed Orders
OrderResource.getEloquentQuery -> Order (Model): Scope to completed orders
Order -> OrderItem/Customer/Payment: Load relationships
OrderResource List Page -> Filament Table: Render columns/filters/actions/summarizers
Filament Table -> User (Admin): Display report
```

### 11. Naming Conventions

- **Controllers:** Not used (Resource pages are Livewire components)
- **Services:** Eloquent models
- **Repositories:** Eloquent models
- **DTOs:** Table columns
- **Methods:** camelCase
- **Variables:** camelCase
- **Files:** PascalCase for classes, snake_case for migrations

### 12. Implementation Templates

- **New Workflow (Resource-first):**
  - Generate a Filament Resource for `Order` (optionally with `--generate`, `--soft-deletes`, `--view`)
  - Define columns/filters/actions/summarizers in `OrdersTable`
  - Scope queries in `OrderResource::getEloquentQuery()` (e.g., Completed only)
  - Ensure policies are defined and mapped for all actions (viewAny, create, update, deleteAny, restoreAny, forceDeleteAny)
  - Add feature/unit tests for table behavior and authorization

---

## Implementation Guidelines

- **Step-by-Step Implementation Process:**
  - Start by scaffolding a Filament Resource (or confirm existing one) for Orders
  - Implement `OrderResource::getEloquentQuery()` for baseline scoping (Completed)
  - Map model properties to Table columns; add filters/actions/summarizers and pagination options
  - Add authorization via Laravel policies (ensure `viewAny` enables nav access)
  - Validate input on Create/Edit via Filament Forms schemas
  - Write unit and feature tests for table behavior and policies
- **Common Pitfalls to Avoid:**
  - Avoid business logic in views
  - Test all model relationships and queries
  - Validate all user input
- **Extension Mechanisms:**
  - Add new table columns, summarizers, filters in Livewire/Filament
  - Extend models for new relationships
  - Add new policies for authorization

### Docs Sync Notes (Laravel 12 / Filament 4 / Tailwind v4)

- Testing: Prefer PHPUnit attributes over docblocks; use in-memory SQLite and factories; assert headers on final responses after redirects; for Filament, assert resources visibility via `viewAny` and table features (columns/filters/actions).
- Security: Apply app-wide security headers middleware (CSP, HSTS in prod+HTTPS, X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy). Consider `frame-ancestors` in CSP.
- Tailwind v4: CSS-first configuration with `@import "tailwindcss"` and `@tailwindcss/vite`; safelist dynamic classes and avoid legacy purge/content configs.
- Filament references: See Filament v4 docs for Resources, Tables, Panels, and Widgets.

---

**Summary:**

- Use Livewire/Filament for UI workflows
- Eloquent ORM for data access and mapping
- Policies for authorization
- Laravel exception handling
- Factories for testing
- Maintain naming and file organization conventions
