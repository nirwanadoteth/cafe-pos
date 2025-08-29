---
title: Inventory Tracking and Stock Validation
version: 1.0
date_created: 2025-08-29
last_updated: 2025-08-29
owner: product-engineering
tags: [design, app, orders, products, inventory]
---

## Introduction

Define consistent, real-time inventory tracking for products with safe stock deductions/increments tied to order lifecycle events (create, update, cancel), including UI indicators and validations.

## 1. Purpose & Scope

- Purpose: Ensure product stock is tracked and enforced during ordering to prevent overselling and to surface low stock conditions.
- Scope: Domain model changes, service logic, Filament UI updates, validations, and tests. Excludes purchase/warehouse management.

## 2. Definitions

- Stock: Integer quantity available for sale for a product.
- Low stock threshold: Configurable integer at which a product is highlighted as low on stock.
- Oversell: Attempt to sell more items than available stock.

## 3. Requirements, Constraints & Guidelines

- REQ-001: Store per-product stock quantity (integer, >= 0).
- REQ-002: Store optional low_stock_threshold for UI warnings.
- REQ-003: Deduct stock on order move to Processing/Completed; restore on Cancelled.
- REQ-004: Block checkout when requested qty > available stock.
- REQ-005: Adjust stock deltas when order items are edited (diff-aware).
- REQ-006: Apply row-level concurrency safety (transactional updates).
- SEC-001: Validate inputs server-side; prevent tampering via Filament forms.
- CON-001: Remain compatible with PHP 8.2 and Laravel 12.
- GUD-001: Use Services layer; keep Filament thin.
- PAT-001: Use events or model hooks to centralize adjustments.

## 4. Interfaces & Data Contracts

- DB schema additions (products table):
  - stock_quantity int unsigned default 0
  - low_stock_threshold int unsigned nullable

- Service contract InventoryService:
  - adjustForOrderSaved(Order $order): void
  - ensureSufficientStock(Product $product, int $qty): void | throws ValidationException

- UI: Filament ProductResource columns: stock_quantity, low stock badge; Order form validation messages.

## 5. Acceptance Criteria

- AC-001: Given a product with stock 5, When an order with qty 3 is completed, Then stock becomes 2.
- AC-002: Given stock 2, When user attempts qty 3, Then validation error is shown and order not saved.
- AC-003: Given completed order qty 2, When order is cancelled, Then product stock increases by 2.
- AC-004: Given item qty changes from 1 to 4, When saved, Then stock delta -3 is applied.
- AC-005: UI shows low-stock badge when stock_quantity <= low_stock_threshold.

## 6. Test Automation Strategy

- Test Levels: Unit (InventoryService), Feature (Order create/edit/cancel), Integration (model events).
- Frameworks: PHPUnit with RefreshDatabase; factories for data.
- Test Data: Model factories; seeders not required.
- CI/CD: Run via composer run test in GitHub Actions (existing pipeline).
- Coverage: Focus on service and event paths (>80% for InventoryService).
- Performance: Use transactions; avoid N+1 in adjustments.

## 7. Rationale & Context

README claims “Real-time inventory integration” but no stock fields exist; guards overselling and enables operational visibility.

## 8. Dependencies & External Integrations

### External Systems

- EXT-001: None.

### Third-Party Services

- SVC-001: None.

### Infrastructure Dependencies

- INF-001: Database migration for products table.

### Data Dependencies

- DAT-001: Product and Order/OrderItem models with existing relations.

### Technology Platform Dependencies

- PLT-001: Laravel 12, PHP 8.2, Filament 4.

### Compliance Dependencies

- COM-001: None.

## 9. Examples & Edge Cases

```code
// Stock deduction on completion
$service->ensureSufficientStock($product, $qty);
$product->decrement('stock_quantity', $qty);

// Edit delta
$delta = $newQty - $oldQty; // apply sign-aware adjustment
```

Edge cases: concurrent orders on same product; restoring on cancellation; zero/negative qty guarded; soft-deleted orders ignored.

## 10. Validation Criteria

- Migration adds columns correctly.
- Service prevents oversell with race-safe updates.
- Feature tests pass for create/edit/cancel flows.
- Filament UI surfaces stock and low-stock badge.

## 11. Related Specifications / Further Reading

- spec-design-multi-payment-methods.md (payments can gate completion)
