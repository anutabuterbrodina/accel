<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class ChangeProjectBusinessDataRequest extends AbstractRequest
{
    public function __construct(
        RequestId           $id,
        TypesEnum           $type,
        StatusesEnum        $status,
        UserId              $creator,
        string              $creatorComment,
        ?UserId             $moderator,
        ?RejectReasonsEnum  $rejectReason,
        ?string             $rejectMessage,
        ProjectId           $projectId,
        private readonly ChangeProjectBusinessDataRequestContent $content
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
        ProjectId           $projectId,
        UserId              $creator,
        string              $creatorComment,
        FileObject          $projectBusinessPlan,
        InvestmentRangeEnum $projectRequiredInvestmentMin,
        InvestmentRangeEnum $projectRequiredInvestmentMax,
        array               $projectTags,
    ): self {
        if ($projectRequiredInvestmentMax->value < $projectRequiredInvestmentMin) {
            throw new \Exception('Некорректный диапазон требуемых инвестиций. Минимальное значение должно быть меньше максимального');
        }

        return new self(
            new RequestId(),
            TypesEnum::RegisterProject,
            StatusesEnum::OnModeration,
            $creator,
            $creatorComment,
            null,
            null,
            null,
            $projectId,
            new ChangeProjectBusinessDataRequestContent(
                $projectId,
                $creator,
                $projectBusinessPlan,
                $projectRequiredInvestmentMin,
                $projectRequiredInvestmentMax,
                $projectTags,
            ),
        );
    }


    /** Публичные методы */


    /** Приватные методы */


    /** Immutable getters */

    public function getContent(): ChangeProjectBusinessDataRequestContent {
        return $this->content;
    }
}