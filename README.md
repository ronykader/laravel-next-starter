# Laravel + Next.js Fullstack Starter

A modern full-stack starter template using **Laravel** (as REST API backend) and **Next.js** (as frontend). Ideal for rapid development of web applications.

## Technologies Used

- **Laravel 12** – REST API backend
- **Next.js 15** – React frontend
- **Laravel Sail** – Docker-based Laravel dev environment
- **MySQL/PostgreSQL** – Database
- **Axios, Tailwind CSS(optional)**

## 📂 Project Structure

laravel-next-starter/

- ├── rest-api/ # Laravel backend (REST API)
- └── next-frontend/ # Next.js frontend

## Getting Started

### Backend (Laravel)

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

### Frontend (Next.js)

```
  cd next-frontend
  cp .env.example .env.local
  npm install
  npm run dev
```

### Update the .env.local file to point to your Laravel/rest API URL:

```

NEXT_PUBLIC_API_URL=http://localhost:8000/api/v1/
NEXT_PUBLIC_APP_URL=http://localhost:3000
```

### Features

- Clean separation of frontend and backend
- API-first approach with Laravel
- Modern frontend stack with Next.js
- Ready for Docker (optional)
- Easily deployable to Vercel + Laravel Forge

### License

This project is open-source and available under the MIT license.

### Contributing

Feel free to fork, star, and contribute! PRs and issues are welcome to improve this template.
