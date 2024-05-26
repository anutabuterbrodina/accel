<?php

namespace App\Core\Component\Request\Domain\Request;

use App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use App\Core\SharedKernel\Common\ValueObject\FileObject;
use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Core\SharedKernel\Component\Auth\UserId;
use App\Core\SharedKernel\Component\Project\ProjectId;
use App\Core\SharedKernel\Component\Request\AbstractRequest;
use App\Core\SharedKernel\Component\Request\RejectReasonsEnum;
use App\Core\SharedKernel\Component\Request\RequestId;
use App\Core\SharedKernel\Component\Request\StatusesEnum;
use App\Core\SharedKernel\Component\Request\TypesEnum;
use DateTimeImmutable;

class CreateProjectRequest extends AbstractRequest
{
    /** @param Tag[] $projectTags */
    public function __construct(
                         RequestId           $id,
                         TypesEnum           $type,
                         StatusesEnum        $status,
                         DateTimeImmutable   $createdAt,
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
            $createdAt,
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
            new DateTimeImmutable(),
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

    public function accept(): void
    {
        $this->targetEntityId = new ProjectId();
        parent::accept();
    }

    public function getContent(): array
    {
        return [
            "id" => $this->targetEntityId,
            "userId" => $this->creator,
            "name" => $this->projectName,
            "description" => $this->projectDescription,
            "businessPlan" => $this->projectBusinessPlan,
            "requiredInvestmentMin" => $this->projectRequiredInvestmentMin,
            "requiredInvestmentMax" => $this->projectRequiredInvestmentMax,
            "tags" => $this->projectTags,
        ];
    }

    /** Приватные методы */
}
