<?php

namespace App\Core\Component\Project\Domain\Project;

use App\Core\SharedKernel\Abstract\Entity\AbstractEntity;
use App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use App\Core\SharedKernel\Common\ValueObject\FileObject;
use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Core\SharedKernel\Component\Auth\UserId;
use App\Core\SharedKernel\Component\Project\ProjectId;

class Project extends AbstractEntity
{
    /** @param UserId[] $team */
    public function __construct(
        private readonly ProjectId       $id,
        private          StatusesEnum    $status,
        private          DescriptionData $descriptionData,
        private          BusinessData    $businessData,
        private          UserId          $contact,
        private readonly UserId          $owner,
        private          array           $team,
	) {}


    /** Фабричный метод */

    /** @param Tag[] $tags */
    public static function create(
        string              $name,
        string              $description,
        FileObject          $businessPlan,
        InvestmentRangeEnum $requiredInvestmentMin,
        InvestmentRangeEnum $requiredInvestmentMax,
        UserId              $owner,
        array               $tags,
    ): self {
        return new self(
            new ProjectId(),
            StatusesEnum::OnBoard,
            new DescriptionData($name, $description),
            new BusinessData($businessPlan, $requiredInvestmentMin, $requiredInvestmentMax, $tags),
            $owner,
            $owner,
            [$owner],
        );
    }


    /** Публичные методы */

    public function changeDescriptionData(string $name, string $description): void {
        $this->descriptionData = new DescriptionData(
            $name,
            $description,
        );
    }

    /** @param Tag[] $tags */
    public function changeBusinessData(
        FileObject          $businessPlan,
        InvestmentRangeEnum $requiredInvestmentMin,
        InvestmentRangeEnum $requiredInvestmentMax,
        array               $tags,
    ): void {
        $this->businessData = new BusinessData(
            $businessPlan,
            $requiredInvestmentMin,
            $requiredInvestmentMax,
            $tags,
        );
    }

    public function addMember(UserId $member): void {
        if (!$this->contains($member, $this->team)) {
            $this->team[] = $member;
        }
    }

    public function removeMember(UserId $member): void {
        if ($key = $this->getKey($member, $this->team)) {
            unset($this->team[$key]);
        }
    }

    public function changeContact(UserId $contact): void {
        if (!$this->contains($contact, $this->team))
            throw new \Exception('Контактным лицом можно сделтаь только члена команды');

        $this->contact = $contact;
    }

    public function changeStatus(StatusesEnum $status): void {
        $this->status = $status;
    }


    /** Immutable getters */

    public function getId(): ProjectId {
        return $this->id;
    }

    public function getStatus(): StatusesEnum {
        return $this->status;
    }

    public function getDescriptionData(): DescriptionData {
        return $this->descriptionData;
    }

    public function getBusinessData(): BusinessData {
        return $this->businessData;
    }

    public function getContact(): UserId {
        return $this->contact;
    }

    public function getOwner(): UserId {
        return $this->owner;
    }

    /** @return UserId[] */
    public function getTeam(): array {
        return $this->team;
    }
}
