<?php
/**
 * Copyright 2009-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Exception
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @author   Ralf Lang <lang@b1-systems.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */
namespace Horde\Exception\Test;
use \PHPUnit\Framework\TestCase;
use \Horde\Exception\HordeException;
use \Horde\Exception\NotFound;
use \Horde\Exception\PermissionDenied;
use \Horde\Exception\LastError;
use \Horde\Exception\PearError;
use \Horde_Exception_Stub_PearError;
use \Horde\Exception\Wrapped;
use \Horde\Exception\Pear;
use \PEAR_Error;
use \Exception;
/**
 * Tests for the Horde\Exception\ namespaced classes.
 *
 * @category Horde
 * @package  Exception
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */
class ExceptionTest extends TestCase
{

    // Basic Exception Testing

    public function testEmptyConstructionYieldsEmptyMessage()
    {
        $e = new HordeException();
        $this->assertSame('', $e->getMessage());
    }

    public function testEmptyConstructionYieldsCodeZero()
    {
        $e = new HordeException();
        $this->assertSame(0, $e->getCode());
    }

    public function testMethodGetpreviousYieldsPreviousException()
    {
        $e = new HordeException(null, null, new Exception('previous'));
        $this->assertEquals('previous', $e->getPrevious()->getMessage());
    }

    public function testMethodTostringYieldsExceptionDescription()
    {
        $e = new HordeException();
        $this->assertStringContainsString('Horde\Exception\HordeException', (string)$e);
    }

    /**
     * This test runs against a method of the original PHP \Exception.
     * Why do we test it here?
     */
    public function testMethodTostringContainsDescriptionOfPreviousException()
    {
        $e = new HordeException(null, null, new Exception('previous'));
        $this->assertStringContainsString('Next Horde\Exception\HordeException', (string)$e);
        $this->assertMatchesRegularExpression('/Exception: previous/', (string)$e);
    }

    // NotFound Exception Testing

    public function testEmptyConstructionYieldsNotFoundMessage()
    {
        setlocale(LC_MESSAGES, 'C');
        $e = new NotFound();
        $this->assertSame('Not Found', $e->getMessage());
    }

    // Basic Exception Testing

    public function testEmptyConstructionYieldsPermissionDeniedMessage()
    {
        setlocale(LC_MESSAGES, 'C');
        $e = new PermissionDenied();
        $this->assertSame('Permission Denied', $e->getMessage());
    }

    // Prior Exception Testing

    public function testConstructionWithPearErrorYieldsMessageFromPearError()
    {
        require_once __DIR__ . '/Stub/PearError.php';
        $p = new Horde_Exception_Stub_PearError('pear');
        $e = new Wrapped($p);
        $this->assertSame('pear', $e->getMessage());
    }

    public function testConstructionWithPearErrorYieldsCodeFromPearError()
    {
        require_once __DIR__ . '/Stub/PearError.php';
        $p = new Horde_Exception_Stub_PearError('pear', 666);
        $e = new Wrapped($p);
        $this->assertSame(666, $e->getCode());
    }

    // LastError Exception Testing

    public function testConstructionOfLastErrorYieldsStandardException()
    {
        $e = new LastError();
        $this->assertSame('', $e->getMessage());
    }

    public function testConstructionWithGetlasterrorarrayYieldsMessageFromArray()
    {
        $e = new LastError(null, $this->_getLastError());
        $this->assertSame('get_last_error', $e->getMessage());
    }

    public function testConstructionWithGetlasterrorarrayYieldsCodeFromArray()
    {
        $e = new LastError(null, $this->_getLastError());
        $this->assertSame(666, $e->getCode());
    }

    public function testConstructionWithGetlasterrorarrayYieldsFileFromArray()
    {
        $e = new LastError(null, $this->_getLastError());
        $this->assertSame('/some/file.php', $e->getFile());
    }

    public function testConstructionWithGetlasterrorarrayYieldsLineFromArray()
    {
        $e = new LastError(null, $this->_getLastError());
        $this->assertSame(99, $e->getLine());
    }

    public function testConstructionWithGetlasterrorarrayConcatenatesMessagesFromConstructorAndErrorarray()
    {
        $e = new LastError('An error occurred: ', $this->_getLastError());
        $this->assertSame('An error occurred: get_last_error', $e->getMessage());
    }

    public function testCatchingAndConvertingPearErrors()
    {
        $this->_loadPear();
        try {
            Pear::catchError(new PEAR_Error('An error occurred.'));
        } catch (Pear $e) {
           $this->assertStringContainsString(
                'Horde\Exception\Test\ExceptionTest->testCatchingAndConvertingPearErrors',
                $e->details
            );
        }
    }

    public function testStringUserinfo()
    {
        $this->_loadPear();
        try {
            Pear::catchError(
                new PEAR_Error('An error occurred.', null, null, null, 'userinfo')
            );
        } catch (Pear $e) {
            $this->assertStringContainsString('userinfo', $e->details);
        }
    }

    public function testArrayUserinfo()
    {
        $this->_loadPear();
        try {
            Pear::catchError(
                new PEAR_Error('An error occurred.', null, null, null, array('userinfo'))
            );
        } catch (Pear $e) {
            $this->assertStringContainsString('[0] => userinfo', $e->details);
        }
    }

    private function _getLastError()
    {
        return array(
            'message' => 'get_last_error',
            'type'    => 666,
            'file'    => '/some/file.php',
            'line'    => 99
        );
    }

    private function _loadPear()
    {
        @include_once 'PEAR.php';
        if (!class_exists('PEAR_Error')) {
            $this->markTestSkipped('PEAR_Error is missing!');
        }
    }
}
