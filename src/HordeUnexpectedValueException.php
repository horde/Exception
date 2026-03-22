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

use UnexpectedValueException;

/**
 * Horde unexpected value exception class.
 *
 * This class extends PHP's built-in UnexpectedValueException while implementing Horde's exception interfaces.
 *
 * Use this when a value does not match an expected type or set of values, typically from external sources
 * like API responses, file parsing, database results, or user input. Unlike InvalidArgumentException,
 * this is not necessarily the caller's fault but rather a data validation failure.
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from UnexpectedValueException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeUnexpectedValueException extends UnexpectedValueException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
