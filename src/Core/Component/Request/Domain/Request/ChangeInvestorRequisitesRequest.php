<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class ChangeInvestorRequisitesRequest extends AbstractRequest
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
        InvestorId          $investorId,
        private readonly ChangeInvestorRequisitesRequestContent $content,
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
            $investorId,
        );
    }


    /** Фабричный метод */

    public static function create(
        InvestorId $investorId,
        UserId     $creator,
        string     $creatorComment,
        string     $investorType,
        Requisites $investorRequisites,
    ): self {
        return new self(
            new RequestId(),
            TypesEnum::ChangeInvestorRequisites,
            StatusesEnum::OnModeration,
            $creator,
            $creatorComment,
            null,
            null,
            null,
            $investorId,
            new ChangeInvestorRequisitesRequestContent(
                $investorId,
                $creator,
                $investorType,
                $investorRequisites,
            )
        );
    }


    /** Публичные методы */


    /** Приватные методы */


    /** Immutable getters */

    public function getContent(): ChangeInvestorRequisitesRequestContent {
        return $this->content;
    }
}