<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class RequestListItemDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    public function __construct(
        public readonly string  $id,
        public readonly string  $status,
        public readonly string  $type,
        public readonly int     $createdAt,
        public readonly string  $creatorId,
        public readonly ?string $rejectReason = null,
        public readonly ?string $projectId = null,
        public readonly ?string $investorId = null,
    ) {}
}