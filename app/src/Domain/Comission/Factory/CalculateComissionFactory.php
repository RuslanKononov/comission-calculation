<?php

declare(strict_types=1);

namespace App\Domain\Comission\Factory;

use App\Domain\Comission\CalculateComissionRequest;
use App\Domain\Comission\CalculateComissionResponse;
use App\DTO\Comission\TransactionDTO;

class CalculateComissionFactory
{
    public function fromSourceToDomainRequest(string $transaction): CalculateComissionRequest
    {
        $transactionObject = json_decode($transaction);
        $transactionDTO = new TransactionDTO(
            (int)$transactionObject->bin,
            (float)$transactionObject->amount,
            $transactionObject->currency,
        );

        return new CalculateComissionRequest($transactionDTO);
    }

    public function fromDomainToSourceResponse(CalculateComissionResponse $response): float
    {
        return $response->getComission();
    }
}
