# Deployment

## Checklist (starter)

- Set `APP_ENV=production`
- Set `APP_DEBUG=false`
- Configure database + cache + queue drivers
- Run `php artisan config:cache` and `php artisan route:cache`
- Configure HTTPS + trusted proxies (if behind a load balancer)

