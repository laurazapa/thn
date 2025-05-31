<?php

namespace Src\Shared\Common\Infrastructure\Transaction;

use Illuminate\Support\Facades\DB;
use Src\Shared\Common\Domain\Transaction\TransactionManager;

class LaravelTransactionManager implements TransactionManager
{
    public function execute(callable $callback): mixed
    {
        return DB::transaction($callback); // Laravel will manage commit and rollback of the transaction
    }
}
