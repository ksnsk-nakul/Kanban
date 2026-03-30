# Installation (5 minutes)

## Requirements

- PHP 8.3+
- Composer
- MySQL
- Node.js + npm

## Steps

```bash
composer install
cp .env.example .env
php artisan key:generate

# configure DB credentials in .env
php artisan migrate --seed

npm install
npm run dev

php artisan serve
```

Demo login:

- `admin@devlife.test` / `password`

