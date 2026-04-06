## Title
Define `brevo` mailer in `config/mail.php`

## Summary
Deployments using `MAIL_MAILER=brevo` throw `InvalidArgumentException: Mailer [brevo] is not defined` because only `smtp` and other built-in names exist. Add a `brevo` SMTP mailer (Brevo-compatible defaults).

## Background / Context
- **Steps:** Set `MAIL_MAILER=brevo` with Brevo `MAIL_*` credentials; submit contact form.
- **Observed:** Exception; contact row is saved but mail fails.
- **Expected:** Mail sends via Brevo SMTP.

## Requirements
- [ ] `config/mail.php` defines `mailers.brevo` as SMTP using `MAIL_*` (default host `smtp-relay.brevo.com` when `MAIL_HOST` unset).
- [ ] `.env.example` / README note optional `MAIL_MAILER=brevo`.

## Testing
- PHPUnit: assert `config('mail.mailers.brevo.transport')` is `smtp`.
- Manual: `MAIL_MAILER=brevo` + valid Brevo credentials; contact form sends.

## Impact / Risks
- Low; additive config only.
