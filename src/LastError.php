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

/**
 * Horde exception class that accepts output of error_get_last() as $code and
 * mask itself as that error.
 *
 * This class is strictly for straight conversion of legacy code, maintaining a similar
 * type hierarchy as the unnamespaced exceptions.
 *
 * An alternative implementation using a more well-defined static method should NOT use a custom constructor.
 *
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @copyright 2008-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @package   Exception
 */
class LastError extends HordeException
{
    /**
     * Exception constructor
     *
     * If $lasterror is passed the return value of error_get_last() (or a
     * matching format), the exception will be rewritten to have its file and
     * line parameters match that of the array, and any message in the array
     * will be appended to $message.
     *
     * @param string|Exception|null $message             The exception message, a PEAR_Error
     *                                   object, or an Exception object.
     * @param array{type: int, file: string, line: int, message: string}|int|null $code_or_lasterror   Either a numeric error code, or
     *                                   an array from error_get_last().
     */
    public function __construct($message = null, $code_or_lasterror = null)
    {
        // Guarantee message is a string and previous an exception or null
        if ($message instanceof Exception) {
            $previous = $message;
            $message = $message->getMessage();
        } else {
            $previous = null;
            $message ??= '';
        }

        if (is_array($code_or_lasterror)) {
            $message .= $code_or_lasterror['message'];
            parent::__construct($message, $code_or_lasterror['type'], $previous);
            $this->file = $code_or_lasterror['file'];
            $this->line = $code_or_lasterror['line'];
        } else {
            parent::__construct($message, $code_or_lasterror ?? 0, $previous);
        }
    }
}
