# Improvement Tasks Checklist

A logically ordered, actionable checklist to improve the Cafe POS Laravel + Filament project. Each item is prefixed with a checkbox placeholder for tracking.

1. [x] Add project overview architecture diagram (high-level) to docs/architecture.md (layers: UI/Filament, Application, Domain, Infrastructure).
2. [x] Document runtime topology and external dependencies (DB, queues, storage, mail, Redis, cron) in docs/architecture.md.
3. [x] Create .env.example completeness pass: ensure all required env vars are declared with safe defaults and comments.
4. [x] Add environment-specific config guidance (local/staging/production) and sample .env.staging and .env.production templates.
5. [x] Replace plaintext default credentials in README with instructions for seeding admin user securely; remove sensitive defaults from docs.
6. [x] Add Makefile or Composer scripts for common workflows (lint, stan, test, build, ci) to standardize local dev commands.
7. [x] Ensure storage, logs, and cache directories are correctly ignored/linked; verify storage:link in setup instructions.
8. [x] Add Docker/Sail documentation and compose file updates for local dev parity (DB, Redis, mailhog, meilisearch optional).
9. [ ] Audit composer dependencies; remove unused packages; pin versions where appropriate; run composer audit and document findings.
10. [x] Enable and document automatic security advisories check in CI (roave/security-advisories already present; add audit step).
11. [x] Add npm audit/retire.js check to CI pipeline and document remediation workflow for vulnerable JS deps.
12. [x] Configure PHP-CS-Fixer or keep Pint; enforce style via CI with composer cs and npm run prettier steps.
13. [ ] Expand PHPStan/Larastan coverage: include app, database, routes, config, and set level to max feasible; add baseline if needed.
14. [ ] Resolve current PHPStan level 8 issues or create suppressions with rationale; target level 9 if possible.
15. [ ] Add Psalm or stick to PHPStan—decide and document static analysis policy; avoid tool duplication.
16. [ ] Introduce Rector config for safe automated refactoring (optional) and run a dry-run; document ruleset.
17. [ ] Establish coding conventions for Filament resources/components (naming, folder layout, actions) in CONTRIBUTING.md.
18. [ ] Create CONTRIBUTING.md with branching strategy, commit style (Conventional Commits), code review checklist.
19. [ ] Add ISSUE_TEMPLATE and PULL_REQUEST_TEMPLATE under .github/ for consistent triage and review.
20. [x] Configure GitHub Actions (or other CI) workflow: install PHP/Node, cache deps, run lint, stan, tests, build.
21. [ ] Add code coverage reporting (Xdebug or PCOV) and upload to Codecov; set minimal coverage thresholds.
22. [ ] Create feature and unit test suites for core domain models (Order, OrderItem, Product, Payment, Category, Customer).
23. [ ] Add model factory definitions and seeders aligned with tests; ensure deterministic seeds for CI.
24. [ ] Write integration tests for Filament Resources pages (List/Create/Edit/Delete) using Pest/Laravel test helpers.
25. [ ] Add HTTP/Feature tests for authentication/authorization flows (login, roles/permissions via Filament Shield).
26. [ ] Add validation tests for key form requests or form schemas (prices, quantities, stock levels, statuses).
27. [ ] Configure an in-memory sqlite testing database or testcontainers; enable parallel testing for speed.
28. [ ] Introduce domain services for Order lifecycle (create, pay, cancel, refund) separating business logic from Resources.
29. [ ] Introduce Value Objects (e.g., Money, Percentage) and use App\Casts\MoneyCast consistently across monetary fields.
30. [ ] Move complex query logic into Query Objects/Scopes; ensure indexes exist for frequent filters (date, status, product_id).
31. [ ] Create application events for order status transitions; add listeners for inventory adjustments and notifications.
32. [ ] Implement transactions for write operations that span multiple tables (orders, items, payments) with retry logic.
33. [ ] Enforce optimistic locking or concurrency-safe stock deduction; document strategy (e.g., SELECT ... FOR UPDATE).
34. [ ] Add database constraints and cascades (FKs, unique, check constraints) to protect invariants at persistence level.
35. [ ] Review migrations: ensure idempotency, down methods (if desired), and consistent naming; add missing migrations if schema drift exists.
36. [ ] Add database seeders for roles/permissions via Filament Shield; keep seeds safe for production (no default passwords).
37. [ ] Introduce API Resources (transformers) if any JSON endpoints are exposed; avoid leaking internal attributes.
38. [ ] Centralize validation rules into Form Requests or dedicated validators; reuse between HTTP and Filament where possible.
39. [ ] Add Authorization policies coverage for all models (Category, Product, Order, Payment, User, Role) and test them.
40. [ ] Configure rate limiting for sensitive endpoints and add CSRF/XSS hardening; review headers via middleware.
41. [ ] Review file upload handling (media library plugin): validate mime/size, scan with antivirus (optional), and use private storage where needed.
42. [ ] Add logging strategy: structure logs (JSON in production), mask sensitive fields, and add context (order_id, user_id).
43. [ ] Integrate health checks (already partially via spatie/health): configure checks for DB, cache, queue, disk, security advisories.
44. [ ] Add application metrics (Prometheus/StatsD) for orders per minute, revenue, failed payments, inventory thresholds.
45. [ ] Add job queues for long-running tasks (report generation, exports) and set retry/backoff policies; monitor failed jobs.
46. [ ] Implement caching for hot queries (dashboard stats, product lists) with invalidation rules; use tags when relevant.
47. [ ] Optimize N+1 queries using eager loading and add Laravel Debugbar in local only; add tests to guard regressions.
48. [ ] Review index coverage: add composite indexes (e.g., orders(status, created_at), order_items(order_id, product_id)).
49. [ ] Add pagination defaults and bounds to tables and API endpoints; document performance implications.
50. [ ] Review Tailwind and Vite build: enable production minification, chunk splitting; configure cache-busting and CDN options.
51. [ ] Introduce accessibility audits for Filament UI; ensure color contrast, keyboard navigation, aria labels.
52. [ ] Add i18n support (Laravel Lang, Filament translations) and externalize user-facing strings; document locale strategy.
53. [ ] Improve error pages and exception handling; create user-friendly messages and tech details in logs only.
54. [ ] Verify time zone handling end-to-end; store in UTC, display per user locale/timezone; audit date pickers.
55. [ ] Implement monetary rounding rules and currency config; ensure consistent formatting and calculations.
56. [ ] Add data export/import validations (CSV/Excel) with row-level error reporting; cap file sizes and async processing.
57. [ ] Add backups strategy (database and storage) and document restore procedure; consider Spatie Backup package.
58. [ ] Create disaster recovery runbook and RTO/RPO targets; test restoration drills quarterly.
59. [ ] Add retention policies for logs and soft-deleted records; regular pruning via schedule:run and model pruning.
60. [ ] Configure scheduler and queue workers in production with Supervisor/systemd manifests included in docs.
61. [ ] Add environment-specific configuration for mailers and payment gateways (if any) and secrets management guidance.
62. [ ] Review licensing of all dependencies; include NOTICE file if required assets are distributed.
63. [ ] Add data privacy review: PII inventory, data minimization, encryption at rest and in transit; document compliance posture.
64. [ ] Create release notes template and semantic versioning policy; automate changelog generation.
65. [ ] Add demo data seeding script for local environments without exposing real credentials or sensitive data.
66. [x] Add screenshots/gifs of key flows to README and ensure demo video link is correct (fix demo.pdf vs demo.mp4).
67. [ ] Ensure public assets are built and not committed when unnecessary; ignore build artifacts and vendor-generated files.
68. [ ] Add pre-commit hooks (Husky or simple Composer scripts) to run pint, prettier, and phpstan on changed files.
69. [ ] Add database migration linter to catch dangerous operations (dropping columns without safety, long locks).
70. [ ] Add SLOs/SLIs for checkout latency and dashboard load time; monitor in APM (e.g., Laravel Telescope local, external APM prod).
71. [ ] Add configuration and docs for feature flags to safely roll out new features.
72. [ ] Review and harden CORS and session cookie settings; set SameSite/Lax/HttpOnly/Secure per environment.
73. [ ] Ensure 2FA/MFA support for admin users (optional) and document authentication hardening steps.
74. [ ] Implement consistent error/result type for domain services (Result/Either) to avoid exceptions for control flow.
75. [ ] Extract report generation into dedicated classes; add tests for report aggregates and date ranges.
76. [ ] Review Filament table filters and date range picker config; ensure timezone correctness and inclusive upper bounds.
77. [ ] Standardize naming conventions for enums (OrderStatus) and transitions; document allowed transitions and invariants.
78. [ ] Introduce DTOs for transporting data between layers (e.g., CreateOrderData, PaymentData) validated upon construction.
79. [ ] Add API rate and input limits for import/export endpoints; stream large exports and chunk imports.
80. [ ] Verify that all user inputs are escaped/encoded in Blade/Filament; audit markdown editors and HTML fields for XSS.
81. [ ] Add CSRF token rotation on login and session fixation protections; test it via automated security tests.
82. [ ] Implement centralized money calculations (tax, discount, subtotal, total) with unit tests for edge cases.
83. [ ] Ensure all background jobs and listeners are idempotent; add deduplication keys where needed.
84. [ ] Add notifications (email/in-app) for key events (low stock, failed payments, large refunds) with throttling.
85. [ ] Create admin audit log for sensitive actions (user/role changes, refunds, price changes) using model activity logs.
86. [ ] Add data lifecycle tasks: anonymize old PII, purge old completed orders per policy; document compliance reasons.
87. [ ] Add localization for currencies/number formats and right-to-left support where applicable.
88. [ ] Review and optimize database schema for money precision/scale; ensure decimals are adequate and consistent.
89. [ ] Implement graceful shutdown and retry policies for queue workers; configure SIGTERM handling in production.
90. [ ] Add smoke tests to run post-deploy (health/DB/queue checks and critical path test).
