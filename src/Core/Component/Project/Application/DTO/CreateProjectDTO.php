<?php

namespace App\Core\Component\Project\Application\DTO;

use App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use App\Core\SharedKernel\Common\ValueObject\FileObject;
use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Core\SharedKernel\Component\Auth\UserId;

class CreateProjectDTO
{
    /** @param Tag[] $tags */
    public function __construct(
        private readonly UserId              $userId,
        private readonly string              $name,
        private readonly string              $description,
        private readonly FileObject          $businessPlan,
        private readonly InvestmentRangeEnum $requiredInvestmentMin,
        private readonly InvestmentRangeEnum $requiredInvestmentMax,
        private readonly array               $tags,
    ) {}

    public function getUserId(): UserId {
        return $this->userId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getBusinessPlan(): FileObject {
        return $this->businessPlan;
    }

    public function getRequiredInvestmentMin(): InvestmentRangeEnum {
        return $this->requiredInvestmentMin;
    }

    public function getRequiredInvestmentMax(): InvestmentRangeEnum {
        return $this->requiredInvestmentMax;
    }

    /** @return Tag[] */
    public function getTags(): array {
        return $this->tags;
    }

}
