## Title
Add TOTP-based MFA for frontend login and account security

## Summary
Introduce optional two-factor authentication (TOTP apps such as Google Authenticator) for session-based frontend users. After a successful password or OAuth sign-in, users with MFA enabled must complete a one-time code challenge before the session is established.

## Background / Context
- **User story:** As a registered user, I want to protect my account with MFA so that stolen passwords or OAuth tokens alone are not enough to access my session.
- **Current behavior:** `LoginRequest` calls `Auth::attempt` and logs the user in immediately. OAuth callback logs in immediately.
- **Scope:** TOTP (RFC 6238) with recovery codes; bilingual EN/DE copy; feature tests for login challenge and setup flows.

## Requirements
- [ ] Migration adds nullable encrypted `two_factor_secret`, encrypted `two_factor_recovery_codes` (hashed codes), and `two_factor_confirmed_at` on `users`.
- [ ] Password login: if credentials are valid and MFA is confirmed for the user, do not complete login; store pending user id (+ remember flag) in session and redirect to a dedicated MFA challenge route until OTP or recovery code succeeds.
- [ ] OAuth login: same pending challenge when MFA is enabled (no full session until challenge passes).
- [ ] Challenge route is only usable with a valid pending login in session; rate-limit verification attempts.
- [ ] Account area: enable MFA (QR + manual secret, confirm with OTP), show/regenerate recovery codes, disable MFA (password if present, otherwise OTP or recovery code).
- [ ] User-visible strings in `resources/lang/en/frontend.php` and `resources/lang/de/frontend.php`; entry in `CHANGELOG.md` `[Unreleased]`.

## Technical notes
- Dependency: `pragmarx/google2fa` (+ QR rendering compatible with PHP 8.3 / Laravel 13).
- Reuse existing Blade layout patterns (`auth/frontend-login`, `account/edit`).
- `User` model: helper methods for “MFA enabled”, hidden encrypted attributes.

## Testing
- **PHPUnit:** Feature tests for password login → challenge → success; invalid OTP; OAuth user with MFA → challenge; enable/disable flows with appropriate guards.
- **Manual:** DDEV site, EN/DE, authenticator app scan and recovery code use.

## Impact / Risks
- Users who enable MFA must keep recovery codes safe; document in UI.
- Session fixation mitigated by `session()->regenerate()` after successful MFA (and existing login flow).
