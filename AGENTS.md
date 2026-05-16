# AGENTS.md

## Cursor Cloud specific instructions

This is a PHP SDK library (`tilta-io/tilta-php-sdk`) — no running application server; it is a Composer package tested via PHPUnit, PHPStan, and coding-standard tools.

### Quick reference (all commands from repo root)

| Task | Command |
|---|---|
| Install dependencies | `composer install` |
| Lint (rector + ecs) | `composer lint` |
| Static analysis (PHPStan level 9) | `composer phpstan` |
| Run all tests | `composer phpunit` |
| Run offline-only tests (no API creds) | `./vendor/bin/phpunit -c phpunit.xml.dist tests/Functional/Util tests/Functional/Model tests/Acceptance` |

### Test suites and API credentials

- **Offline tests** (`tests/Functional/Model`, `tests/Functional/Util`, `tests/Acceptance`) run entirely with mocked data and require no environment variables.
- **Online/integration tests** (`tests/Functional/Service`, `tests/Functional/FullTest`) make real HTTP calls to the Tilta staging API and require the following env vars: `TILTA_API_TOKEN`, `TILTA_MERCHANT_ID`, `TILTA_TEST_BUYER`. Without these, those tests will fail with `UserNotAuthorizedException`.
- `TILTA_SDK_API_DOMAIN` defaults to `api.tilta-stage.io` in `phpunit.xml.dist`.

### System requirements

- PHP 8.1+ with extensions: `curl`, `json`, `mbstring`, `xml`, `zip`.
- Composer 2.x.
- No database or Docker required.
