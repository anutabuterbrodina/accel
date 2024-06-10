<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class InvestorListItemDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    /** @var string[] */
    public readonly array $tagsList;

    /** @var string[] */
    public readonly array $membersList;

    public function __construct(
        public readonly string  $id,
        public readonly string  $name,
        public readonly string  $description,
        public readonly int     $createdAt,
        public readonly string  $type,
        private readonly string $tags,
        private readonly string $users,
    ) {
        $this->tagsList = json_decode($tags);
        $this->membersList = json_decode($users);
    }
}