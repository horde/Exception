<?php

declare(strict_types=1);

/**
 * Copyright 2009-2026 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Exception
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */

namespace Horde\Exception\Test\Unit;

use Exception;
use Horde_Exception;
use Horde_Exception_LastError;
use Horde_Exception_NotFound;
use Horde_Exception_Pear;
use Horde_Exception_PearError;
use Horde_Exception_PermissionDenied;
use Horde_Exception_Stub_PearError;
use Horde_Exception_Wrapped;
use PEAR_Error;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the unnamespaced Horde_Exception class.
 *
 * @category Horde
 * @package  Exception
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @coversNothing
 */
class UnnamespacedExceptionTest extends TestCase
{
    // Basic Exception Testing

    public function testEmptyConstructionYieldsEmptyMessage(): void
    {
        $e = new Horde_Exception();
        $this->assertSame('', $e->getMessage());
    }

    public function testEmptyConstructionYieldsCodeZero(): void
    {
        $e = new Horde_Exception();
        $this->assertSame(0, $e->getCode());
    }

    public function testMethodGetpreviousYieldsPreviousException(): void
    {
        $e = new Horde_Exception('', 0, new Exception('previous'));
        $this->assertEquals('previous', $e->getPrevious()->getMessage());
    }

    public function testMethodTostringYieldsExceptionDescription(): void
    {
        $e = new Horde_Exception();
        $this->assertMatchesRegularExpression('/(exception |^)\'?Horde_Exception\'? in/', (string) $e);
    }

    /**
     * This test runs against a method of the original PHP \Exception.
     * Why do we test it here?
     */
    public function testMethodTostringContainsDescriptionOfPreviousException(): void
    {
        $e = new Horde_Exception('', 0, new Exception('previous'));
        $this->assertMatchesRegularExpression('/Next Horde_Exception/', (string) $e);
        $this->assertMatchesRegularExpression('/Exception: previous/', (string) $e);
    }

    // NotFound Exception Testing

    public function testEmptyConstructionYieldsNotFoundMessage(): void
    {
        setlocale(LC_MESSAGES, 'C');
        $e = new Horde_Exception_NotFound();
        $this->assertSame('Not Found', $e->getMessage());
    }

    // Basic Exception Testing

    public function testEmptyConstructionYieldsPermissionDeniedMessage(): void
    {
        setlocale(LC_MESSAGES, 'C');
        $e = new Horde_Exception_PermissionDenied();
        $this->assertSame('Permission Denied', $e->getMessage());
    }

    // Prior Exception Testing

    public function testConstructionWithPearErrorYieldsMessageFromPearError(): void
    {
        require_once __DIR__ . '/../Stub/PearError.php';
        $p = new Horde_Exception_Stub_PearError('pear');
        $e = new Horde_Exception_Wrapped($p);
        $this->assertSame('pear', $e->getMessage());
    }

    public function testConstructionWithPearErrorYieldsCodeFromPearError(): void
    {
        require_once __DIR__ . '/../Stub/PearError.php';
        $p = new Horde_Exception_Stub_PearError('pear', 666);
        $e = new Horde_Exception_Wrapped($p);
        $this->assertSame(666, $e->getCode());
    }

    // LastError Exception Testing

    public function testConstructionOfLastErrorYieldsStandardException(): void
    {
        $e = new Horde_Exception_LastError();
        $this->assertSame('', $e->getMessage());
    }

    public function testConstructionWithGetlasterrorarrayYieldsMessageFromArray(): void
    {
        $e = new Horde_Exception_LastError('', $this->getLastError());
        $this->assertSame('get_last_error', $e->getMessage());
    }

    public function testConstructionWithGetlasterrorarrayYieldsCodeFromArray(): void
    {
        $e = new Horde_Exception_LastError('', $this->getLastError());
        $this->assertSame(666, $e->getCode());
    }

    public function testConstructionWithGetlasterrorarrayYieldsFileFromArray(): void
    {
        $e = new Horde_Exception_LastError('', $this->getLastError());
        $this->assertSame('/some/file.php', $e->getFile());
    }

    public function testConstructionWithGetlasterrorarrayYieldsLineFromArray(): void
    {
        $e = new Horde_Exception_LastError('', $this->getLastError());
        $this->assertSame(99, $e->getLine());
    }

    public function testConstructionWithGetlasterrorarrayConcatenatesMessagesFromConstructorAndErrorarray(): void
    {
        $e = new Horde_Exception_LastError('An error occurred: ', $this->getLastError());
        $this->assertSame('An error occurred: get_last_error', $e->getMessage());
    }

    public function testCatchingAndConvertingPearErrors(): void
    {
        $this->loadPear();
        try {
            Horde_Exception_Pear::catchError(new PEAR_Error('An error occurred.'));
        } catch (Horde_Exception_Pear $e) {
            $this->assertStringContainsString(
                'Horde\Exception\Test\Unit\UnnamespacedExceptionTest->testCatchingAndConvertingPearErrors',
                $e->details
            );
        }
    }

    public function testStringUserinfo(): void
    {
        $this->loadPear();
        try {
            Horde_Exception_Pear::catchError(
                new PEAR_Error('An error occurred.', null, null, null, 'userinfo')
            );
        } catch (Horde_Exception_Pear $e) {
            $this->assertStringContainsString('userinfo', $e->details);
        }
    }

    public function testArrayUserinfo(): void
    {
        $this->loadPear();
        try {
            Horde_Exception_Pear::catchError(
                new PEAR_Error('An error occurred.', null, null, null, ['userinfo'])
            );
        } catch (Horde_Exception_Pear $e) {
            $this->assertStringContainsString('[0] => userinfo', $e->details);
        }
    }

    private function getLastError(): array
    {
        return [
            'message' => 'get_last_error',
            'type'    => 666,
            'file'    => '/some/file.php',
            'line'    => 99,
        ];
    }

    private function loadPear(): void
    {
        @include_once 'PEAR.php';
        if (!class_exists('PEAR_Error')) {
            $this->markTestSkipped('PEAR_Error is missing!');
        }
    }
}
