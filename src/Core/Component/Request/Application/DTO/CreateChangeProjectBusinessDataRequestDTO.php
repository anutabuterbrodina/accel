<?php

namespace Accel\App\Core\Component\Request\Application\DTO;

use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class CreateChangeProjectBusinessDataRequestDTO
{
    /** @param Tag[] $projectTags */
    public function __construct(
        private readonly ProjectId           $projectId,
        private readonly UserId              $creator,
        private readonly string              $creatorComment,
        private readonly FileObject          $projectBusinessPlan,
        private readonly InvestmentRangeEnum $projectRequiredInvestmentMin,
        private readonly InvestmentRangeEnum $projectRequiredInvestmentMax,
        private readonly array               $projectTags,
    ) {}

    public function getProjectId(): ProjectId {
        return $this->projectId;
    }

    public function getCreator(): UserId {
        return $this->creator;
    }

    public function getCreatorComment(): string {
        return $this->creatorComment;
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

    /** @return  Tag[] */
    public function getProjectTags(): array {
        return $this->projectTags;
    }
}
