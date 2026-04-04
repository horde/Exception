# Horde Exception — Usage Guide

## Choosing the Right Exception Base Class

Every Horde exception implements `HordeThrowable` and `LogThrowable`, giving you
`getDetails()`/`setDetails()` and `markAsLogged()`/`isLogged()` regardless of
which base you pick. The question is **which SPL base** fits your error.

### Use-Case Table

| Use case | Traditional (lib/) | Modern (src/) |
|---|---|---|
| Generic error, no specific category | `Horde_Exception` | `HordeException` |
| Runtime failure (I/O, process, network) | `Horde_Exception` | `HordeRuntimeException` |
| Caller passed an invalid argument | `Horde_Exception` | `HordeInvalidArgumentException` |
| Programmer error / impossible state | `Horde_Exception` | `HordeLogicException` |
| Value outside domain rules | `Horde_Exception` | `HordeDomainException` |
| Invalid method call / wrong state | `Horde_Exception` | `HordeBadMethodCallException` |
| Length constraint violated | `Horde_Exception` | `HordeLengthException` |
| Index out of bounds (data-dependent) | `Horde_Exception` | `HordeOutOfBoundsException` |
| Index out of range (programmer error) | `Horde_Exception` | `HordeOutOfRangeException` |
| Unexpected value from external source | `Horde_Exception` | `HordeUnexpectedValueException` |
| Resource not found (404-style) | `Horde_Exception_NotFound` | `NotFound` |
| Permission denied (403-style) | `Horde_Exception_PermissionDenied` | `PermissionDenied` |
| Wrapping a PHP error from `error_get_last()` | `Horde_Exception_LastError` | `LastError` |
| Converting a PEAR_Error | `Horde_Exception_Pear` | `Pear` (deprecated) |
| Wrapping a PEAR_Error with userinfo extraction | `Horde_Exception_Wrapped` | `Wrapped` (see below) |

### The Rule of Thumb

- **Component exceptions** (e.g. `SpellCheckException`, `CacheException`)
  should extend the SPL-based class that matches the error category — usually
  `HordeRuntimeException` for I/O-related failures.

- **`HordeException`** is the catch-all. If none of the specific SPL classes
  fit, use it — but prefer a specific one when one applies.

- Libraries should carefully choose: If they are fairly isolated from Horde ecosystem and have a high
  chance of usage outside, NOT relying on the Horde exception tree might be attractive and reduce dependency creep.

- **Broad Catch against `HordeThrowable`**: If you need a broad catch, catch against HordeThrowable. This catches both
  PSR-0 and PSR-4 exceptions. This neatly separates framework internal concerns (we potentially know to handle) from outside failures
  (which we would have caught somewhere more specific, closer to the root cause if we knew to handle them).

## What `Wrapped` Is For (and Why You Probably Don't Want It)

### Purpose

`Wrapped` exists for one specific use case from the Horde 3/4 era: converting a
**`PEAR_Error` object** into an exception. When you pass a `PEAR_Error` as the
first argument, `Wrapped` extracts:

- The message via `getMessage()`
- The error code via `getCode()`
- Userinfo via `getUserinfo()` → stored in `$details`

```php
// The intended use — wrapping a PEAR_Error:
$pearError = PEAR::raiseError('something failed', 42);
throw new Horde_Exception_Wrapped($pearError);
// message = "something failed", code = 42, details = userinfo
```

### Why It's Usually the Wrong Choice

`Wrapped` was the only way to preserve exception chain context in the PEAR era.
Modern PHP has had `$previous` (the third constructor argument) since PHP 5.3.
Every SPL exception — and every Horde exception — already supports it:

```php
throw new HordeRuntimeException('Context message', 0, $previousException);
```

Using `Wrapped` for exception chaining instead of `$previous` creates problems:

1. **Legacy `Horde_Exception_Wrapped` silently drops `$previous`.**
   Its constructor signature is `($message, $code)` — only two parameters.
   If you write `new Horde_Exception_Wrapped($msg, $code, $previous)`, the
   third argument is silently ignored by PHP. The chain is lost.

2. **Passing an Exception as `$message` is a workaround, not an API.**
   `Wrapped` detects `instanceof Exception` on the first argument and sets
   `$previous` internally. This works but is confusing — callers expect the
   first argument to be a string.

3. **No SPL specificity.** `Wrapped` extends `HordeException` which extends
   `Exception`. You lose the ability to distinguish runtime errors from logic
   errors, invalid arguments from domain violations, etc.

### What to Use Instead

| Situation | Wrong | Right |
|---|---|---|
| Rethrowing with context | `new Wrapped($e)` | `new HordeRuntimeException('Context', 0, $e)` |
| Component exception chain | `new MyException($msg, $code, $e)` extending `Wrapped` | `new MyException($msg, $code, $e)` extending `HordeRuntimeException` |
| Converting PEAR_Error | — | `new Wrapped($pearError)` (this is the valid use) |

### Migration from `Wrapped`

If your component exception currently extends `Horde_Exception_Wrapped` or
`Horde\Exception\Wrapped`:

```php
// Before — extends Wrapped, loses $previous on legacy path
class Horde_MyComponent_Exception extends Horde_Exception_Wrapped {}

// After — component exception with proper chain support
// In src/:
use Horde\Exception\HordeRuntimeException;
class MyComponentException extends HordeRuntimeException {}

// In lib/ (wrapper, kept for BC):
class Horde_MyComponent_Exception extends Horde_Exception_Wrapped {}
// Document in phpdoc: wontfix/BC, new code should use src/ exception
```

## Creating Component Exceptions

A component exception should:

1. Live in `src/Exception/` under the component namespace
2. Extend the SPL-based Horde exception that best fits
3. Add no logic unless the component genuinely needs it

```php
<?php
// src/Exception/SpellCheckException.php

declare(strict_types=1);

namespace Horde\SpellChecker\Exception;

use Horde\Exception\HordeRuntimeException;

class SpellCheckException extends HordeRuntimeException {}
```

Callers catch it specifically or via interface:

```php
use Horde\SpellChecker\Exception\SpellCheckException;
use Horde\Exception\HordeThrowable;

// Specific
try {
    $checker->spellCheck($text);
} catch (SpellCheckException $e) {
    // handle spellcheck failure
}

// Broad — catches any Horde exception
try {
    $checker->spellCheck($text);
} catch (HordeThrowable $e) {
    // handle any Horde error
}
```
