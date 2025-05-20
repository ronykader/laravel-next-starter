# Laravel REST API – Backend

This is the backend portion of the **Laravel + Next.js Fullstack Starter**. It provides a RESTful API built with **Laravel 12** and runs using **Laravel Sail** (Docker).

---

## Features

-   RESTful API structure
-   Authentication-ready with Sanctum
-   Built-in request validation
-   Laravel Sail (Docker-based development)
-   Database migrations and seeders

---

## 📦 Getting Started

### 1. Clone and enter the rest-api folder:

```bash
  cd rest-api
  cp .env.example .env
  composer install
  php artisan key:generate
  php artisan migrate
  php artisan serve

```

### If you want to use Docker/sail

```
  ./vendor/bin/sail up -d
  ./vendor/bin/sail artisan migrate
```

### Note: If Sail is not installed, run:

```
composer install
php artisan sail:install
./vendor/bin/sail up -d
```
