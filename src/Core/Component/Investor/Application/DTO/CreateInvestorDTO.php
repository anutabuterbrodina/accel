<?php

namespace Accel\App\Core\Component\Investor\Application\DTO;

use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class CreateInvestorDTO
{
    /** @param Tag[] $interests */
    public function __construct(
        private readonly InvestorId $id,
        private readonly UserId     $creator,
        private readonly string     $name,
        private readonly string     $description,
        private readonly string     $type,
        private readonly Requisites $requisites,
        private readonly array      $interests,
    ) {}

    public function getId(): InvestorId {
        return $this->id;
    }

    public function getUserId(): UserId {
        return $this->creator;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getRequisites(): Requisites {
        return $this->requisites;
    }

    /** @return Tag[] */
    public function getInterests(): array {
        return $this->interests;
    }
}
