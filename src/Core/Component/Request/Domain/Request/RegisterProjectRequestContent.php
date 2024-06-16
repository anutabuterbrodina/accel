<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;

class RegisterProjectRequestContent implements RequestContentInterface, \JsonSerializable
{
    /** @param Tag[] $projectTags */
    public function __construct(
        private          ?ProjectId          $projectId,
        private readonly UserId              $projectCreator,
        private readonly string              $projectName,
        private readonly string              $projectDescription,
        private readonly FileObject          $projectBusinessPlan,
        private readonly InvestmentRangeEnum $projectRequiredInvestmentMin,
        private readonly InvestmentRangeEnum $projectRequiredInvestmentMax,
        private readonly array               $projectTags,
    ) {}

    public function getProjectId(): ?ProjectId {
        return $this->projectId;
    }

    public function getProjectCreator(): UserId {
        return $this->projectCreator;
    }

    public function getProjectName(): string {
        return $this->projectName;
    }

    public function getProjectDescription(): string {
        return $this->projectDescription;
    }

    public function getProjectBusinessPlan(): FileObject {
        return $this->projectBusinessPlan;
    }

    public function getProjectRequiredInvestmentMin(): InvestmentRangeEnum {
        return $this->projectRequiredInvestmentMin;
    }

    public function getProjectRequiredInvestmentMax(): InvestmentRangeEnum {
        return $this->projectRequiredInvestmentMax;
    }

    /** @return Tag[] */
    public function getProjectTags(): array {
        return $this->projectTags;
    }

    public function setProjectId(ProjectId $projectId): void {
        $this->projectId = $projectId;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getProjectId(),
            "name" => $this->getProjectName(),
            "description" => $this->getProjectDescription(),
            "businessPlan" => $this->getProjectBusinessPlan(),
            "investmentMin" => $this->getProjectRequiredInvestmentMin(),
            "investmentMax" => $this->getProjectRequiredInvestmentMax(),
            "tags" => $this->getProjectTags(),
        ];
    }
}