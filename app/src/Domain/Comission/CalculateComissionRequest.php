<?php

declare(strict_types=1);

namespace App\Domain\Comission;

use App\DTO\Comission\TransactionDTO;

class CalculateComissionRequest
{
    public function __construct(
        private TransactionDTO $transactionDTO
    ) {}

    public function getTransactionDTO(): TransactionDTO
    {
        return $this->transactionDTO;
    }
}
