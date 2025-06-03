<?php

declare(strict_types=1);

namespace Src\Shared\Common\Infrastructure\Transaction;

use Illuminate\Support\Facades\DB;
use Src\Shared\Common\Domain\Transaction\TransactionManager;

/**
 * Laravel Transaction Manager.
 *
 * This class implements the TransactionManager interface using Laravel's
 * database transaction functionality. It provides a way to execute
 * database operations within a transaction.
 */
class LaravelTransactionManager implements TransactionManager
{
    /**
     * Executes a callback within a database transaction.
     *
     * @param callable $callback The callback to execute within the transaction
     * @return mixed The result of the callback execution
     */
    public function execute(callable $callback): mixed
    {
        return DB::transaction($callback);
    }
}
