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
 * PEAR_Error compatibility shim for legacy code.
 *
 * This is a minimal implementation of PEAR_Error that provides only the
 * methods actually used by Horde code. It exists solely for backwards
 * compatibility with legacy code that still uses PEAR_Error.
 *
 * Original PEAR_Error source:
 * Copyright 1997-2010 The Authors
 * Licensed under BSD-2-Clause
 * https://github.com/pear/PEAR
 *
 * This implementation is simplified and removes deprecated functionality:
 * - No PEAR_ERROR_PRINT, PEAR_ERROR_DIE, PEAR_ERROR_TRIGGER modes
 * - No PEAR_ERROR_CALLBACK support
 * - No error_message_prefix
 * - Simplified backtrace (uses debug_backtrace directly)
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2026 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 * @deprecated This class exists only for backwards compatibility. Use native PHP Exceptions instead.
 */
class PearError
{
    /**
     * Error code
     *
     * @var int|string
     */
    protected $code = -1;

    /**
     * Error message
     *
     * @var string
     */
    protected $message = '';

    /**
     * Additional user/debug information
     *
     * @var string|array
     */
    protected $userinfo = '';

    /**
     * Backtrace from where error was generated
     *
     * @var array|null
     */
    protected $backtrace = null;

    /**
     * Constructor.
     *
     * @param string $message  Error message
     * @param int|string $code Error code (optional)
     * @param int $mode        Error mode (deprecated, ignored)
     * @param mixed $options   Error options (deprecated, ignored)
     * @param string|array $userinfo Additional user/debug info (optional)
     */
    public function __construct(
        $message = 'unknown error',
        $code = null,
        $mode = null,
        $options = null,
        $userinfo = null
    ) {
        $this->message = $message;
        $this->code = $code ?? -1;
        $this->userinfo = $userinfo ?? '';

        // Capture backtrace
        $this->backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        // Remove this constructor from trace
        if (isset($this->backtrace[0])) {
            array_shift($this->backtrace);
        }
    }

    /**
     * Get the error message.
     *
     * @return string Error message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the error code.
     *
     * @return int|string Error code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get additional user-supplied information.
     *
     * @return string|array User-supplied information
     */
    public function getUserInfo()
    {
        return $this->userinfo;
    }

    /**
     * Get additional debug information.
     *
     * Alias for getUserInfo() for compatibility.
     *
     * @return string|array Debug information
     */
    public function getDebugInfo()
    {
        return $this->getUserInfo();
    }

    /**
     * Get the call backtrace from where the error was generated.
     *
     * @param int $frame Optional frame number to fetch
     * @return array|null Backtrace array, or null if not available
     */
    public function getBacktrace($frame = null)
    {
        if ($frame === null) {
            return $this->backtrace;
        }
        return $this->backtrace[$frame] ?? null;
    }

    /**
     * Get the error type/class name.
     *
     * @return string Error type
     */
    public function getType()
    {
        return get_class($this);
    }

    /**
     * String representation of error.
     *
     * @return string Error message
     */
    public function __toString()
    {
        return $this->getMessage();
    }
}
