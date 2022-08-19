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
 * Horde exception class that can wrap and set its details from PEAR_Error,
 * Exception, and other objects with similar interfaces.
 *
 * Consider: PEAR_Error is ancient and any modern PHP supports the 3rd argument.
 *
 * Try using HordeException and pass previous exception as 3rd Argument.
 *
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @copyright 2008-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @package   Exception
 */
class Wrapped extends HordeException
{
    /**
     * Exception constructor.
     *
     * @param string|Pear_Error|Throwable $message The exception message,
     *                       a PEAR_Error object, or an Exception object.
     *                       The Exception case is deprecated
     * @param int   $code    A numeric error code.
     *
     * @param Throwable $previous   A previous Throwable
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        if ($message == '' && $previous instanceof Throwable) {
            $message = $previous->getMessage();
            $code = $previous->getCode();
        }
        if (is_object($message)) {
            if (method_exists($message, 'getMessage')) {
                if (empty($code) &&
                    method_exists($message, 'getCode')) {
                    $code = (int)$message->getCode();
                }
                if ($message instanceof Throwable) {
                    $previous = $message;
                }
                if (method_exists($message, 'getUserinfo') &&
                    $details = $message->getUserinfo()) {
                    $this->details = $details;
                } elseif (!empty($message->details)) {
                    $this->details = $message->details;
                }
                $message = (string)$message->getMessage();
            } elseif (method_exists($message, '__toString')) {
                // TODO: When PHP 8 is minimum, check for Stringable instead
                $message = (string) $message;
            } else {
                $message = get_class($message);
            }
        }
        parent::__construct($message, $code, $previous);
    }
}
