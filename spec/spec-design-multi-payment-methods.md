---
title: Multi-Payment Methods and Split Payments
version: 1.0
date_created: 2025-08-29
last_updated: 2025-08-29
owner: product-engineering
tags: [design, app, orders, payments]
---

## Introduction

Enable multiple payment methods per order (cash, card, e-wallet, bank transfer), support split tenders, and define order paid state by aggregated payments.

## 1. Purpose & Scope

- Purpose: Support real-world checkout scenarios with mixed tenders and clear reconciliation.
- Scope: Payment model changes, enums, order totals logic, UI forms, invoice breakdown, tests.

## 2. Definitions

- Split payment: An order settled using multiple payment entries.
- Payment method: Tender type (cash, card, ewallet, bank_transfer).
- Paid-in-full: Sum(payments.amount) >= order.total_price.

## 3. Requirements, Constraints & Guidelines

- REQ-001: Support multiple Payment records per Order.
- REQ-002: Add method enum, status, reference, metadata (json) to Payment.
- REQ-003: Compute order “paid” status from aggregated successful payments.
- REQ-004: Support cash change calculation (non-negative change only).
- REQ-005: Show payment breakdown on invoice PDF.
- REQ-006: Validate that total successful payments cannot be negative or exceed safe integer limits.
- SEC-001: Sanitize references; avoid leaking sensitive PAN data.
- CON-001: Backward compatible migration (existing data remains valid as cash).
- GUD-001: Keep business rules in Services; UI thin.
- PAT-001: Use Laravel Enum for PaymentMethod.

## 4. Interfaces & Data Contracts

- DB schema changes (payments table):
  - method varchar(32) not null default 'cash'
  - status varchar(32) not null default 'successful'
  - reference varchar(191) nullable
  - meta json nullable

- Enum: App\\Enums\\PaymentMethod: cash|card|ewallet|bank_transfer.

- Service: PaymentSettlementService
  - getPaidAmount(Order $order): int
  - isPaid(Order $order): bool
  - addPayment(Order $order, PaymentData $data): Payment

- DTO: PaymentData { method, amount, reference?, meta? }

## 5. Acceptance Criteria

- AC-001: Order with two payments (cash 50_000, card 25_000) for total 75_000 is paid.
- AC-002: Cash payment larger than remaining amount shows change on invoice.
- AC-003: Payment breakdown rendered on invoice with method labels.
- AC-004: Deleting a payment updates paid status accordingly.
- AC-005: Validation prevents negative amounts and rejects unknown methods.

## 6. Test Automation Strategy

- Unit tests: PaymentSettlementService; enum mapping; invoice view model.
- Feature tests: Adding/removing payments via Filament forms; invoice output.
- Data: Factories extended for Payment with method/status.
- CI/CD: composer run test; coverage on service >80%.

## 7. Rationale & Context

README promises multi-payment method support; current Payment has only amount. Split tenders are common in POS.

## 8. Dependencies & External Integrations

### External Systems

- EXT-001: Optional future gateways (Stripe/Midtrans) – not in MVP.

### Third-Party Services

- SVC-001: None for MVP.

### Infrastructure Dependencies

- INF-001: Database migration for payments table.

### Data Dependencies

- DAT-001: Order totals and Payment relationships.

### Technology Platform Dependencies

- PLT-001: Laravel 12, PHP 8.2, Filament 4.

### Compliance Dependencies

- COM-001: Do not store card PAN/CVV; only masked refs.

## 9. Examples & Edge Cases

```code
// Determine paid status
$paid = $order->payments()->where('status', 'successful')->sum('amount');
$isPaid = $paid >= $order->total_price;
```

Edge cases: refunds (out of scope); partial auths; voids; rounding to integer cents.

## 10. Validation Criteria

- Migration adds columns and preserves existing payments.
- Services compute paid status correctly.
- UI supports multiple payments.
- Invoice shows breakdown.

## 11. Related Specifications / Further Reading

- spec-design-inventory-tracking.md
