# Upgrading to Exception 3.0 (PSR-4)

## Overview

Version 3.0 introduces a PER-1 variant of horde exceptions.

Legacy PSR-0 `lib/` remain for backward compatibility with the old interface though a wrapper also exists.

## Requirements

- PHP 8.2 or later

## Key Changes

### Interface-Based Architecture

New code should type hint against `Horde\Exception\HordeThrowable` interface, not concrete classes:

```php
// Old - type hint against concrete class
catch (Horde_Exception $e) { }

// New - type hint against interface
use Horde\Exception\HordeThrowable;
catch (HordeThrowable $e) { }
```

### PEAR_Error Support Deprecated

`Horde\Exception\Pear` class exists for legacy conversion but should not be used in new code.

## Breaking Changes

### Type Signature Incompatibility

**CRITICAL:** `Horde_Exception` and `Horde\Exception\HordeException` are distinct types:

```php
function handleError(Horde_Exception $e) { }

$modern = new Horde\Exception\HordeException('error');
handleError($modern);  // TypeError
```

**Solutions:**
1. Accept both: `function handleError(Horde_Exception|Horde\Exception\HordeException $e)`
2. Type hint interface: `function handleError(Horde\Exception\HordeThrowable $e)`
3. Migrate fully to PSR-4

### Strict Types

All PSR-4 classes use `declare(strict_types=1);` with enforced type hints.

## Class Mapping

| PSR-0 (lib/) | PSR-4 (src/) | Notes |
|-------------|-------------|-------|
| `Horde_Exception` | `Horde\Exception\HordeException` | Extends Exception, implements HordeThrowable |
| `Horde_Exception_Wrapped` | `Horde\Exception\Wrapped` | Wraps previous exceptions |
| `Horde_Exception_LastError` | `Horde\Exception\LastError` | Converts PHP errors |
| `Horde_Exception_NotFound` | `Horde\Exception\NotFound` | 404-style exceptions |
| `Horde_Exception_PermissionDenied` | `Horde\Exception\PermissionDenied` | 403-style exceptions |
| `Horde_Exception_Pear` | `Horde\Exception\Pear` | PEAR_Error conversion (deprecated) |
| `Horde_Exception_Translation` | `Horde\Exception\Translation` | Translation support |

### New SPL-Based Exceptions

Modern implementation provides SPL exception variants:

| Class | Extends | Implements |
|-------|---------|------------|
| `HordeBadMethodCallException` | BadMethodCallException | HordeThrowable |
| `HordeDomainException` | DomainException | HordeThrowable |
| `HordeInvalidArgumentException` | InvalidArgumentException | HordeThrowable |
| `HordeLengthException` | LengthException | HordeThrowable |
| `HordeLogicException` | LogicException | HordeThrowable |
| `HordeOutOfBoundsException` | OutOfBoundsException | HordeThrowable |
| `HordeOutOfRangeException` | OutOfRangeException | HordeThrowable |
| `HordeRuntimeException` | RuntimeException | HordeThrowable |

Use these instead of base `HordeException` for better semantic meaning.

## Migration Strategies

### Strategy 1: Type Hint Against Interface

Catch all Horde exceptions regardless of PSR-0 or PSR-4:

```php
use Horde\Exception\HordeThrowable;

try {
    // Code that throws Horde_Exception or Horde\Exception\*
} catch (HordeThrowable $e) {
    // Catches both old and new
    echo $e->getMessage();
    echo $e->getDetails();
}
```

### Strategy 2: Gradual Migration

Migrate file by file:

```php
// Update imports
use Horde\Exception\HordeException;
use Horde\Exception\NotFound;
use Horde\Exception\PermissionDenied;

// Throw modern exceptions
throw new HordeException('Error message');
throw new NotFound('Resource not found');
```

## Common Patterns

### Basic Exception

```php
// Old
throw new Horde_Exception('Error message');

// New
use Horde\Exception\HordeException;
throw new HordeException('Error message');
```

### Exception with Details

```php
// Old
$e = new Horde_Exception('Error');
$e->details = 'Debug information';
throw $e;

// New
use Horde\Exception\HordeException;
$e = new HordeException('Error');
$e->setDetails('Debug information');
throw $e;
```

### Wrapped Exception

```php
// Old
throw new Horde_Exception_Wrapped('Context', $previous);

// New
use Horde\Exception\Wrapped;
throw new Wrapped('Context', $previous);
```

### Not Found Exception

```php
// Old
throw new Horde_Exception_NotFound('User not found');

// New
use Horde\Exception\NotFound;
throw new NotFound('User not found');
```

### Using SPL Variants

```php
// New - semantic exceptions
use Horde\Exception\HordeInvalidArgumentException;
use Horde\Exception\HordeRuntimeException;

if (empty($required)) {
    throw new HordeInvalidArgumentException('Required parameter missing');
}

if ($connection->isClosed()) {
    throw new HordeRuntimeException('Database connection closed');
}
```

## Troubleshooting

### TypeError: must be Horde_Exception

**Cause:** Type hint expects PSR-0 but received PSR-4.

**Solution:** Change type hint to `Horde\Exception\HordeThrowable` interface.

### Property $details does not exist

**Cause:** Direct access to deprecated public `$details` property.

**Solution:** Use methods:
```php
// Old
$e->details = 'info';
echo $e->details;

// New
$e->setDetails('info');
echo $e->getDetails();
```

### Cannot catch Horde\Exception\HordeException

**Cause:** Old catch block uses PSR-0 class name.

**Solution:**
```php
// Update catch block
use Horde\Exception\HordeThrowable;
catch (HordeThrowable $e) { }
```

## Version History

- **3.0.0-beta4** (2026-03): Added missing base SPL exceptions
- **3.0.0-beta3** (2026-03): Fixed PEAR compatibility autoload
- **3.0.0-beta2** (2026-03): PEAR shim refactoring
- **3.0.0-beta1** (2026-03): Initial PSR-4 implementation
- **2.x** (Horde 5): Legacy PSR-0 implementation
