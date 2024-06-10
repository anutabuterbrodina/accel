<?php

namespace Accel\App\Core\Component\Deal\Domain\Deal;

class Conditions
{
    public function __construct(
        private readonly int $investment,
    ) {}

    public function getInvestment(): int {
        return $this->investment;
    }
}
