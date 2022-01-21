<?php

declare(strict_types=1);

namespace App\Domain\Comission;

use App\BusinessRule\Comission\CalculateComissionRule;

class CalculateComission
{
    public function __construct(
        private CalculateComissionRule $calculateComissionRule,
    ) {}

    public function calculate(CalculateComissionRequest $request): CalculateComissionResponse
    {
        return $this->calculateComissionRule->execute($request);
    }
}
