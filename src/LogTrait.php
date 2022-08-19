<?php

declare(strict_types=1);

namespace Horde\Exception;

trait LogTrait
{
    /**
     * @var bool
     */
    private bool $isLogged = false;

    /**
     * The log level to use. A Horde_Log constant.
     * Name and protected status for legacy reasons. Should rather be private.
     *
     * @var int
     */
    protected int $_logLevel = 0;

    /**
     * Get the log level.
     *
     * @return int  The Horde_Log constant for the log level.
     */
    final public function getLogLevel(): int
    {
        return $this->_logLevel;
    }

    /**
     * Sets the log level.
     *
     * @param int|string $level  The log level.
     */
    final public function setLogLevel($level = 0): void
    {
        if (is_string($level)) {
            /** @var int */
            $level = defined('Horde_Log::' . $level)
                ? constant('Horde_Log::' . $level)
                : 0;
        }

        $this->_logLevel = $level;
    }

    /**
     * Mark this exception as already logged. This cannot be undone.
     *
     * @return void
     */
    final public function markAsLogged(): void
    {
        // Legacy support: Prefer the public $logged variable if it exists
        if (property_exists($this, 'logged')) {
            $this->logged = true;
        }
        $this->isLogged = true;
    }

    /**
     * Check if this exception has been logged.
     *
     * @return bool
     */
    final public function isLogged(): bool
    {
        // Legacy support: Prefer the public $logged variable if it exists
        if (property_exists($this, 'logged')) {
            return $this->logged;
        }
        return $this->isLogged;
    }
}
