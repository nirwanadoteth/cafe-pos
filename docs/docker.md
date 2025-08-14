# Docker Local Development (Infrastructure Only)

This repository includes a docker-compose.yml to run supporting services for local development (database, cache, mail capture, and optional search). Run the Laravel app on your Windows host (via `php artisan serve` and Vite), or use Laravel Sail if you prefer a fully containerized setup.

Important: All credentials in this document are for local development only. Do not reuse in staging or production.

## Services

- MySQL 8.0 (port 3307 on host)
- Redis 7 (port 6379)
- Mailhog (SMTP 1025, Web UI 8025)
- Meilisearch (port 7700; behind an optional profile)

## Quick Start (Windows PowerShell)

1) Start services

```powershell
# Start core services (MySQL, Redis, Mailhog)
docker compose up -d

# Optionally also start Meilisearch (uses the "optional" profile)
docker compose --profile optional up -d
```

2) Configure your .env for local containers

Update your .env to point to the containers:

```
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=cafe_pos
DB_USERNAME=app
DB_PASSWORD=app

# Redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

# Mailhog
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="dev@example.test"
MAIL_FROM_NAME="Cafe POS (Local)"

# Meilisearch (optional)
MEILISEARCH_HOST=http://127.0.0.1:7700
```

3) Run the app on your host

```powershell
# PHP deps
composer install

# Env & key
you can copy .env.example to .env if not present
php artisan key:generate
php artisan storage:link

# Frontend
yarn or npm install
npm run dev

# Serve app and queue + logs + vite
composer run dev
```

4) Import database schema/data (optional quick start)

```powershell
# Use the provided dump for a fast start
# Ensure DB_* matches the section above
mysql -h 127.0.0.1 -P 3307 -u app -papp cafe_pos < cafe_pos.sql
```

5) Mail testing

- Open Mailhog UI at http://localhost:8025 to view outgoing emails.

6) Stopping services

```powershell
docker compose down
# Remove volumes (destroys data)
docker compose down -v
```

## Using Laravel Sail (alternative)

This project includes `laravel/sail` as a dev dependency. If you prefer Sail's containerized dev environment:

```powershell
# Install Sail scaffolding (choose services interactively; non-interactive example shown)
# Note: Running this modifies docker-compose.* files. Commit carefully or keep local-only.
php artisan sail:install --with=mysql,redis,meilisearch,mailhog

# Start containers
./vendor/bin/sail up -d

# Use Sail for commands
./vendor/bin/sail php --version
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm run dev
```

If you go with Sail, you typically won't need this repository's top-level docker-compose.yml. Choose one path for local consistency.

## Troubleshooting

- Port in use: change host port mappings in docker-compose.yml (e.g., 3308:3306) and update .env accordingly.
- MySQL auth issues: wait for healthcheck to pass; ensure credentials match (user `app`, password `app`).
- Windows file permissions: since app runs on host, typical Laravel storage permissions apply (`php artisan storage:link`).

## Notes

- This setup follows the repo guidelines: no production secrets, Windows-friendly commands, and minimal changes. For CI/container builds, prefer a dedicated workflow under .github/workflows and image builds with multi-stage Dockerfiles.
