<?php

declare(strict_types=1);
/**
 * Copyright 2026 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Torben Dannhauer <torben@dannhauer.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package  Exception
 */

namespace Horde\Exception;

/**
 * Marker interface for exceptions caused by invalid caller-supplied data.
 *
 * Thrown by an application when a value it was asked to store or process
 * violates that application's own constraints (field length, format,
 * required field) - as opposed to an infrastructure failure. Consumers
 * such as sync protocol handlers use it to tell "the item is unacceptable,
 * do not retry it" from "the server failed, try again later" without
 * depending on the throwing application's exception classes.
 *
 * Intentionally a noop / marker interface, like PermissionDeniedThrowable.
 *
 * @author    Torben Dannhauer <torben@dannhauer.de>
 * @category  Horde
 * @copyright 2026 The Horde Project
 * @license   http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package   Exception
 */
interface InvalidDataThrowable extends HordeThrowable
{
}
