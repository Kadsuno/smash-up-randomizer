## Add social login (OAuth) for frontend users

## Summary
Users can sign in or register using Google or GitHub in addition to email/password. OAuth accounts store a nullable password and optional `provider` / `provider_id` on `users`.

## Background / Context
- Session-based frontend auth already exists (`/login`, `/register`).
- Admins remain role-separated; new OAuth users get `role = user`.
- Trusted OAuth providers set `email_verified_at` when an email is returned.

## Requirements
- [ ] Laravel Socialite with Google and GitHub redirect/callback routes under `guest` middleware
- [ ] Migration: `password` nullable; `provider` and `provider_id` nullable; unique (`provider`, `provider_id`)
- [ ] Find-or-create / link-by-verified-email flow for OAuth users
- [ ] Login and register pages show provider buttons when `GOOGLE_CLIENT_ID` / `GITHUB_CLIENT_ID` are set
- [ ] Account edit: hide password change when user has no password (OAuth-only)
- [ ] EN + DE strings; `.env.example` documented
- [ ] PHPUnit feature tests with mocked Socialite

## Technical notes
- `config/services.php` entries; callback URLs `{APP_URL}/auth/{provider}/callback`
- Handle missing email from provider (e.g. private GitHub email) with flash error

## Testing
- Feature tests: OAuth callback creates user; existing email links; invalid provider 404

## Impact / Risks
- Requires OAuth apps in Google Cloud / GitHub Developer Settings
- Rollback: migration down + remove package

## Roadmap
N/A unless listed in Now/Next.

## Public copy
CHANGELOG [Unreleased]; lang files; optional README OAuth setup note
