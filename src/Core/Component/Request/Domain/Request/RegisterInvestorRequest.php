<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;

class RegisterInvestorRequest extends AbstractRequest
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
        ?InvestorId         $investorId,
        private readonly RegisterInvestorRequestContent $content,
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

    /** @param Tag[] $investorInterest */
    public static function create(
        UserId     $creator,
        string     $creatorComment,
        string     $investorType,
        string     $investorName,
        string     $investorDescription,
        Requisites $investorRequisites,
        array      $investorInterest,
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
            new RegisterInvestorRequestContent(
                null,
                $creator,
                $investorType,
                $investorName,
                $investorDescription,
                $investorRequisites,
                $investorInterest,
            )
        );
    }


    /** Публичные методы */

    public function accept(UserId $moderator): void {
        $investorId = new InvestorId();
        $this->targetEntityId = $investorId;
        $this->setInvestorId($investorId);

        parent::accept($moderator);
    }


    /** Приватные методы */


    /** Immutable getters */

    public function getContent(): RegisterInvestorRequestContent {
        return $this->content;
    }

    public function setInvestorId(InvestorId $investorId): void {
        $this->content->setInvestorId($investorId);
    }
}
