<?php

namespace Accel\App\Core\Component\Request\Application\DTO;

use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class CreateRegisterInvestorRequestDTO
{
    /** @param Tag[] $investorInterests */
    public function __construct(
        private readonly UserId     $creator,
        private readonly string     $creatorComment,
        private readonly string     $investorType,
        private readonly string     $investorName,
        private readonly string     $investorDescription,
        private readonly Requisites $investorRequisites,
        private readonly array      $investorInterests,
    ) {}

    public function getCreator(): UserId {
        return $this->creator;
    }

    public function getCreatorComment(): string {
        return $this->creatorComment;
    }

    public function getInvestorType(): string {
        return $this->investorType;
    }

    public function getInvestorName(): string {
        return $this->investorName;
    }

    public function getInvestorDescription(): string {
        return $this->investorDescription;
    }

    public function getInvestorRequisites(): Requisites {
        return $this->investorRequisites;
    }

    /** @return  Tag[] */
    public function getInvestorInterests(): array {
        return $this->investorInterests;
    }
}
