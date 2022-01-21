<?php

declare(strict_types=1);

namespace App\Service\Comission;

use App\BusinessRule\Comission\CalculatorInterface;
use App\DTO\Comission\TransactionDTO;
use App\Service\External\Binlist;
use App\Service\External\ExchangeRatesApi;

class Calculator implements CalculatorInterface
{
    private const SCALE = 2;

    public function __construct(
        private Binlist $binlist,
        private ExchangeRatesApi $exchangeRatesApi
    ) {}

    public function calculate(TransactionDTO $transactionDTO): float
    {
        $factor = $this->binlist->getFactorByBin($transactionDTO->getBin());
        $rate = $this->exchangeRatesApi->getExchangeRate($transactionDTO->getCurrency());

        $fixedAmount = $rate
            ? bcdiv((string)$transactionDTO->getAmount(), (string)$rate, 16)
            : (string)$transactionDTO->getAmount();

        $absoluteAmount = bcmul($fixedAmount, (string)$factor, 16);

        return (float)$this->roundUp($absoluteAmount);
    }

    private function roundUp(string $number): string
    {
        $mult = bcpow("10", (string)self::SCALE);

        return bcdiv((string)ceil((float)bcmul($number, $mult, 16)), $mult, self::SCALE);
    }
}
