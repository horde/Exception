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

use LengthException;

/**
 * Horde length exception class.
 *
 * This class extends PHP's built-in LengthException while implementing Horde's exception interfaces.
 *
 * Use this when a value's length is invalid, such as strings that are too short or too long,
 * or arrays with an invalid number of elements. This is more specific than InvalidArgumentException
 * for length-related validation.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from LengthException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeLengthException extends LengthException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
