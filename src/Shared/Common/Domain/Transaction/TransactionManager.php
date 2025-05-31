<?php

namespace Src\Shared\Common\Domain\Transaction;

interface TransactionManager
{
    public function execute(callable $callback): mixed;
}
