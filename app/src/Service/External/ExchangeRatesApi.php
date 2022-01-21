<?php

declare(strict_types=1);

namespace App\Service\External;

class ExchangeRatesApi
{
    public function __construct(
        private string $accessKey,
        private bool $isHttps,
    ) {}

    public function getExchangeRate(string $currency): float
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL,
                    sprintf('%1$s://api.exchangeratesapi.io/latest?access_key=%2$s',
                        $this->isHttps ? 'https' : 'http',
                        $this->accessKey)
        );

        $rates = curl_exec($ch);
        curl_close($ch);

        return json_decode($rates)->rates->{$currency};
    }
}
