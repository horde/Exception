<?php

/**
 * PEAR compatibility class for legacy code.
 *
 * Loaded automatically via PSR-0 when code references the global PEAR class.
 *
 * Copyright 2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Ralf Lang <ralf.lang@ralf-lang.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL-2.1
 * @package  Exception
 * @deprecated Use native PHP Exceptions instead
 */

/**
 * Global PEAR class for backwards compatibility.
 *
 * Extends Horde\Exception\PEAR which will be autoloaded by PSR-4.
 */
class PEAR extends Horde\Exception\PEAR {}
