<?php

declare(strict_types=1);

namespace Horde\Exception;

trait DetailsTrait
{
    protected string $extraDetails = '';
    /**
     * Get additional details separated from the exception's message
     */
    public function getDetails(): string
    {
        // Legacy support: Prefer the public $details variable if it exists
        if (property_exists($this, 'details')) {
            return $this->details;
        }
        return $this->extraDetails;
    }

    /**
     * Set additional details separated from the exception's message
     */
    public function setDetails(string $details): void
    {
        // Legacy support: Prefer the public $details variable if it exists
        if (property_exists($this, 'details')) {
            $this->details = $details;
        }
        $this->extraDetails = $details;
    }
}
