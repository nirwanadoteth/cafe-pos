---
title: Public REST API v1 (Read-Only MVP)
version: 1.0
date_created: 2025-08-29
last_updated: 2025-08-29
owner: product-engineering
tags: [architecture, api, integration]
---

## Introduction

Expose a minimal, read-only REST API for integrations (kiosk, mobile, reporting) aligned with existing models and layered architecture.

## 1. Purpose & Scope

- Purpose: Provide standardized, authenticated access to catalog and order summaries.
- Scope (MVP): GET endpoints for products, categories, and orders (summary). Excludes create/update.

## 2. Definitions

- REST API: JSON over HTTPS with standard HTTP semantics.
- Token auth: Personal access tokens via Laravel Sanctum (or Laravel token guard).

## 3. Requirements, Constraints & Guidelines

- REQ-001: Versioned path prefix /api/v1.
- REQ-002: Auth via Sanctum PAT or token guard; rate limited.
- REQ-003: JSON:API-like shapes (camelCase fields derived from snake_case DB fields are acceptable if documented consistently).
- REQ-004: Pagination for collections; filter by visibility/status.
- REQ-005: Scoping: exclude cancelled orders by default.
- SEC-001: HTTPS only; deny in production if not secure.
- CON-001: Laravel 12, PHP 8.2; no breaking changes to admin panel.
- GUD-001: Use dedicated API controllers/resources (transformers); no Eloquent in controllers.
- PAT-001: Use FormRequest for query validation.

## 4. Interfaces & Data Contracts

- Endpoints:
  - GET /api/v1/products?visible=true&page=1
  - GET /api/v1/categories
  - GET /api/v1/orders?status=completed&from=2025-01-01&to=2025-01-31 (summary only)

- Response example (products):
{
  "data": [{
    "id": 1,
    "name": "Cappuccino",
    "description": "...",
    "price": 45000,
    "category": {"id": 2, "name": "Coffee"}
  }],
  "meta": {"currentPage": 1, "perPage": 15, "total": 120}
}

## 5. Acceptance Criteria

- AC-001: Authenticated requests receive 200 with JSON payloads; unauthenticated receive 401.
- AC-002: Products endpoint respects is_visible filter and pagination.
- AC-003: Orders endpoint excludes cancelled by default and supports date filtering.
- AC-004: Rate limiting returns 429 when exceeded.

## 6. Test Automation Strategy

- Feature tests for each endpoint (authz, filters, pagination).
- Use RefreshDatabase, factories; Sanctum testing helpers.
- CI/CD integration via composer run test.

## 7. Rationale & Context

README mentions API endpoints; web routes currently expose Filament only. Read-only MVP de-risks rollout.

## 8. Dependencies & External Integrations

### External Systems

- EXT-001: None.

### Third-Party Services

- SVC-001: Laravel Sanctum for token authentication (if not already present).

### Infrastructure Dependencies

- INF-001: API route registration; auth guards; rate limiter config.

### Data Dependencies

- DAT-001: Product, Category, Order models and relationships.

### Technology Platform Dependencies

- PLT-001: Laravel 12, PHP 8.2.

### Compliance Dependencies

- COM-001: PII minimization in responses.

## 9. Examples & Edge Cases

```code
// Example rate limiter
RateLimiter::for('api', fn ($request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
```

Edge cases: huge datasets (pagination), timezone handling in filters, cancelled orders filtered by default.

## 10. Validation Criteria

- Endpoints return documented shapes.
- Auth and rate limits enforced.
- Tests for filters/pagination pass.

## 11. Related Specifications / Further Reading

- spec-design-inventory-tracking.md
- spec-design-multi-payment-methods.md
