<?php

namespace App\Core\SharedKernel\Component\Request;

use App\Core\SharedKernel\Component\Auth\UserId;
use DateTimeImmutable;

abstract class AbstractRequest implements RequestInterface
{
    public function __construct(
        protected readonly RequestId          $id,
        protected readonly TypesEnum          $type,
        protected          StatusesEnum       $status,
        protected readonly DateTimeImmutable  $createdAt,
        protected readonly UserId             $creator,
        protected readonly string             $creatorComment,
        protected readonly ?UserId            $moderator,
        protected          ?string            $rejectMessage,
        protected          ?RejectReasonsEnum $rejectReason,
        protected          mixed              $targetEntityId,
    ) {}

    public function reject(int $rejectReasonCode, string $rejectMessage): void {
        $this->rejectReason = RejectReasonsEnum::from($rejectReasonCode);
        $this->rejectMessage = $rejectMessage;
        $this->status = StatusesEnum::Rejected;
    }

    public function accept(): void {
        $this->status = StatusesEnum::Accepted;
    }

    abstract public function getContent(): array;
}
