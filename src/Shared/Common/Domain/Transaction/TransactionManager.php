<?php

declare(strict_types=1);

namespace Src\Shared\Common\Domain\Transaction;

/**
 * Interface for managing database transactions.
 *
 * This interface provides a way to execute operations within a transaction,
 * ensuring that all operations either complete successfully together or
 * are rolled back if any operation fails.
 *
 * The transaction manager is responsible for:
 * - Starting a transaction
 * - Committing the transaction if all operations succeed
 * - Rolling back the transaction if any operation fails
 */
interface TransactionManager
{
    /**
     * Executes the given callback within a transaction.
     *
     * If the callback executes successfully, the transaction is committed.
     * If the callback throws an exception, the transaction is rolled back.
     *
     * @param callable $callback The operation to execute within the transaction
     * @return mixed The result of the callback execution
     */
    public function execute(callable $callback): mixed;
}
