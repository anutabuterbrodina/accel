<?php

namespace Accel\App\Core\Component\Investor\Application\DTO;

use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;

class UpdateInvestorDescriptionDataDTO
{
    public function __construct(
        private readonly InvestorId $id,
        private readonly string     $name,
        private readonly string     $description,
    ) {}

    public function getId(): InvestorId {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }
}
