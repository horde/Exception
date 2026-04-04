<?php

declare(strict_types=1);

/**
 * Copyright 2026 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Exception
 * @author   Ralf Lang <ralf.lang@ralf-lang.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */

namespace Horde\Exception\Test\Unit;

use Exception;
use Horde\Exception\HordeBadMethodCallException;
use Horde\Exception\HordeDomainException;
use Horde\Exception\HordeInvalidArgumentException;
use Horde\Exception\HordeLengthException;
use Horde\Exception\HordeLogicException;
use Horde\Exception\HordeOutOfBoundsException;
use Horde\Exception\HordeOutOfRangeException;
use Horde\Exception\HordeRuntimeException;
use Horde\Exception\HordeThrowable;
use Horde\Exception\HordeUnexpectedValueException;
use Horde\Exception\LogThrowable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use InvalidArgumentException;
use LogicException;
use DomainException;
use OutOfBoundsException;
use OutOfRangeException;
use UnexpectedValueException;
use BadMethodCallException;
use LengthException;

/**
 * Tests for all Horde*Exception classes based on PHP built-in exceptions.
 *
 * @category Horde
 * @package  Exception
 * @author   Ralf Lang <ralf.lang@ralf-lang.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */
#[CoversClass(HordeRuntimeException::class)]
#[CoversClass(HordeInvalidArgumentException::class)]
#[CoversClass(HordeLogicException::class)]
#[CoversClass(HordeDomainException::class)]
#[CoversClass(HordeOutOfBoundsException::class)]
#[CoversClass(HordeOutOfRangeException::class)]
#[CoversClass(HordeUnexpectedValueException::class)]
#[CoversClass(HordeBadMethodCallException::class)]
#[CoversClass(HordeLengthException::class)]
class BuiltinExceptionTest extends TestCase
{
    /**
     * Data provider for all exception classes
     */
    public static function exceptionClassProvider(): array
    {
        return [
            'HordeRuntimeException' => [
                HordeRuntimeException::class,
                RuntimeException::class,
            ],
            'HordeInvalidArgumentException' => [
                HordeInvalidArgumentException::class,
                InvalidArgumentException::class,
            ],
            'HordeLogicException' => [
                HordeLogicException::class,
                LogicException::class,
            ],
            'HordeDomainException' => [
                HordeDomainException::class,
                DomainException::class,
            ],
            'HordeOutOfBoundsException' => [
                HordeOutOfBoundsException::class,
                OutOfBoundsException::class,
            ],
            'HordeOutOfRangeException' => [
                HordeOutOfRangeException::class,
                OutOfRangeException::class,
            ],
            'HordeUnexpectedValueException' => [
                HordeUnexpectedValueException::class,
                UnexpectedValueException::class,
            ],
            'HordeBadMethodCallException' => [
                HordeBadMethodCallException::class,
                BadMethodCallException::class,
            ],
            'HordeLengthException' => [
                HordeLengthException::class,
                LengthException::class,
            ],
        ];
    }

    // Test inheritance and interfaces

    #[DataProvider('exceptionClassProvider')]
    public function testExtendsCorrectBuiltinException(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $this->assertInstanceOf($builtinClass, $exception);
    }

    #[DataProvider('exceptionClassProvider')]
    public function testImplementsHordeThrowable(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $this->assertInstanceOf(HordeThrowable::class, $exception);
    }

    #[DataProvider('exceptionClassProvider')]
    public function testImplementsLogThrowable(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $this->assertInstanceOf(LogThrowable::class, $exception);
    }

    // Test basic exception behavior

