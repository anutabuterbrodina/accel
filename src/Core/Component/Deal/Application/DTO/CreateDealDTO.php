<?php

namespace Accel\App\Core\Component\Deal\Application\DTO;

use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;

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
