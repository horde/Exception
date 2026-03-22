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

use DomainException;

/**
 * Horde domain exception class.
 *
 * This class extends PHP's built-in DomainException while implementing Horde's exception interfaces.
 *
 * Use this when a value does not adhere to a defined valid data domain or set of acceptable values.
 * This is more specific than InvalidArgumentException and indicates the value is semantically invalid
 * for the business domain (e.g., invalid status, unsupported operation type, value not in allowed set).
 *
 * New namespaced code should NOT type hint against this exception but rather against HordeThrowable.
 * For domain-specific exceptions, inherit from DomainException and implement HordeThrowable directly.
 *
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2008-2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
class HordeDomainException extends DomainException implements HordeThrowable, LogThrowable
{
    use DetailsTrait;
    use LogTrait;
}
