## Title
Upgrade framework from Laravel 10 to Laravel 13

## Summary
Bump PHP and Composer dependencies to Laravel 13, adopt the Laravel 11+ application bootstrap (`bootstrap/app.php`, `bootstrap/providers.php`), align first-party packages (Passport, Sanctum, Tinker, PHPUnit), and update DDEV to PHP 8.3 so local and CI match framework requirements.

## Background / Context
- Current stack: Laravel 10, classic `Http/Kernel` + `RouteServiceProvider`, PHP 8.1 in DDEV.
- Laravel 13 requires PHP 8.3+ and uses the streamlined bootstrap and middleware registration API.

## Requirements
- [ ] `composer.json` requires `laravel/framework` ^13.0 and compatible package versions; DDEV `php_version` is 8.3.
- [ ] Application uses `Application::configure()` in `bootstrap/app.php` with web + API routing, schedule, and middleware (including `Localization` on the web stack).
- [ ] Passport 13 user model (`OAuthenticatable`, Passport `HasApiTokens`) and `auth.php` API guard use Passport; `/api/user` uses `auth:api`.
- [ ] Obsolete Laravel 10-only files removed (`Http/Kernel`, `Console/Kernel`, `RouteServiceProvider`, `Exceptions/Handler`, `CreatesApplication` where superseded).
- [ ] PHPUnit passes; README badge and CHANGELOG note the upgrade.

## Technical notes
- Merge custom `config/app.php` keys (`available_locales`, default URL) into the Laravel 13 minimal `config/app.php` shape.
- Pin `CACHE_PREFIX` / `SESSION_COOKIE` in `.env.example` if defaults would change session/cache keys for existing installs (per Laravel 13 upgrade guide).
- `config/cache.php`: add `serializable_classes` default from framework if missing.

## Testing
- **PHPUnit:** full suite via `ddev exec php artisan test` (or equivalent).
- **Manual:** smoke home + admin login if time permits (DDEV).

## Impact / Risks
- **Breaking:** PHP 8.3 required everywhere; OAuth/Passport behavior and API auth guard changed from Sanctum to Passport for token routes.
- **Mitigation:** document in CHANGELOG; run `php artisan migrate` if Passport publishes new migrations.
