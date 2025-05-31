<?php

declare(strict_types=1);

namespace Src\Shared\Common\Infrastructure\Framework\Laravel;

use Illuminate\Foundation\Configuration\Exceptions;
use Src\Shared\Common\Domain\Exception\DataNotFoundException;
use Src\Shared\Common\Domain\Exception\ForbiddenRequestException;
use Src\Shared\Common\Domain\Exception\InvalidRequestException;
use Throwable;

/**
 * Exception Manager.
 * 
 * This class manages the global exception handling for the application.
 * It maps domain exceptions to appropriate HTTP responses with corresponding status codes.
 * 
 * Exception mappings:
 * - DataNotFoundException -> 404 Not Found
 * - InvalidRequestException -> 400 Bad Request
 * - ForbiddenRequestException -> 403 Forbidden
 * - Any other exception -> 500 Internal Server Error
 */
class ExceptionManager
{
    /**
     * Configures the exception handling for the application.
     * 
     * @param Exceptions $exceptions Laravel's exception configuration
     */
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
