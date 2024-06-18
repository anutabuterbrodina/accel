<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class RegisterInvestorRequestContent implements RequestContentInterface, \JsonSerializable
{
    /** @param Tag[] $investorInterests */
    public function __construct(
        private          ?InvestorId $investorId,
        private readonly UserId      $investorCreator,
        private readonly string      $investorType,
        private readonly string      $investorName,
        private readonly string      $investorDescription,
        private readonly Requisites  $investorRequisites,
        private readonly array       $investorInterests,
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

    public function getInvestorName(): string {
        return $this->investorName;
    }

    public function getInvestorDescription(): string {
        return $this->investorDescription;
    }

    public function getInvestorRequisites(): Requisites {
        return $this->investorRequisites;
    }

    /** @return Tag[] */
    public function getInvestorInterests(): array {
        return $this->investorInterests;
    }

    public function setInvestorId(InvestorId $investorId): void {
        $this->investorId = $investorId;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getInvestorId(),
            "name" => $this->getInvestorName(),
            "type" => $this->getInvestorType(),
            "description" => $this->getInvestorDescription(),
            "requisites" => $this->getInvestorRequisites(),
            "tags" => $this->getInvestorInterests(),
        ];
    }
}