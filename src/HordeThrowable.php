<?php

declare(strict_types=1);
/**
 * Copyright 2008-2022 Horde LLC (http://www.horde.org/)
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

use Throwable;

/**
 * The root interface from which all Horde Exceptions must descend
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2008-2022 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
interface HordeThrowable extends Throwable
{
    /**
     * Get additional details separated from the exception's message
     */
    public function getDetails(): string;

    /**
     * Set additional details separated from the exception's message
     */
    public function setDetails(string $details): void;
}
