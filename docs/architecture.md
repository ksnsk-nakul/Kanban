# Architecture

## Core goals

- Minimal, clean Laravel 13 foundation
- RBAC-first (roles/permissions)
- DB-driven localization (languages + translations)
- Configurable auth methods (enabled/disabled in DB)
- Settings engine with caching
- Addon system for future products

## Addons

Addons live in `/Addons/<Name>` and can register:

- routes (`Routes/web.php`, `Routes/api.php`)
- migrations (`Database/Migrations`)
- views (`Resources/views`)

Generate:

```bash
php artisan make:addon CRM
```

