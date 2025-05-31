<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\Service\UuidGenerator;

/**
 * UUID Generator Interface.
 * 
 * This interface defines the contract for generating unique identifiers.
 * Implementations should provide a way to generate valid UUIDs.
 */
interface UuidGenerator
{
    /**
     * Generates a new UUID.
     * 
     * @return string A valid UUID string
     */
    public function generate(): string;
} 