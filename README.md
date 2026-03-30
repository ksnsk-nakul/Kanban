# DevLife OS — RBAC Productivity & Assistant Core

Minimal but scalable Laravel 13 SaaS core designed for marketplace distribution (Envato/Gumroad).

## Stack

- Laravel 13
- PHP 8.3+
- Blade + AlpineJS
- TailwindCSS
- MySQL
- Sanctum
- Queue + database notifications

## Quick start

```bash
composer install
cp .env.example .env
php artisan key:generate

# configure DB in .env
php artisan migrate --seed

npm install
npm run dev

php artisan serve
```

Demo credentials (seeded):

- Email: `admin@devlife.test`
- Password: `password`

## Addons

Addons live in `/Addons` and can ship:

- routes (`Routes/web.php`, `Routes/api.php`)
- migrations (`Database/Migrations`)
- views (`Resources/views`)

Create an addon:

```bash
php artisan make:addon CRM
```

## Docs

See `/docs` for architecture and customization notes.

