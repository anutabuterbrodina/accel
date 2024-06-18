<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class ProjectDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    /** @var string[] */
    public readonly array $tagsList;

    /** @var string[] */
    public readonly array $membersList;

    public function __construct(
        private readonly string $tags,
        private readonly string $members,
        public readonly string  $id,
        public readonly string  $status,
        public readonly string  $name,
        public readonly string  $businessPlanPath,
        public readonly int     $investmentMin,
        public readonly int     $investmentMax,
        public readonly int     $createdAt,
        public readonly string  $contactId,
        public readonly ?string $description = null,
        public readonly ?string $ownerId = null,
    ) {
        $this->tagsList = json_decode($tags);
        $this->membersList = json_decode($this->members);
    }
}