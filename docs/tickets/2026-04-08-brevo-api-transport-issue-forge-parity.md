## Title
Brevo mailer: HTTP API transport (Issue Forge parity)

## Summary
Replace the previous SMTP-based `mail.mailers.brevo` entry with the same **Brevo transactional API** approach as Issue Forge (`BrevoApiTransport`, `Mail::extend`, `getbrevo/brevo-php`) so production works when outbound SMTP ports are blocked.

## Background / Context
- Issue Forge uses `MAIL_MAILER=brevo` + `BREVO_API_KEY` over HTTPS.
- Smash Up Randomizer had defined `brevo` as SMTP relay; hosts often block port 587.

## Requirements
- [ ] `getbrevo/brevo-php` required; `App\Mail\Transport\BrevoApiTransport` + `Mail::extend('brevo')` in `AppServiceProvider`.
- [ ] `config/mail.php` `brevo` uses `transport` => `brevo` and `api_key` from env.
- [ ] `config/services.brevo.api_key`; `.env.example` documents `BREVO_API_KEY`.
- [ ] README / CHANGELOG updated.

## Testing
- PHPUnit: `MailConfigTest` asserts `brevo` mailer config.
- Manual: `MAIL_MAILER=brevo`, valid `BREVO_API_KEY`, contact form or `php artisan email:test`.

## Impact / Risks
- Deployments that used **`MAIL_MAILER=brevo` with SMTP credentials** must switch to **`BREVO_API_KEY`** (API key, not SMTP password).
