# Cafe POS System

A modern, extensible Point-of-Sale (POS) application for cafes, built with Laravel, Filament, and Vite. It provides robust order management, reporting, and admin features with a clean, modular architecture and developer-friendly workflow.

---

## Technology Stack

- **Backend:** PHP (Laravel 11.9)
- **Frontend:** Blade, Filament (3.2), Vite (6.0), TailwindCSS (3.4.16), JavaScript (ESM)
- **Database:** MySQL
- **Testing:** PHPUnit (11.0.1), PHPStan (level 8), Pint (1.13)
- **Build Tools:** Composer, NPM
- **Other:** Spatie Media Library, Filament plugins, FakerPHP

See [tech-stack.md](.github/copilot/tech-stack.md) for details.

---

## Project Architecture

- Layered MVC (Model-View-Controller) with Service/Repository patterns
- Modular organization: Models, Controllers, Policies, Providers, Enums, Factories, Migrations
- Filament for admin UI (component-based)
- Clear separation of concerns, extensibility, and security via policy-based authorization

See [architecture.md](.github/copilot/architecture.md) for full overview and diagrams.

---

## Getting Started

### Prerequisites

- PHP 8.2+
- MySQL 5.7+
- Node.js (for frontend assets)

### Installation

```sh
composer install
npm install
```

### Setup

- Copy `.env.example` to `.env` and configure database and environment variables
- Run migrations and seeders:

```sh
php artisan migrate --seed
```

- Build frontend assets:

```sh
npm run build
```

- Start the development server:

```sh
php artisan serve
```

---

## Project Structure

See [folder-structure.md](.github/copilot/folder-structure.md) for full details.

```text
app/
  Models/         # Domain entities
  Http/Controllers/ # Request handling
  Policies/       # Authorization logic
  Providers/      # Service providers
  Filament/       # Admin UI components
  Livewire/       # UI workflows
  Helpers/        # Utility functions
  Casts/          # Custom attribute casting
resources/
  views/          # Blade templates
  js/             # Frontend scripts
  css/            # Stylesheets
  lang/           # Localization
public/           # Entry point and assets
config/           # Configuration files
routes/           # Route definitions
storage/          # App storage
tests/            # Feature and unit tests
database/         # Migrations, factories, seeders
```

---

## Key Features

- Order management and reporting
- Admin dashboard with analytics
- Role-based authorization and policies
- Modular, extensible architecture
- Responsive UI with Filament and Livewire
- Automated testing and code quality tools
- Factories for test data and seeding

---

## Development Workflow

- Feature development via modular components (Livewire, Filament)
- Eloquent ORM for data access and mapping
- Policy-based authorization for security
- Automated testing with PHPUnit, PHPStan, Pint
- Asset bundling and hot reload with Vite
- Recommended branching: feature branches, pull requests, code review

See [workflow.md](.github/copilot/workflow.md) for workflow details.

---

## Coding Standards

- PascalCase for classes, camelCase for methods/variables
- Snake_case for migrations
- PSR-4 autoloading and folder structure
- Separation of concerns: business logic in models/services, thin controllers
- Consistent error handling and validation

See [exemplars.md](.github/copilot/exemplars.md) for code examples and [architecture.md](.github/copilot/architecture.md) for standards.

---

## Testing

- Unit tests in `tests/Unit/`
- Feature tests in `tests/Feature/`
- Factories for test data
- Code quality enforced via PHPStan and Pint

See [exemplars.md](.github/copilot/exemplars.md) and [architecture.md](.github/copilot/architecture.md) for patterns.

---

## Contributing

- Follow coding standards and use code exemplars as reference ([exemplars.md](.github/copilot/exemplars.md))
- Submit pull requests for new features and bug fixes
- Write tests for new code
- Document changes in relevant blueprint files
- See [copilot-instructions.md](.github/copilot/copilot-instructions.md) for guidelines

---

## License

MIT License. See [tech-stack.md](.github/copilot/tech-stack.md) for details.
