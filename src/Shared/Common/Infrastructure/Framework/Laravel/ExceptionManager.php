<?php

declare(strict_types=1);

namespace Src\Shared\Common\Infrastructure\Framework\Laravel;

use Illuminate\Foundation\Configuration\Exceptions;
use Src\Shared\Common\Domain\Exception\DataNotFoundException;
use Src\Shared\Common\Domain\Exception\ForbiddenRequestException;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Throwable;

class ExceptionManager
{
    public static function execute(Exceptions $exceptions): void
    {
        $exceptions->render(function (DataNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        });

        $exceptions->render(function (InvalidRequestException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        });

        $exceptions->render(function (ForbiddenRequestException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        });

        // Fallback:
        $exceptions->render(function (Throwable $e) {
            return response()->json([
                'message' => 'Unexpected error: ' . $e->getMessage(),
            ], 500);
        });
    }
}
