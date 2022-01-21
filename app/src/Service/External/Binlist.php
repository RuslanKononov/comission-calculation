<?php

declare(strict_types=1);

namespace App\Service\External;

use Symfony\Component\Config\Definition\Exception\Exception;

class Binlist
{
    private const EU_FACTOR = 0.01;
    private const WORLD_FACTOR = 0.02;

    public function getFactorByBin(int $binNumber): float
    {
        $transactionCountry = $this->getBinCountry($binNumber);

        return $this->getFactorByCountry($transactionCountry);
    }

    /**
     * @api https://binlist.net
     */
    private function getBinCountry(int $binNumber): string
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, sprintf('%1$s%2$s', 'https://lookup.binlist.net/', $binNumber));

        $binResults = curl_exec($ch);
        curl_close($ch);

        if (!$binResults) {
            throw new Exception(sprintf('No data from binlist API about country of card: %d*', $binNumber));
        }
        $binData = json_decode($binResults, false, 512, JSON_THROW_ON_ERROR);

        return $binData->country->alpha2;
    }

    private function getFactorByCountry(string $countryAlpha2): float
    {
        return match ($countryAlpha2) {
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU',
                'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK' => self::EU_FACTOR,
            default => self::WORLD_FACTOR,
        };
    }
}
