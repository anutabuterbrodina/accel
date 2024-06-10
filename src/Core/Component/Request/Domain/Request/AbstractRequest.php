<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;
use Accel\Extension\Entity\AbstractEntity;

abstract class AbstractRequest extends AbstractEntity implements RequestInterface
{
    public function __construct(
        protected readonly RequestId                     $id,
        protected readonly TypesEnum                     $type,
        protected          StatusesEnum                  $status,
        protected readonly UserId                        $creator,
        protected readonly string                        $creatorComment,
        protected          ?UserId                       $moderator = null,
        protected          ?string                       $rejectMessage = null,
        protected          ?RejectReasonsEnum            $rejectReason = null,
        protected          null | ProjectId | InvestorId $targetEntityId = null,
    ) {}

    abstract public function getContent(): RequestContentInterface;

    abstract public function accept(UserId $moderator): void;

    protected function changeStatus(): void {
        $this->status = StatusesEnum::Accepted;
    }

    public function reject(RejectReasonsEnum $rejectReason, string $rejectMessage): void {
        $this->rejectReason = $rejectReason;
        $this->rejectMessage = $rejectMessage;
        $this->status = StatusesEnum::Rejected;
    }


    /** Иммутабельные геттеры */

    public function getId(): RequestId {
        return $this->id;
    }

    public function getType(): TypesEnum {
        return $this->type;
    }

    public function getStatus(): StatusesEnum {
        return $this->status;
    }

    public function getCreator(): UserId {
        return $this->creator;
    }

    public function getCreatorComment(): string {
        return $this->creatorComment;
    }

    public function getModerator(): ?UserId {
        return $this->moderator;
    }

    public function getRejectMessage(): ?string {
        return $this->rejectMessage;
    }

    public function getRejectReason(): ?RejectReasonsEnum {
        return $this->rejectReason;
    }

    public function getTargetEntityId(): InvestorId | ProjectId | null {
        return $this->targetEntityId;
    }
}
