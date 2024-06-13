<?php

namespace Accel\App\Core\Component\Request\Application\DTO;

use Accel\App\Core\Component\Request\Domain\Request\RegisterInvestorRequestContent;
use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class CreateChangeInvestorRequisitesRequestDTO
{
    public function __construct(
        private readonly InvestorId $investorId,
        private readonly UserId     $creator,
        private readonly string     $investorType,
        private readonly string     $creatorComment,
        private readonly Requisites $investorRequisites
    ) {}

    public function getInvestorId(): InvestorId {
        return $this->investorId;
    }

    public function getCreator(): UserId {
        return $this->creator;
    }

    public function getInvestorType(): string {
        return $this->investorType;
    }

    public function getCreatorComment(): string {
        return $this->creatorComment;
    }

    public function getInvestorRequisites(): Requisites {
        return $this->investorRequisites;
    }
}
