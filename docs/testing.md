# Testing

Testing strategy, coverage, and development tools.

---

## 🧪 Test Types

| Type | Tool | Location | Focus |
|------|------|----------|-------|
| **Unit Tests** | PHPUnit | `tests/Unit/` | Models, services, policies |
| **Feature Tests** | PHPUnit | `tests/Feature/` | HTTP flows, authentication |
| **Static Analysis** | PHPStan | Config: `phpstan.neon` | Type safety |
| **Code Style** | Laravel Pint | Config: `pint.json` | PSR-12 compliance |

---

## 📊 Test Coverage

### Feature Tests

| Area | Coverage |
|------|----------|
| Authentication | Login, registration, password reset, 2FA |
| Authorization | Policy enforcement for courses/lessons |
| Settings | Profile, password, appearance updates |
| Dashboard | Authenticated user access |

### Unit Tests

| Component | Tests |
|-----------|-------|
| CoursePolicy | Enroll/unenroll authorization rules |
| Models | Factory validation, relationships |

---

## 🌱 Test Data Seeding

### Database Seeder

Creates realistic test data for development:

```php
// Test User
User::create([
    'name' => 'Mostafa Kamel',
    'email' => 'mostafa.kamel@mini-lms.com',
    'email_verified_at' => now(),
]);

// Inactive Course (for testing filters)
Course::create(['status' => StatusEnum::INACTIVE, ...]);

// Active Courses with Lessons
Course::factory()
    ->count(1000)
    ->has(Lesson::factory()->count(3-8))
    ->create();
```

### Sample Video URLs

Lessons use real sample videos for testing:
- Plyr demo trailer
- Big Buck Bunny
- Elephants Dream
- Sintel
- GTV video samples

### Enrollments & Certificates

Test user automatically gets:
- 3 enrolled courses
- 1 certificate for first enrolled course

---

## 🔧 Development Tools

### Code Quality (Husky)

Pre-commit hooks run automatically:

| Check | Command |
|-------|---------|
| PHP Style | `composer run-script fix:pint` |
| Static Analysis | `composer run-script test:phpstan` |
| Composer Validation | `composer validate --strict` |
| Blade Formatting | `npm run fix:blade` |
| YAML Validation | `yamllint` |

Pre-push hooks:
- Pint style check
- Blade format validation

### Docker Mode Detection

Husky automatically detects environment:

| Mode | Detection | Behavior |
|------|-----------|----------|
| **Docker** | Docker installed + `docker-compose.yml` exists | Run checks inside containers |
| **Local** | Docker not found | Run checks on host |

### Composer Scripts

Available via `composer.script.json`:

| Script | Purpose |
|--------|---------|
| `deploy:optimize-app` | Production optimization |
| `reset:backend` | Reset migrations and seed |
| `reset:data` | Fresh database with seed |
| `update:vendor` | Composer update with optimizations |
| `fix:pint` | Auto-fix code style |
| `test:pint` | Verify code style |
| `test:phpstan` | Static analysis |
| `test:phpunit-coverage` | Unit tests with coverage |
| `full:test` | Run all test suites |

---

## 🐳 Testing Infrastructure

### Selenium Container

For Laravel Dusk browser tests: **there is no dusk test added yet**
- **IP**: `172.18.10.17`
- **Ports**: `4444` (WebDriver), `5900` (VNC)
- **URL**: `http://172.18.10.17:4444/wd/hub`

### MailHog

Catch all outbound emails:
- **Web UI**: http://localhost:8025
- **SMTP**: `mailhog:1025`
- View enrollment notifications, password resets

### Redis

For queue and cache testing:
- **Host**: `172.18.10.16` or `redis`
- **Port**: `6379`

---

## 🚀 Running Tests

### Inside Docker Container

```bash
# Enter PHP container
make php-bash

# Run PHPUnit
php artisan test

# Run with coverage
composer run-script test:phpunit-coverage

# Run PHPStan
composer run-script test:phpstan

# Run Pint check
composer run-script test:pint

```

### Direct Commands (Docker Mode)

```bash
# One-liner via Make
make php-bash -c "php artisan test"

# Or full docker compose
docker compose -f .docker/docker-compose.yml exec php php artisan test
```

---

## 📈 Code Quality Metrics

### PHPStan Level

Current configuration targets strict type checking:
- `phpstan.neon` configured for Laravel patterns
- Baseline file for gradual adoption

### Pint Rules

- PSR-12 standard
- Laravel preset
- Per-project customization in `pint.json`

### Blade Formatter

Consistent template formatting:
- Indent size: 4 spaces
- Wrap attributes: 80 chars
- Config: `.bladeformatterrc`
