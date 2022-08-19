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

use PEAR_Error;

/**
 * Horde exception class that converts PEAR errors to exceptions.
 *
 * This class is strictly legacy support for schematic conversions.
 * It should NOT be used even for new code that happens to interface with PEAR_Error.
 *
 * Implementation using a custom constructor is dubious.
 * Instead, use a trait that actually unpacks a PEAR_Error into the regular exception constructor.
 *
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @copyright 2008-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @package   Exception
 */
class Pear extends HordeException
{
    /**
     * The class name for generated exceptions.
     *
     * @var string
     */
    protected static $_class = __CLASS__;

    /**
     * Exception constructor.
     *
     * @param PEAR_Error $error The PEAR error.
     */
    public function __construct(PEAR_Error $error)
    {
        parent::__construct($error->getMessage(), $error->getCode());
        $this->details = $this->_getPearTrace($error);
    }

    /**
     * Return a trace for the PEAR error.
     *
     * @param PEAR_Error $error The PEAR error.
     *
     * @return string The backtrace as a string.
     */
    private function _getPearTrace(PEAR_Error $error)
    {
        $pear_error = '';
        $backtrace = $error->getBacktrace();
        if (!empty($backtrace)) {
            $pear_error .= 'PEAR backtrace:' . "\n\n";
            foreach ($backtrace as $frame) {
                $pear_error .=
                      ($frame['class'] ?? '')
                    . ($frame['type'] ?? '')
                    . ($frame['function'] ?? 'unkown') . ' '
                    . ($frame['file'] ?? 'unkown') . ':'
                    . ($frame['line'] ?? 'unkown') . "\n";
            }
        }
        $userinfo = $error->getUserInfo();
        if (!empty($userinfo)) {
            $pear_error .= "\n" . 'PEAR user info:' . "\n\n";
            if (is_string($userinfo)) {
                $pear_error .= $userinfo;
            // PEAR_Error is pretty legacy
            // The phpdoc annotation cannot be fully trusted
            // @phpstan-ignore-next-line
            } else {
                $pear_error .= print_r($userinfo, true);
            }
        }
        return $pear_error;
    }

    /**
     * Exception handling.
     *
     * @param mixed $result The result to be checked for a PEAR_Error.
     *
     * @return mixed Returns the original result if it was no PEAR_Error.
     *
     * @throws Pear In case the result was a PEAR_Error.
     */
    public static function catchError($result)
    {
        if ($result instanceof PEAR_Error) {
            //@phpstan-ignore-next-line
            throw new self::$_class($result);
        }
        return $result;
    }
}
