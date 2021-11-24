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
 * Horde base exception class.
 *
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @copyright 2008-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeException extends Exception implements FrameworkException
{
    /**
     * Error details that should not be part of the main exception message,
     * e.g. any additional debugging information.
     *
     * @var string
     */
    public string $details;

    /**
     * Has this exception been logged?
     *
     * @var bool
     */
    public bool $logged = false;

    /**
     * The log level to use. A Horde_Log constant.
     *
     * @var integer
     */
    protected int $_logLevel = 0;

    /**
     * Get the log level.
     *
     * @return integer  The Horde_Log constant for the log level.
     */
    public function getLogLevel(): int
    {
        return $this->_logLevel;
    }

    /**
     * Sets the log level.
     *
     * @param mixed $level  The log level.
     */
    public function setLogLevel($level = 0): void
    {
        if (is_string($level)) {
            $level = defined('Horde_Log::' . $level)
                ? constant('Horde_Log::' . $level)
                : 0;
        }

        $this->_logLevel = $level;
    }
}
