<?php

namespace Accel\App\Core\Component\Deal\Application\DTO;

use Accel\App\Core\Component\Deal\Domain\Deal\DealId;

class UpdateDealConditionsDTO
{
    public function __construct(
        private readonly DealId $id,
        private readonly int    $investment,
    ) {}

    public function getId(): DealId
    {
        return $this->id;
    }

    public function getInvestment(): int {
        return $this->investment;
    }
}
