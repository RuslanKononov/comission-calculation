<?php

namespace App\Tests;

use App\DTO\Comission\TransactionDTO;
use App\Service\Comission\Calculator;
use App\Service\External\Binlist;
use App\Service\External\ExchangeRatesApi;
use Mockery;

class CalculatorCest
{
    public function calculatorUsdTest(UnitTester $I): void
    {
        $transactionDTO = new TransactionDTO(41417360, 130.00, 'USD');

        $binlist = Mockery::mock(new Binlist());
        $binlist->shouldReceive('getFactorByBin')
            ->once()
            ->with(41417360)
            ->andReturn(0.01);

        $exchangeRatesApi = Mockery::mock(new ExchangeRatesApi('access_key', false));
        $exchangeRatesApi->shouldReceive('getExchangeRate')
            ->once()
            ->with('USD')
            ->andReturn(1.135);

        $calculator = new Calculator($binlist, $exchangeRatesApi);

        $result = $calculator->calculate($transactionDTO);

        $I->assertIsFloat($result);
        $I->assertEquals(1.15, $result);
    }

    public function calculatorEurTest(UnitTester $I): void
    {
        $transactionDTO = new TransactionDTO(123, 100.00, 'EUR');

        $binlist = Mockery::mock(new Binlist());
        $binlist->shouldReceive('getFactorByBin')
            ->once()
            ->with(123)
            ->andReturn(0.01);

        $exchangeRatesApi = Mockery::mock(new ExchangeRatesApi('access_key', false));
        $exchangeRatesApi->shouldReceive('getExchangeRate')
            ->once()
            ->with('EUR')
            ->andReturn(1);

        $calculator = new Calculator($binlist, $exchangeRatesApi);

        $result = $calculator->calculate($transactionDTO);

        $I->assertIsFloat($result);
        $I->assertEquals(1, $result);
    }

    public function calculatorNoEuCurrencyTest(UnitTester $I): void
    {
        $transactionDTO = new TransactionDTO(123, 1000.00, 'UAH');

        $binlist = Mockery::mock(new Binlist());
        $binlist->shouldReceive('getFactorByBin')
            ->once()
            ->with(123)
            ->andReturn(0.02);

        $exchangeRatesApi = Mockery::mock(new ExchangeRatesApi('access_key', false));
        $exchangeRatesApi->shouldReceive('getExchangeRate')
            ->once()
            ->with('UAH')
            ->andReturn(32);

        $calculator = new Calculator($binlist, $exchangeRatesApi);

        $result = $calculator->calculate($transactionDTO);

        $I->assertIsFloat($result);
        $I->assertEquals(0.63, $result);
    }
}
