<?php
/**
 * Copyright 2008-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Jan Schneider <jan@horde.org>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package  Exception
 */

namespace Horde\Exception;

use Exception;
use PEAR_Error;
use Throwable;

/**
 * Exception thrown if any access without sufficient permissions occured.
 *
 * Consuming code should check against the PermissionDeniedThrowable, not this class
 *
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @copyright 2008-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @package   Exception
 */
class PermissionDenied extends HordeException implements PermissionDeniedThrowable
{
    /**
     * Constructor.
     *
     * @see Horde_Exception::__construct()
     *
     * @param string|PEAR_Error|Exception $message           The exception message, a PEAR_Error
     *                                 object, or an Exception object.
     * @param integer $code            A numeric error code.
     * @param Throwable $previous   A previous Throwable
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        if ($message === '') {
            $message = Translation::t("Permission Denied");
        }
        if ($message instanceof Exception) {
        }
        parent::__construct($message, $code, $previous);
    }
}
