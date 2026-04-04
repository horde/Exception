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

use RuntimeException;

/**
 * Horde runtime exception class.
 *
 * This class extends PHP's built-in RuntimeException while implementing Horde's exception interfaces.
 *
 * Use this for exceptions that represent errors that can only be found at runtime,
 * such as invalid configuration, failed operations, or unexpected state.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from RuntimeException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <ralf.lang@ralf-lang.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeRuntimeException extends RuntimeException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
