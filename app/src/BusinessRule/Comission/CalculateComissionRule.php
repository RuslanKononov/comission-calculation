<?php

declare(strict_types=1);

namespace App\BusinessRule\Comission;

use App\Domain\Comission\CalculateComissionRequest;
use App\Domain\Comission\CalculateComissionResponse;

class CalculateComissionRule
{
    public function __construct(
        private CalculatorInterface $calculator,
    ) {}

    public function execute(CalculateComissionRequest $request): CalculateComissionResponse
    {
        $comission = $this->calculator->calculate($request->getTransactionDTO());

        return new CalculateComissionResponse($comission);
    }
}
