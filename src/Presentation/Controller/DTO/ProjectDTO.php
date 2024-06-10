<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class ProjectDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $name,
        public readonly string $region,
        public readonly string $businessPlanPath,
        public readonly string $investmentMin,
        public readonly string $investmentMax,
        public readonly string $contactEmail,
        public readonly int $createdAt,
        public readonly ?string $description = null,
        public readonly ?int $updatedAt = null,
        public readonly ?array $tags = null,
    ) {}
}