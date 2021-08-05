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
/**
 * Exception thrown if an object wasn't found.
 *
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @copyright 2008-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @package   Exception
 */
class NotFound extends HordeException
{
    /**
     * Constructor.
     *
     * @see Horde_Exception::__construct()
     *
     * @param mixed $message           The exception message, a PEAR_Error
     *                                 object, or an Exception object.
     * @param integer $code            A numeric error code.
     */
    public function __construct($message = null, $code = null)
    {
        if (is_null($message)) {
            $message = Translation::t("Not Found");
        }
        parent::__construct($message, $code);
    }
}