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
 * This is the slightly more strict common ancestor of unnamespaced Horde exceptions.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * New exceptions should NOT inherit from this.
 * They should rather inherit from \Exception or another suitable builtin and implement at least HordeThrowable
 * and possibly add functionality or context through interfaces and accompanying traits.
 *
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @copyright 2008-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeException extends Exception implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
    /**
     * Error details that should not be part of the main exception message,
     * e.g. any additional debugging information.
     *
     * @deprecated 3.0.0 use setDetails() and getDetails() instead.
     *
     * @var string
     */
    public string $details;

    /**
     * Has this exception been logged?
     * @deprecated 3.0.0 Use isLogged() and markAsLogged() instead.
     *
     * @var bool
     */
    public bool $logged = false;
}
