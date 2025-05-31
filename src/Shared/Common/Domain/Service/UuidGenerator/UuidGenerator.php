<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\Service\UuidGenerator;

interface UuidGenerator
{
    public function generate(): string;
} 