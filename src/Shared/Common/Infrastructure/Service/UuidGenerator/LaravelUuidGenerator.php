<?php

declare(strict_types=1);

namespace Src\Shared\Common\Infrastructure\Service\UuidGenerator;

use Illuminate\Support\Str;
use Src\Shared\Common\Domain\Service\UuidGenerator\UuidGenerator;

/**
 * Laravel UUID Generator Implementation.
 * 
 * This class implements the UuidGenerator interface using Laravel's
 * Str facade to generate UUIDs. It provides a concrete implementation
 * for generating unique identifiers.
 */
class LaravelUuidGenerator implements UuidGenerator
{
    /**
     * Generates a new UUID using Laravel's Str facade.
     * 
     * @return string A valid UUID string
     */
    public function generate(): string
    {
        return Str::uuid()->toString();
    }
} 