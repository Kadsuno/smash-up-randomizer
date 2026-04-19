## Title
Remove duplicate root `lang/` tree; load landing copy from `resources/lang`

## Summary
Laravel resolves `app()->langPath()` to **`resources/lang`** when that directory exists, so edits under root `lang/` had no effect on the running app. Duplicate tree removed; landing strings applied to the canonical files.

## Requirements
- [x] Sync utility-tone landing strings in `resources/lang/{en,de}/frontend.php`
- [x] Delete root `lang/` directory
- [x] Document single source of truth in README and Cursor workflow rule

## Testing
- `ddev exec php artisan test` (163 tests)
