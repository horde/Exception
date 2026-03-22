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

use BadMethodCallException;

/**
 * Horde bad method call exception class.
 *
 * This class extends PHP's built-in BadMethodCallException while implementing Horde's exception interfaces.
 *
 * Use this when a method is called in an invalid context, invalid state, or without proper setup.
 * Common scenarios include: calling methods out of order (e.g., send() before prepare()),
 * calling methods in the wrong object state, or invoking undefined magic methods.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from BadMethodCallException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeBadMethodCallException extends BadMethodCallException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
