# Architecture Overview

This document provides a concise, high-level view of the Cafe POS system architecture and its runtime topology. It is intended to help contributors and operators understand how the system is structured and what external services it relies on.

## 1) High-level Architecture (Layers)

The application is structured into four primary layers:

- UI (Filament Admin & HTTP)
  - Filament Resources, Pages, Widgets (administration UI)
  - Blade views & HTTP controllers (if any public/customer-facing pages exist)
  - Form schemas, table components, actions

- Application
  - Use cases / service classes orchestrating domain operations
  - Validation (Form Requests) and authorization policies
  - Events / listeners, jobs, notifications

- Domain
  - Eloquent models that represent core concepts (Order, OrderItem, Product, Payment, Category, Customer, User)
  - Domain rules and invariants (order lifecycle, stock adjustments, money calculations)
  - Value Objects & casts (e.g., Money)

- Infrastructure
  - Persistence (Eloquent, migrations, factories, seeders)
  - External integrations (Mail, Queues, Cache, Redis, Storage)
  - Config & environment

Conceptual flow:

User (Browser) → Filament UI → Application Services → Domain Models/Rules → Infrastructure (DB/Queue/Cache/Storage)

## 2) Runtime Topology & External Dependencies

The system relies on the following runtime services and integrations. Local development may use Docker/Sail or native services; staging/production should use managed equivalents where possible.

- Database: MySQL/MariaDB (default: MariaDB on port 3306)
- Cache: File cache by default; Redis recommended for staging/production
- Queue: sync for local/dev; Redis/Database/Beanstalkd/SQS recommended for staging/production
- Sessions: file in local; Redis/Database recommended for staging/production
- Storage: local/public disk in dev; S3 or equivalent for production assets/backups
- Mail: log/mailhog in local; SMTP/transactional provider (SES, Mailgun, Postmark) in staging/production
- Broadcasting (optional): log in local; Pusher/Ably/Laravel WebSockets for real-time features
- Scheduler: Laravel schedule:run via cron or Supervisor/systemd in production
- Workers: Queue workers via Supervisor/systemd (configure retries/backoff)
- Security advisories: roave/security-advisories and composer audit in CI
- Health checks: spatie/health integration for DB, cache, queue, disk, security advisories

Example local setup (suggested):

- DB: 127.0.0.1:3306
- Redis: 127.0.0.1:6379
- Mailhog: 127.0.0.1:1025 (SMTP), 8025 (UI)
- Storage: local disk with `php artisan storage:link`

Operational notes:

- Always run database migrations and seeders with transactions where applicable.
- Prefer environment-specific configuration via .env files; never commit secrets.
- Enable debugging only in non-production environments.
