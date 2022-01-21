<?php

declare(strict_types=1);

namespace App\BusinessRule\Comission;

use App\DTO\Comission\TransactionDTO;

interface CalculatorInterface
{
    public function calculate(TransactionDTO $transactionDTO): float;
}
