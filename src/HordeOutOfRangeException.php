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

use OutOfRangeException;

/**
 * Horde out of range exception class.
 *
 * This class extends PHP's built-in OutOfRangeException while implementing Horde's exception interfaces.
 *
 * Use this for logic errors when a calculated or provided index is out of the valid range.
 * This indicates a programmer error (the index calculation is wrong), not a data-dependent error.
 * This is the logic error counterpart to OutOfBoundsException.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from OutOfRangeException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeOutOfRangeException extends OutOfRangeException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
