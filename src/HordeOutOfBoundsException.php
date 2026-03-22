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

use OutOfBoundsException;

/**
 * Horde out of bounds exception class.
 *
 * This class extends PHP's built-in OutOfBoundsException while implementing Horde's exception interfaces.
 *
 * Use this for runtime errors when an illegal index is requested in a collection or array.
 * This is a data-dependent error (the index might be valid with different data), not a programmer error.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from OutOfBoundsException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeOutOfBoundsException extends OutOfBoundsException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
