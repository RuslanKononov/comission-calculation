<?php

declare(strict_types=1);

namespace App\Domain\Comission;

class CalculateComissionResponse
{
    public function __construct(
        private float $comission
    ) {}

    public function getComission(): float
    {
        return $this->comission;
    }
}
