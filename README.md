# Horde Exception

Exception handling library for the [Horde Project](https://www.horde.org/).

Provides a set of exception base classes that integrate with the Horde
framework. All exceptions implement `HordeThrowable` (details support) and
`LogThrowable` (log-level tracking), and extend PHP's SPL exception hierarchy
for proper semantic categorisation.

## Installation

```bash
composer require horde/exception
```

## Quick Start

```php
use Horde\Exception\HordeRuntimeException;
use Horde\Exception\HordeThrowable;

// Throw a typed exception
throw new HordeRuntimeException('Connection failed', 0, $previous);

// Catch any Horde exception via the interface
try {
    // ...
} catch (HordeThrowable $e) {
    echo $e->getMessage();
    echo $e->getDetails();
}
```

## Choosing an Exception Base Class

| Error type | Base class |
|---|---|
| Runtime / I/O failure | `HordeRuntimeException` |
| Invalid argument from caller | `HordeInvalidArgumentException` |
| Programmer logic error | `HordeLogicException` |
| Domain rule violation | `HordeDomainException` |
| Resource not found | `NotFound` |
| Permission denied | `PermissionDenied` |
| Generic / uncategorised | `HordeException` |

Component exceptions should extend the SPL-based class that best fits
(e.g. `class CacheException extends HordeRuntimeException {}`).

See [doc/USAGE.md](doc/USAGE.md) for the full use-case table, guidance on
`Wrapped` vs standard exceptions, and component exception patterns.

## Documentation

- **[doc/USAGE.md](doc/USAGE.md)** — Choosing the right base class, the
  `Wrapped` pitfall, creating component exceptions
- **[doc/UPGRADING.md](doc/UPGRADING.md)** — Migrating from PSR-0 to PSR-4,
  class mapping table, breaking changes

## License

LGPL-2.1-only. See [LICENSE](LICENSE) for details.
