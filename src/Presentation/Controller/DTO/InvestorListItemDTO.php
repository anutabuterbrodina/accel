<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class InvestorListItemDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    /** @var string[] */
    public readonly array $interestList;

    /** @var string[] */
    public readonly array $membersList;

    public function __construct(
        private readonly string $interests,
        private readonly string $members,
        public readonly string  $id,
        public readonly string  $name,
        public readonly string  $description,
        public readonly int     $createdAt,
        public readonly string  $type,
    ) {
        $this->interestList = json_decode($this->interests);
        $this->membersList = json_decode($members);
    }
}