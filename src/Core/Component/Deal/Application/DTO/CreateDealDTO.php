<?php

namespace App\Core\Component\Deal\Application\DTO;

use App\Core\SharedKernel\Component\Auth\UserId;
use App\Core\SharedKernel\Component\Investor\InvestorId;
use App\Core\SharedKernel\Component\Project\ProjectId;

class CreateDealDTO
{
    public function __construct(
        private readonly UserId                 $responsible,
        private readonly ProjectId | InvestorId $target,
    ) {}

    public function getResponsible(): UserId {
        return $this->responsible;
    }

    public function getTarget(): InvestorId | ProjectId {
        return $this->target;
    }
}