    #[DataProvider('exceptionClassProvider')]
    public function testEmptyConstructionYieldsEmptyMessage(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $this->assertSame('', $exception->getMessage());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testConstructionWithMessage(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass('Test message');
        $this->assertSame('Test message', $exception->getMessage());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testConstructionWithCode(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass('Test message', 42);
        $this->assertSame(42, $exception->getCode());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testConstructionWithPreviousException(string $hordeClass, string $builtinClass): void
    {
        $previous = new Exception('Previous exception');
        $exception = new $hordeClass('Test message', 0, $previous);
        $this->assertSame($previous, $exception->getPrevious());
        $this->assertSame('Previous exception', $exception->getPrevious()->getMessage());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testToStringContainsExceptionClass(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass('Test message');
        $string = (string) $exception;
        $this->assertStringContainsString($hordeClass, $string);
        $this->assertStringContainsString('Test message', $string);
    }

    // Test HordeThrowable interface (getDetails/setDetails)

    #[DataProvider('exceptionClassProvider')]
    public function testGetDetailsInitiallyEmpty(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $this->assertSame('', $exception->getDetails());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testSetDetailsAndRetrieve(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $exception->setDetails('Additional debugging information');
        $this->assertSame('Additional debugging information', $exception->getDetails());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testSetDetailsMultipleTimes(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $exception->setDetails('First details');
        $exception->setDetails('Second details');
        $this->assertSame('Second details', $exception->getDetails());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testDetailsDoesNotAffectMessage(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass('Main message');
        $exception->setDetails('Extra details');
        $this->assertSame('Main message', $exception->getMessage());
        $this->assertSame('Extra details', $exception->getDetails());
    }

    // Test LogThrowable interface (log level and logging status)

    #[DataProvider('exceptionClassProvider')]
    public function testGetLogLevelDefaultsToZero(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $this->assertSame(0, $exception->getLogLevel());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testSetLogLevelAsInteger(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $exception->setLogLevel(3);
        $this->assertSame(3, $exception->getLogLevel());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testSetLogLevelMultipleTimes(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $exception->setLogLevel(2);
        $exception->setLogLevel(5);
        $this->assertSame(5, $exception->getLogLevel());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testIsLoggedInitiallyFalse(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $this->assertFalse($exception->isLogged());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testMarkAsLoggedSetsFlag(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $exception->markAsLogged();
        $this->assertTrue($exception->isLogged());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testMarkAsLoggedIsPermanent(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $exception->markAsLogged();
        $exception->markAsLogged(); // Calling again should be safe
        $this->assertTrue($exception->isLogged());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testLogLevelAndLoggedStatusAreIndependent(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass();
        $exception->setLogLevel(4);
        $this->assertFalse($exception->isLogged()); // Setting level doesn't mark as logged

        $exception->markAsLogged();
        $this->assertSame(4, $exception->getLogLevel()); // Marking as logged doesn't change level
    }

    // Test exception can be thrown and caught

    #[DataProvider('exceptionClassProvider')]
    public function testExceptionCanBeThrownAndCaught(string $hordeClass, string $builtinClass): void
    {
        $caught = false;
        $exception = null;
        try {
            throw new $hordeClass('Test exception');
        } catch (HordeThrowable $e) {
            $caught = true;
            $exception = $e;
        }
        $this->assertTrue($caught, "Exception {$hordeClass} was not caught");
        $this->assertInstanceOf($hordeClass, $exception);
        $this->assertSame('Test exception', $exception->getMessage());
    }

    #[DataProvider('exceptionClassProvider')]
    public function testExceptionCanBeCaughtByHordeThrowable(string $hordeClass, string $builtinClass): void
    {
        $caught = false;
        try {
            throw new $hordeClass('Test exception');
        } catch (HordeThrowable $e) {
            $caught = true;
            $this->assertInstanceOf($hordeClass, $e);
        }
        $this->assertTrue($caught, "Exception {$hordeClass} was not caught by HordeThrowable");
    }

    #[DataProvider('exceptionClassProvider')]
    public function testExceptionCanBeCaughtByBuiltinType(string $hordeClass, string $builtinClass): void
    {
        $exception = new $hordeClass('Test exception');
        $this->assertInstanceOf($builtinClass, $exception);

        // Verify it can be caught as the builtin type
        $caught = false;
        try {
            throw $exception;
        } catch (HordeThrowable $e) {
            $caught = true;
            // Verify the exception is also an instance of the builtin class
            $this->assertInstanceOf($builtinClass, $e);
        }
        $this->assertTrue($caught, "Exception {$hordeClass} was not caught");
    }

    // Test complete exception chain with all features

    #[DataProvider('exceptionClassProvider')]
    public function testCompleteExceptionWithAllFeatures(string $hordeClass, string $builtinClass): void
    {
        $previous = new Exception('Root cause');
        $exception = new $hordeClass('Main error message', 500, $previous);
        $exception->setDetails('Stack trace: line 42 in file.php');
        $exception->setLogLevel(6);
        $exception->markAsLogged();

        // Verify all properties
        $this->assertSame('Main error message', $exception->getMessage());
        $this->assertSame(500, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
        $this->assertSame('Stack trace: line 42 in file.php', $exception->getDetails());
        $this->assertSame(6, $exception->getLogLevel());
        $this->assertTrue($exception->isLogged());
    }

    // Specific semantic tests for each exception type

    public function testHordeRuntimeExceptionIsRuntimeError(): void
    {
        $exception = new HordeRuntimeException('Configuration file not found');
        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertInstanceOf(HordeThrowable::class, $exception);
    }

    public function testHordeInvalidArgumentExceptionIsLogicError(): void
    {
        $exception = new HordeInvalidArgumentException('Limit must be positive');
        $this->assertInstanceOf(InvalidArgumentException::class, $exception);
        $this->assertInstanceOf(LogicException::class, $exception); // InvalidArgumentException extends LogicException
    }

    public function testHordeLogicExceptionIsLogicError(): void
    {
        $exception = new HordeLogicException('Invalid state transition');
        $this->assertInstanceOf(LogicException::class, $exception);
    }

    public function testHordeDomainExceptionIsLogicError(): void
    {
        $exception = new HordeDomainException('Invalid status value');
        $this->assertInstanceOf(DomainException::class, $exception);
        $this->assertInstanceOf(LogicException::class, $exception); // DomainException extends LogicException
    }

    public function testHordeOutOfBoundsExceptionIsRuntimeError(): void
    {
        $exception = new HordeOutOfBoundsException('Index 5 does not exist');
        $this->assertInstanceOf(OutOfBoundsException::class, $exception);
        $this->assertInstanceOf(RuntimeException::class, $exception); // OutOfBoundsException extends RuntimeException
    }

    public function testHordeOutOfRangeExceptionIsLogicError(): void
    {
        $exception = new HordeOutOfRangeException('Offset -1 is out of range');
        $this->assertInstanceOf(OutOfRangeException::class, $exception);
        $this->assertInstanceOf(LogicException::class, $exception); // OutOfRangeException extends LogicException
    }

    public function testHordeUnexpectedValueExceptionIsRuntimeError(): void
    {
        $exception = new HordeUnexpectedValueException('Expected JSON array');
        $this->assertInstanceOf(UnexpectedValueException::class, $exception);
        $this->assertInstanceOf(RuntimeException::class, $exception); // UnexpectedValueException extends RuntimeException
    }

    public function testHordeBadMethodCallExceptionIsLogicError(): void
    {
        $exception = new HordeBadMethodCallException('Must call prepare() first');
        $this->assertInstanceOf(BadMethodCallException::class, $exception);
        $this->assertInstanceOf(LogicException::class, $exception); // BadMethodCallException extends LogicException
    }

    public function testHordeLengthExceptionIsLogicError(): void
    {
        $exception = new HordeLengthException('Password must be at least 8 characters');
        $this->assertInstanceOf(LengthException::class, $exception);
        $this->assertInstanceOf(LogicException::class, $exception); // LengthException extends LogicException
    }

    // Test exception hierarchy catching

    public function testRuntimeExceptionsCanBeCaughtByRuntimeExceptionType(): void
    {
        $runtimeExceptions = [
            new HordeRuntimeException('test'),
            new HordeOutOfBoundsException('test'),
            new HordeUnexpectedValueException('test'),
        ];

        foreach ($runtimeExceptions as $exception) {
            $caught = false;
            try {
                throw $exception;
            } catch (RuntimeException $e) {
                $caught = true;
            }
            $this->assertTrue($caught, get_class($exception) . ' should be caught by RuntimeException');
        }
    }

    public function testLogicExceptionsCanBeCaughtByLogicExceptionType(): void
    {
        $logicExceptions = [
            new HordeLogicException('test'),
            new HordeInvalidArgumentException('test'),
            new HordeDomainException('test'),
            new HordeOutOfRangeException('test'),
            new HordeBadMethodCallException('test'),
            new HordeLengthException('test'),
        ];

        foreach ($logicExceptions as $exception) {
            $caught = false;
            try {
                throw $exception;
            } catch (LogicException $e) {
                $caught = true;
            }
            $this->assertTrue($caught, get_class($exception) . ' should be caught by LogicException');
        }
    }

    public function testAllExceptionsCanBeCaughtByHordeThrowable(): void
    {
        $allExceptions = [
            new HordeRuntimeException('test'),
            new HordeInvalidArgumentException('test'),
            new HordeLogicException('test'),
            new HordeDomainException('test'),
            new HordeOutOfBoundsException('test'),
            new HordeOutOfRangeException('test'),
            new HordeUnexpectedValueException('test'),
            new HordeBadMethodCallException('test'),
            new HordeLengthException('test'),
        ];

        foreach ($allExceptions as $exception) {
            $caught = false;
            try {
                throw $exception;
            } catch (HordeThrowable $e) {
                $caught = true;
            }
            $this->assertTrue($caught, get_class($exception) . ' should be caught by HordeThrowable');
        }
    }

    // Test realistic usage scenarios

    public function testRuntimeExceptionScenario(): void
    {
        try {
            throw new HordeRuntimeException('Database connection failed');
        } catch (HordeRuntimeException $e) {
            $e->setDetails('Server: localhost:5432, Database: horde');
            $e->setLogLevel(3); // Error level
            $e->markAsLogged();

            $this->assertSame('Database connection failed', $e->getMessage());
            $this->assertStringContainsString('localhost:5432', $e->getDetails());
            $this->assertTrue($e->isLogged());
        }
    }

    public function testInvalidArgumentExceptionScenario(): void
    {
        try {
            $limit = -5;
            if ($limit < 1) {
                throw new HordeInvalidArgumentException('Limit must be positive');
            }
        } catch (HordeInvalidArgumentException $e) {
            $e->setDetails('Provided value: -5, Expected: >= 1');
            $this->assertStringContainsString('positive', $e->getMessage());
            $this->assertStringContainsString('Provided value: -5', $e->getDetails());
        }
    }

    public function testDomainExceptionScenario(): void
    {
        try {
            $status = 'invalid';
            $validStatuses = ['pending', 'active', 'complete'];
            if (!in_array($status, $validStatuses)) {
                throw new HordeDomainException("Invalid status: {$status}");
            }
        } catch (HordeDomainException $e) {
            $e->setDetails('Valid statuses: pending, active, complete');
            $this->assertStringContainsString('invalid', $e->getMessage());
            $this->assertStringContainsString('Valid statuses:', $e->getDetails());
        }
    }

    public function testUnexpectedValueExceptionScenario(): void
    {
        try {
            $data = '{"not": "an array"}';
            $decoded = json_decode($data, true);
            if (!is_array($decoded) || array_keys($decoded) !== range(0, count($decoded) - 1)) {
                throw new HordeUnexpectedValueException('Expected JSON array, got object');
            }
        } catch (HordeUnexpectedValueException $e) {
            $e->setDetails('Received: {"not": "an array"}');
            $this->assertStringContainsString('JSON array', $e->getMessage());
        }
    }

    public function testBadMethodCallExceptionScenario(): void
    {
        try {
            $prepared = false;
            if (!$prepared) {
                throw new HordeBadMethodCallException('Must call prepare() before send()');
            }
        } catch (HordeBadMethodCallException $e) {
            $e->setDetails('Current state: unprepared');
            $this->assertStringContainsString('prepare()', $e->getMessage());
        }
    }

    public function testLengthExceptionScenario(): void
    {
        try {
            $password = 'short';
            if (strlen($password) < 8) {
                throw new HordeLengthException('Password must be at least 8 characters');
            }
        } catch (HordeLengthException $e) {
            $e->setDetails('Provided length: 5, Required: >= 8');
            $this->assertStringContainsString('8 characters', $e->getMessage());
        }
    }

    // Test exception chaining preserves all features

    public function testExceptionChainingPreservesDetails(): void
    {
        $root = new HordeRuntimeException('Root cause');
        $root->setDetails('Root details');
        $root->setLogLevel(2);

        $wrapped = new HordeLogicException('Wrapped error', 0, $root);
        $wrapped->setDetails('Wrapped details');
        $wrapped->setLogLevel(4);

        $this->assertSame('Wrapped error', $wrapped->getMessage());
        $this->assertSame('Wrapped details', $wrapped->getDetails());
        $this->assertSame(4, $wrapped->getLogLevel());

        $this->assertSame('Root cause', $wrapped->getPrevious()->getMessage());
        $this->assertSame('Root details', $wrapped->getPrevious()->getDetails());
        $this->assertSame(2, $wrapped->getPrevious()->getLogLevel());
    }
}
