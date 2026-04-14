## Add profile editing to account page

## Summary
Authenticated users currently have no way to update their display name, e-mail address, or password from the `/account` page. This ticket adds inline edit forms for both profile information and password change.

## Background / Context
- **Current behavior:** `/account` shows read-only profile data (name, email, member since, role).
- **User story:** As a registered user I want to update my display name, e-mail, and password without contacting an admin.
- The frontend auth system (session-based, separate from admin) was introduced in a previous ticket. The `AccountController` currently only has an `index()` method.
- E-mail changes should re-trigger e-mail verification (`MustVerifyEmail` is already implemented on the `User` model).

## Requirements
- [ ] User can update their display name (required, max 255)
- [ ] User can update their e-mail address (required, valid e-mail, unique except self); on change the account is marked unverified and a new verification mail is sent
- [ ] User can change their password (requires current password confirmation, new password min 8 chars, confirmation field)
- [ ] Success feedback via session flash message on the same page
- [ ] Validation errors shown inline per field
- [ ] All strings bilingual (EN + DE)
- [ ] Password field never pre-filled

## Technical notes
- **Affected areas:** `app/Http/Controllers/AccountController.php`, `routes/frontend-auth.php`, `resources/views/account/index.blade.php`, `resources/lang/en/frontend.php`, `resources/lang/de/frontend.php`
- Two new PATCH routes: `PATCH /account/profile` (`account.profile.update`) and `PATCH /account/password` (`account.password.update`)
- Use Laravel's `Hash::check` for current password verification
- Use `$user->forceFill(['email_verified_at' => null])` + `sendEmailVerificationNotification()` on e-mail change
- Keep forms as sections on the existing `/account` page (no separate pages); use `@if($errors->profileErrors->any())` error bags to separate the two forms

## Testing
- **PHPUnit** (`tests/Feature`):
  - `AccountProfileUpdateTest`: valid update, duplicate e-mail, name too long, e-mail change triggers unverification
  - `AccountPasswordUpdateTest`: correct flow, wrong current password, new password mismatch
- **Manual / browser:** Submit each form with valid + invalid data; verify flash messages and error highlighting; check DE strings load correctly

## Impact / Risks
- E-mail change makes account unverified → user is redirected to verification notice (existing middleware handles this)
- No migration needed
- Rollback: revert controller + route additions; view changes are additive only

## Roadmap
N/A — not listed in roadmap Now/Next.

## Public copy
- `CHANGELOG.md` `[Unreleased]`: user-visible feature
- `resources/lang/en/frontend.php` + `resources/lang/de/frontend.php`: new strings required
