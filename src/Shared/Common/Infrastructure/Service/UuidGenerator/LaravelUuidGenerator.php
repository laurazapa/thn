<?php

declare(strict_types=1);

namespace Src\Shared\Common\Infrastructure\Service\UuidGenerator;

use Illuminate\Support\Str;
use Src\Shared\Common\Domain\Service\UuidGenerator\UuidGenerator;

class LaravelUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Str::uuid()->toString();
    }
} 