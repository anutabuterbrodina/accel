<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class ChangeInvestorRequisitesRequestContent implements RequestContentInterface, \JsonSerializable
{
    public function __construct(
        private readonly InvestorId  $investorId,
        private readonly UserId      $investorCreator,
        private readonly string      $investorType,
        private readonly Requisites  $investorRequisites,
    ) {}

    public function getInvestorId(): ?InvestorId {
        return $this->investorId;
    }

    public function getInvestorCreator(): UserId {
        return $this->investorCreator;
    }

    public function getInvestorType(): string {
        return $this->investorType;
    }

    public function getInvestorRequisites(): Requisites {
        return $this->investorRequisites;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getInvestorId(),
            "type" => $this->getInvestorType(),
            "requisites" => $this->getInvestorRequisites(),
        ];
    }
}