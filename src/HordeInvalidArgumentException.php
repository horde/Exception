<?php

declare(strict_types=1);

/**
 * Copyright 2008-2026 The Horde Project (http://www.horde.org/)
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

use InvalidArgumentException;

/**
 * Horde invalid argument exception class.
 *
 * This class extends PHP's built-in InvalidArgumentException while implementing Horde's exception interfaces.
 *
 * Use this when a function or method receives an argument with an invalid type or value.
 * This indicates a programmer error (logic error) that should be prevented by the caller.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from InvalidArgumentException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeInvalidArgumentException extends InvalidArgumentException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
