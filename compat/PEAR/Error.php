<?php
/**
 * PEAR_Error compatibility class for legacy code.
 *
 * Loaded automatically via PSR-0 when code references the global PEAR_Error class.
 *
 * Copyright 2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package  Exception
 * @deprecated Use native PHP Exceptions instead
 */

/**
 * Global PEAR_Error class for backwards compatibility.
 *
 * Extends Horde\Exception\PearError which will be autoloaded by PSR-4.
 */
class PEAR_Error extends Horde\Exception\PearError
{
}
