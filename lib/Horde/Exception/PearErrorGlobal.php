<?php
/**
 * PEAR_Error compatibility class for legacy code.
 *
 * This file provides a global PEAR_Error class that aliases to
 * Horde\Exception\PearError for backwards compatibility.
 *
 * Copyright 2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package  Exception
 * @deprecated Use native PHP Exceptions instead
 */

// Ensure Horde\Exception\PearError is loaded
if (!class_exists('Horde\Exception\PearError')) {
    require_once __DIR__ . '/../../../src/PearError.php';
}

/**
 * Global PEAR_Error class for backwards compatibility.
 *
 * This class extends Horde\Exception\PearError to provide a global
 * PEAR_Error class that legacy code expects.
 *
 * @deprecated Use native PHP Exceptions instead
 */
class PEAR_Error extends Horde\Exception\PearError
{
    /**
     * Legacy constructor name for PHP 4 compatibility.
     *
     * @param string $message  Error message
     * @param int|string $code Error code
     * @param int $mode        Error mode (ignored)
     * @param mixed $options   Error options (ignored)
     * @param string|array $userinfo Additional info
     *
     * @deprecated
     */
    public function PEAR_Error(
        $message = 'unknown error',
        $code = null,
        $mode = null,
        $options = null,
        $userinfo = null
    ) {
        $this->__construct($message, $code, $mode, $options, $userinfo);
    }
}
