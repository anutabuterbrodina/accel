<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

use Accel\App\Core\SharedKernel\Component\Auth\UserId;

interface RequestInterface
{
    public function accept(UserId $moderator): void;

    public function reject(RejectReasonsEnum $rejectReason, string $rejectMessage): void;

    public function getContent(): RequestContentInterface;
}