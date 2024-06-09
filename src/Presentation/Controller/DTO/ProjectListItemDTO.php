<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class ProjectListItemDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    /** @var string[] */
    public readonly array $tagsList;

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $investmentMin,
        public readonly int $investmentMax,
        public readonly int $createdAt,
        private         string $tags,
    ) {
        $this->tagsList = json_decode($tags);
    }
}