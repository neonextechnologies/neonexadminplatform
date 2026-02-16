# NeonEx Admin Platform

> **Modern Laravel Admin Platform** built with Bootstrap 5 + jQuery (No npm build required!)

[![Laravel](https://img.shields.io/badge/Laravel-12.51.0-red.svg)](https://laravel.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.3-purple.svg)](https://getbootstrap.com)
[![jQuery](https://img.shields.io/badge/jQuery-3.6.1-blue.svg)](https://jquery.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 🎯 Project Overview

A **minimal, AI-friendly** Laravel admin platform that:
- ✅ No npm build required (instant hot reload)
- ✅ Plain Bootstrap + jQuery (AI-optimized codebase)
- ✅ Registry-first permissions (centralized management)
- ✅ Audit-first approach (all operations logged)
- ✅ Modular architecture (pluggable modules)
- ✅ Theme adapter (switch themes without refactoring)

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- MySQL 5.7+
- Composer

### Installation

```bash
# Clone repository
git clone https://github.com/neonextechnologies/neonexadminplatform.git
cd neonexadminplatform

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_DATABASE=neonexadminplatform
DB_USERNAME=root
DB_PASSWORD=

# Create database
mysql -uroot -e "CREATE DATABASE IF NOT EXISTS neonexadminplatform CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

# Run migrations + seeders
php artisan migrate:fresh --seed

# Start server
php artisan serve
# Or use Laragon: http://neonexadminplatform.test
```

Visit: **http://localhost:8000/_test-phase2**

## 🔑 Default Credentials

| Account | Email | Password | Permissions |
|---------|-------|----------|-------------|
| **Admin** | admin@example.com | password | 10 (Full Access) |
| **User** | user@example.com | password | 3 (Limited Access) |

## ✅ Completed Features (Phase 0-2)

### Phase 0: Platform Skeleton + UI Shell
- Kernel/Modules architecture
- Theme adapter system
- Action Router (jQuery-based)
- Bootstrap 5 layouts + partials

### Phase 1: Authentication
- Session-based auth (no starter kit)
- Login/Register/Logout
- Audit logging (user creation)

### Phase 2: RBAC
- **Registry-first permissions** (PermissionRegistry)
- Roles & Permissions system
- Permission middleware
- Audit logging (all RBAC operations)

## 🏗️ Architecture

### Tech Stack
```
Backend:  Laravel 12.51.0 (PHP 8.4+)
Frontend: Bootstrap 5.3.3 (CDN) + jQuery 3.6.1 (CDN)
Database: MySQL (utf8mb4_general_ci)
Build:    None! (No npm, No webpack, No Vite build)
```

### Core Principles

#### 1. Registry-first (Phase 2)
All permissions MUST be registered in `PermissionSeeder`:

```php
$registry->register('users.view', 'Users', 'Can view users list');
```

#### 2. Audit-first (Phase 1-2)
All important operations are logged:

```php
logger()->info('User created', ['user_id' => $user->id]);
```

#### 3. Tenant-first (Phase 5)
All data is tenant-scoped (coming next):

```php
User::where('tenant_id', tenant_id())->get();
```

#### 4. Module-first (Phase 0)
Features are pluggable modules:

```
modules/
├── Example/
│   ├── Providers/ExampleServiceProvider.php
│   ├── routes/web.php
│   └── resources/views/
```

### Layer A Constraints
- ❌ No component library (`<x-limitless::...>`)
- ❌ No DataTables baseline (deferred to Layer C)
- ✅ Plain Bootstrap markup only
- ✅ jQuery action router (`data-action`)
- ✅ SSR Blade templates

## 📁 Project Structure

```
app/
├── Contracts/           # Phase 0: Core contracts
│   ├── PermissionRegistryContract.php
│   ├── AuditContract.php
│   ├── TenantContract.php
│   └── ModuleContract.php
├── Services/            # Business logic
│   ├── ThemeService.php
│   └── PermissionRegistry.php (Registry-first!)
├── Http/
│   ├── Controllers/Auth/
│   └── Middleware/PermissionMiddleware.php
└── Models/
    ├── User.php
    ├── Role.php
    └── Permission.php

modules/                 # Pluggable modules
└── Example/

resources/
├── themes/plain/        # Plain Bootstrap theme
│   └── layouts/
└── views/
    ├── auth/            # Auth pages
    └── test-phase*.blade.php

public/
├── js/app.js           # Action Router
└── css/app.css         # Minimal overrides

database/
├── migrations/
└── seeders/
    ├── PermissionSeeder.php (Registry-first!)
    ├── RoleSeeder.php
    └── UserSeeder.php
```

## 🧪 Testing

### UI Tests
- **Phase 0:** http://neonexadminplatform.test/_shell
- **Phase 1:** http://neonexadminplatform.test/_test-phase1
- **Phase 2:** http://neonexadminplatform.test/_test-phase2

### Permission Tests
Test middleware with different roles:

```bash
# Login as admin → Full access
http://neonexadminplatform.test/_test-permission/users.create ✅

# Login as user → Limited access
http://neonexadminplatform.test/_test-permission/users.create ❌ 403
```

### Audit Logs
Check operation logs:

```bash
tail -f storage/logs/laravel.log
```

## 📚 Documentation

Full development plan: **[docs/spec/PROJECT_REBUILD_PLAN_BOOTSTRAP_JQUERY.md](docs/spec/PROJECT_REBUILD_PLAN_BOOTSTRAP_JQUERY.md)**

Progress tracking: **[PROGRESS.md](PROGRESS.md)**

## 🤝 Contributing

This is a private project under active development following the Layer A/B/C gate system.

## 📄 License

MIT License - see [LICENSE](LICENSE) for details

## 🔗 Links

- **Repository:** https://github.com/neonextechnologies/neonexadminplatform
- **Organization:** NeonEx Technologies
- **Documentation:** [docs/spec/](docs/spec/)

---

**Built with ❤️ by NeonEx Technologies**
