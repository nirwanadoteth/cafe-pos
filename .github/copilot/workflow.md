# Project Workflow Blueprint

**Generated:** August 30, 2025

---

## Workflow 1: Order Completion and Reporting

### 1. Workflow Overview

- **Name:** Order Completion and Reporting
- **Purpose:** Handles completed orders and generates summary reports for the admin dashboard.
- **Trigger:** Admin views the completed orders report page.
- **Files/Classes Involved:**
  - `app/Livewire/Orders/ListOrders.php`
  - `app/Models/Order.php`, `app/Models/OrderItem.php`, `app/Models/Product.php`, `app/Models/Customer.php`, `app/Models/Payment.php`
  - `app/Enums/OrderStatus.php`
  - `app/Policies/OrderPolicy.php`
  - `resources/views/livewire/orders/list-orders.blade.php`

### 2. Entry Point Implementation

- **Entry Point:** Livewire component (`ListOrders`)
- **Method:** `table(Table $table): Table`
- **Query:**
  - Filters orders by `OrderStatus::Completed`
  - Uses Eloquent ORM for querying
- **Authorization:**
  - Policy checks via `OrderPolicy`
- **Validation:**
  - Request validation handled by Livewire/Filament forms

### 3. Service Layer Implementation

- **Service:** Eloquent model methods and Filament table summarizers
- **Dependencies:**
  - `Order` model, relationships to `OrderItem`, `Customer`, `Payment`
- **Method Signatures:**
  - `Order::query()`, `OrderItem::belongsTo(Order)`, `Order::hasMany(OrderItem)`
- **Business Logic:**
  - Summarizes min, max, sum of `total_price` for completed orders

### 4. Data Mapping Patterns

- **Mapping:**
  - Eloquent ORM maps database rows to model objects
  - Filament table columns map model properties to UI
- **Validation:**
  - Data validated via Livewire/Filament forms

### 5. Data Access Implementation

- **Repositories:**
  - Eloquent models act as repositories
- **Queries:**
  - `Order::query()->where('status', '=', OrderStatus::Completed)`
- **Entities:**
  - `Order`, `OrderItem`, `Product`, `Customer`, `Payment`
- **Transactions:**
  - Implicit via Eloquent

### 6. Response Construction

- **Response DTO:**
  - Table columns and summarizers in Filament
- **Mapping:**
  - Model properties to table columns
- **Status Codes:**
  - Not applicable (UI component)
- **Error Response:**
  - Filament/Livewire error handling

### 7. Error Handling Patterns

- **Exceptions:**
  - Laravel exceptions, validation errors
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
  - Test Livewire component rendering and table summarization
- **Mocking:**
  - Use model factories for test data
- **Integration Tests:**
  - Test database queries and UI rendering

### 10. Sequence Diagram

```text
User (Admin) -> ListOrders (Livewire): View Completed Orders
ListOrders -> Order (Model): Query completed orders
Order -> OrderItem/Customer/Payment: Load relationships
ListOrders -> Filament Table: Render columns and summarizers
Filament Table -> User (Admin): Display report
```

### 11. Naming Conventions

- **Controllers:** Not used (Livewire component)
- **Services:** Eloquent models
- **Repositories:** Eloquent models
- **DTOs:** Table columns
- **Methods:** camelCase
- **Variables:** camelCase
- **Files:** PascalCase for classes, snake_case for migrations

### 12. Implementation Templates

- **New Workflow:**
  - Create Livewire component
  - Define Eloquent queries in `table()`
  - Map model relationships
  - Add Filament table columns and summarizers
  - Add authorization via policies
  - Write feature/unit tests

---

## Implementation Guidelines

- **Start:** Create/extend Livewire component for new workflow
- **Order:** Model → Query → Relationships → UI → Authorization → Testing
- **Cross-Cutting:** Use policies for authorization, Laravel exception handler for errors
- **Pitfalls:**
  - Avoid business logic in views
  - Test all model relationships and queries
  - Validate all user input
- **Extension:**
  - Add new table columns, summarizers, filters in Livewire/Filament
  - Extend models for new relationships
  - Add new policies for authorization

---

**Summary:**

- Use Livewire/Filament for UI workflows
- Eloquent ORM for data access and mapping
- Policies for authorization
- Laravel exception handling
- Factories for testing
- Maintain naming and file organization conventions
