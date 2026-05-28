## Contact Form Spam Hardening

Add layered bot protection to the contact form: rate limiting, session-based timing, stricter validation, and Cloudflare Turnstile CAPTCHA.

## Summary

The contact form is currently hit by automated bots that bypass the existing honeypot and client-side timing check. This ticket hardens the form with five complementary layers — each cheap to implement, collectively effective without friction for real users.

## Background / Context

- Current protection: honeypot field (`context`) + `start_time` hidden field (3 s min). Both are trivially bypassed — bots ignore hidden fields, and the timestamp is fully client-controlled.
- No rate limiting exists on `POST /contact-us`.
- Subject is validated as `string|max:255` only — any value accepted; no whitelist.
- Email validation is syntax-only; disposable/fake domains pass through.
- Cloudflare Turnstile (free, privacy-friendly, GDPR-compatible) is the nuclear option and the most effective single measure.

## Requirements

- [ ] `POST /contact-us` has a Laravel `throttle:5,10` middleware (5 requests per 10 minutes per IP)
- [ ] `start_time` is stored in the session server-side (not in the form) and verified on submit; client-controlled value removed
- [ ] `subject` is validated as `in:Bug report,Missing faction,Feature request,General feedback,Other`
- [ ] `message` has a `min:20` character constraint
- [ ] `email` uses `email:rfc,dns` validation rule
- [ ] Cloudflare Turnstile is integrated: site key rendered in the form, server-side token verification via `Http` facade against `https://challenges.cloudflare.com/turnstile/v0/siteverify`
- [ ] Turnstile verification is skipped in test environment (`app()->environment('testing')`)
- [ ] `TURNSTILE_SITE_KEY` and `TURNSTILE_SECRET_KEY` added to `config/services.php` + `.env.example`
- [ ] Existing honeypot field retained (cheap, layered defense)

## Technical notes

- **No new Composer package** — Turnstile verification uses Laravel's `Http` facade (already available)
- Affected paths: `routes/web.php`, `app/Http/Controllers/ContactController.php`, `resources/views/contact/contactForm.blade.php`, `config/services.php`, `.env.example`
- Session key: `contact_form_start` — set on `GET /contact-us`, checked + cleared on successful `POST`
- Plan: see CreatePlan (Phase 3)

## Testing

- **PHPUnit** (`tests/Feature/ContactFormTest.php`):
  - Happy path: valid submission passes all layers
  - Honeypot: `context` filled → rejected
  - Timing: submitted before session timing window → rejected
  - Rate limit: 6th request within 10 min → 429
  - Subject whitelist: invalid value → validation fails
  - Message too short: < 20 chars → validation fails
  - Turnstile: mocked `Http` facade — success and failure responses
- **Manual / browser**: submit form on DDEV, verify Turnstile widget renders, verify valid submission succeeds and spam attempts are blocked

## Impact / Risks

- Turnstile requires `TURNSTILE_SITE_KEY` / `TURNSTILE_SECRET_KEY` in `.env` — without them the form blocks all submissions in non-test envs (guard with fallback or skip when key is empty)
- DNS email check may slow validation ~50–200 ms; acceptable for a contact form
- Rate limiting is per-IP — shared NAT / proxies could occasionally hit limit; 5 per 10 min is generous for legit use
- Rollback: remove Turnstile script + server-side check; revert validation rules; remove throttle middleware
