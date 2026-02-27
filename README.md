# Mini LMS

> A Laravel-based learning management system with Docker-powered development.

---

## 📋 Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Make](https://www.gnu.org/software/make/)

---

## 🚀 Quick Start

```bash
make rebuild-container
```

This single command:
- Creates all Docker containers (PHP, Nginx, MySQL, Redis, MailHog, phpMyAdmin, Selenium)
- Installs Composer dependencies
- Installs npm packages
- Generates application key
- Builds frontend assets

---

---

## 🛠️ Tech Stack

| Layer | Technologies |
|-------|-------------|
| **Backend** | PHP 8.2 · Laravel 12 · Livewire 4 |
| **Frontend** | TailwindCSS 4 · Alpine.js 3 · Vite 7 |
| **UI Components** | Flux UI · Livewire Sortable |
| **Authentication** | Laravel Fortify |
| **Database & Cache** | MySQL · Redis |
| **Testing** | PHPUnit · Laravel Dusk · PHPStan · Pint |
| **Dev Tools** | Husky · Blade Formatter · Debugbar |

---

## 📚 Documentation

- **[Docker Setup](docs/docker.md)** — Container management & commands
- **[Husky Git Hooks](docs/husky/husky.md)** — Automated code quality checks
- **[Features](docs/features.md)** — Core functionality overview
- **[Architecture](docs/architecture.md)** — Design patterns & database schema
- **[DataBase](docs/erd/database.md)** — Design patterns & database schema
- **[Frontend](docs/frontend.md)** — UI components & behaviors
- **[Testing](docs/testing.md)** — Testing strategy & tools
