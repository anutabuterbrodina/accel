<?php

namespace Accel\App\Core\Component\Investor\Domain\Investor;

use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\Extension\Entity\AbstractEntity;

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
        private readonly UserId          $owner,
        private          array           $members,
        private          array           $interests,
    ) {}


    /** Фабричный метод */

    /** @param Tag[] $interests */
    public static function register(
        ?InvestorId $id,
        string      $name,
        string      $description,
        TypesEnum   $type,
        Requisites  $requisites,
        UserId      $creator,
        array       $interests,
    ): self {
        if (empty($interests)) {
            throw new \Exception('Необходимо выбрать хотя бы одну категорию интересов');
        }

        return new self(
            $id ?? new InvestorId(),
            true,
            $type,
            new DescriptionData($name, $description),
            $requisites,
            $creator,
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
        if (empty($interests)) {
            throw new \Exception('Необходимо выбрать хотя бы одну категорию интересов');
        }
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


    /** Immutable getters */

    public function getId(): InvestorId {
        return $this->id;
    }

    public function isActive(): bool {
        return $this->isActive;
    }

    public function getType(): TypesEnum {
        return $this->type;
    }

    public function getDescriptionData(): DescriptionData {
        return $this->descriptionData;
    }

    public function getRequisites(): Requisites {
        return $this->requisites;
    }

    public function getOwner(): UserId {
        return $this->owner;
    }

    /** @return UserId[] */
    public function getMembers(): array {
        return $this->members;
    }

    /** @return UserId[] */
    public function getInterests(): array {
        return $this->interests;
    }
}