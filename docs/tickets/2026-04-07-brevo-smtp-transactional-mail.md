## Title
Use Laravel SMTP for transactional mail (Brevo-compatible)

## Summary
Replace the SendGrid HTTP API client with Laravel’s configured mailer (`MAIL_*` / SMTP) so production can use **Brevo** (or any SMTP provider) without a separate API integration. Document Brevo-oriented settings in `.env.example` and the README.

## Background / Context
- **Current behavior:** `SendgridMailService` sends mail via `sendgrid/sendgrid` and `SENDGRID_API_KEY`. Contact form and `email:test` depend on it.
- **Desired state:** Standard Laravel SMTP transport; ops sets host/credentials (e.g. Brevo `smtp-relay.brevo.com`, TLS, SMTP key). Local dev can keep Mailpit/Mailhog on `127.0.0.1:1025`.

## Requirements
- [ ] Contact form and `php artisan email:test` send mail through Laravel `Mail` + `config/mail.php` (`MAIL_MAILER=smtp` by default).
- [ ] `MAIL_FROM_ADDRESS` / `MAIL_FROM_NAME` are used as the sender (no hardcoded SendGrid-only from address in code).
- [ ] Admin notification recipient for new contacts uses `config('mail.admin_email')` (env `MAIL_ADMIN_EMAIL`).
- [ ] Remove `sendgrid/sendgrid` and unused `symfony/sendgrid-mailer`; drop `SENDGRID_API_KEY` / `services.sendgrid` config.
- [ ] Add **`.env.example`** with `MAIL_*` placeholders and short Brevo SMTP hints; update **README** “Getting Started” / Email section.
- [ ] **CHANGELOG** `[Unreleased]` entry for operators (SendGrid API → SMTP).

## Technical notes
- New `App\Services\TransactionalMailService` (or equivalent) wrapping `Mail::send` with existing Blade templates under `resources/views/emails/`.
- `resources/views/emails/test.blade.php`: neutral copy (no SendGrid branding).

## Testing
- **PHPUnit:** unit test with `Mail::fake()` asserting outbound mail count (or equivalent) for the transactional service.
- **Manual:** `php artisan email:test` with local SMTP catcher or Brevo test recipient; submit `/contact-us` once in dev.

## Impact / Risks
- **Deployments** must set `MAIL_*` for SMTP; remove reliance on `SENDGRID_API_KEY`.
- Brevo requires verified sender/domain matching `MAIL_FROM_ADDRESS`.
