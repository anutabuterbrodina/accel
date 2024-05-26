<?php

namespace App\Core\Component\Investor\Domain\Investor;

use App\Core\SharedKernel\Abstract\Entity\AbstractEntity;
use App\Core\SharedKernel\Common\ValueObject\Requisites;
use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Core\SharedKernel\Component\Auth\UserId;
use App\Core\SharedKernel\Component\Investor\InvestorId;

class Investor extends AbstractEntity
{
    /**
     * @param UserId[] $members
     * @param Tag[] $interests
     */
    public function __construct(
        private readonly InvestorId      $id,
        private          bool            $isActive,
        private          TypesEnum       $type,
        private          DescriptionData $descriptionData,
        private          Requisites      $requisites,
        private          array           $members,
        private          array           $interests,
    ) {}


    /** Фабричный метод */

    /** @param Tag[] $interests */
    public static function register(
        string     $name,
        string     $description,
        TypesEnum  $type,
        Requisites $requisites,
        UserId     $creator,
        array      $interests,
    ): self {
        return new self(
            new InvestorId(),
            true,
            $type,
            new DescriptionData($name, $description),
            $requisites,
            [$creator],
            $interests,
        );
    }


    /** Публичные методы */

    public function changeDescriptionData(string $name, string $description): void {
        $this->descriptionData = new DescriptionData(
            $name,
            $description,
        );
    }

    /** @param Tag[] $interests */
    public function changeInterests(array $interests): void {
        $this->interests = $interests;
    }

    public function changeRequisites(Requisites $requisites): void {
        $this->requisites = $requisites;
    }

    public function changeType(TypesEnum $type): void {
        $this->type = $type;
    }

    public function addMember(UserId $member): void {
        if (!$this->contains($member, $this->members)) {
            $this->members[] = $member;
        }
    }

    public function removeMember(UserId $member): void {
        if ($key = $this->getKey($member, $this->members)) {
            unset($this->members[$key]);
        }
    }

    public function deactivate(): void {
        $this->isActive = false;
    }

    public function activate(): void {
        $this->isActive = true;
    }


    /** Приватные методы */
}