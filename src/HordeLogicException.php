<?php

declare(strict_types=1);

/**
 * Copyright 2008-2026 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Ralf Lang <ralf.lang@ralf-lang.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package  Exception
 */

namespace Horde\Exception;

use LogicException;

/**
 * Horde logic exception class.
 *
 * This class extends PHP's built-in LogicException while implementing Horde's exception interfaces.
 *
 * Use this for exceptions that represent errors in the program logic that should be
 * detected and fixed during development. These errors typically indicate programmer mistakes
 * rather than runtime conditions.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from LogicException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <ralf.lang@ralf-lang.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeLogicException extends LogicException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
