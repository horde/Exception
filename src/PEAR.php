<?php
/**
 * Copyright 2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package  Exception
 */

namespace Horde\Exception;

/**
 * PEAR compatibility shim for legacy code.
 *
 * This provides the static PEAR::raiseError() method that legacy code uses
 * to create PEAR_Error instances.
 *
 * Original PEAR source:
 * Copyright 1997-2010 The Authors
 * Licensed under BSD-2-Clause
 * https://github.com/pear/PEAR
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2026 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 * @deprecated This class exists only for backwards compatibility. Use native PHP Exceptions instead.
 */
class PEAR
{
    /**
     * Raise a PEAR_Error.
     *
     * This method creates and returns a PEAR_Error object. In legacy PEAR,
     * this could also trigger callbacks or die(), but this implementation
     * only returns the error object.
     *
     * @param string|object $message  Error message or object
     * @param int|string $code        Error code (optional)
     * @param int $mode               Error mode (deprecated, ignored)
     * @param mixed $options          Error options (deprecated, ignored)
     * @param string|array $userinfo  Additional user/debug info (optional)
     * @param string $errorClass      Class name for error object (deprecated)
     * @param bool $skipMessage       Skip message (deprecated, ignored)
     *
     * @return PearError  The PEAR_Error object
     */
    public static function raiseError(
        $message = null,
        $code = null,
        $mode = null,
        $options = null,
        $userinfo = null,
        $errorClass = null,
        $skipMessage = false
    ) {
        // If $message is already a PearError, return it
        if ($message instanceof PearError) {
            return $message;
        }

        // Ensure global PEAR_Error class exists (loaded via PSR-0 from compat/)
        if (!class_exists('PEAR_Error', false)) {
            class_exists('PEAR_Error'); // Trigger PSR-0 autoload
        }

        return new \PEAR_Error($message, $code, $mode, $options, $userinfo);
    }

    /**
     * Check if a value is a PEAR_Error.
     *
     * @param mixed $data  Value to check
     *
     * @return bool  True if $data is a PEAR_Error
     */
    public static function isError($data)
    {
        return $data instanceof PearError;
    }
}
