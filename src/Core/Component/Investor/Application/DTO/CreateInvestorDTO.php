<?php

namespace Accel\App\Core\Component\Investor\Application\DTO;

use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;

class CreateInvestorDTO
{
    /** @param Tag[] $interests */
    public function __construct(
        private readonly string     $name,
        private readonly string     $description,
        private readonly int        $type,
        private readonly Requisites $requisites,
        private readonly UserId     $creator,
        private readonly array      $interests,
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getType(): int {
        return $this->type;
    }

    public function getRequisites(): Requisites {
        return $this->requisites;
    }

    public function getUserId(): UserId {
        return $this->creator;
    }

    /** @return Tag[] */
    public function getInterests(): array {
        return $this->interests;
    }
}
