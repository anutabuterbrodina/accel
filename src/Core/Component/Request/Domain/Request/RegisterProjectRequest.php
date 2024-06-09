<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;

class RegisterProjectRequest extends AbstractRequest
{
    /** @param Tag[] $projectTags */
    public function __construct(
                         RequestId           $id,
                         TypesEnum           $type,
                         StatusesEnum        $status,
                         UserId              $creator,
                         string              $creatorComment,
                         ?UserId             $moderator,
                         ?RejectReasonsEnum  $rejectReason,
                         ?string             $rejectMessage,
                         ?ProjectId          $projectId,
        private readonly string              $projectName,
        private readonly string              $projectDescription,
        private readonly FileObject          $projectBusinessPlan,
        private readonly InvestmentRangeEnum $projectRequiredInvestmentMin,
        private readonly InvestmentRangeEnum $projectRequiredInvestmentMax,
        private readonly array               $projectTags,
    ) {
        parent::__construct(
            $id,
            $type,
            $status,
            $creator,
            $creatorComment,
            $moderator,
            $rejectReason,
            $rejectMessage,
            $projectId,
        );
    }


    /** Фабричный метод */

    /** @param Tag[] $projectTags */
    public static function create(
        UserId              $creator,
        string              $creatorComment,
        string              $projectName,
        string              $projectDescription,
        FileObject          $projectBusinessPlan,
        InvestmentRangeEnum $projectRequiredInvestmentMin,
        InvestmentRangeEnum $projectRequiredInvestmentMax,
        array               $projectTags,
    ): self {
        return new self(
            new RequestId(),
            TypesEnum::RegisterProject,
            StatusesEnum::OnModeration,
            $creator,
            $creatorComment,
            null,
            null,
            null,
            null,
            $projectName,
            $projectDescription,
            $projectBusinessPlan,
            $projectRequiredInvestmentMin,
            $projectRequiredInvestmentMax,
            $projectTags,
        );
    }


    /** Публичные методы */

    public function accept(UserId $moderator): void {
        $this->targetEntityId = new ProjectId();

        $this->moderator = $moderator;
        parent::changeStatus();
    }

    public function getContent(): RegisterProjectRequestContent {
        return new RegisterProjectRequestContent(
            $this->targetEntityId,
            $this->creator,
            $this->projectName,
            $this->projectDescription,
            $this->projectBusinessPlan,
            $this->projectRequiredInvestmentMin,
            $this->projectRequiredInvestmentMax,
            $this->projectTags,
        );
    }

    /** Приватные методы */
}
