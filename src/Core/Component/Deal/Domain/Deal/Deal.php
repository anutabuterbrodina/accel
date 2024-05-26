<?php

namespace App\Core\Component\Deal\Domain\Deal;

use App\Core\SharedKernel\Component\Auth\UserId;
use App\Core\SharedKernel\Component\Investor\InvestorId;
use App\Core\SharedKernel\Component\Project\ProjectId;

class Deal
{
    public function __construct(
        private readonly DealId       $id,
        private          StatusesEnum $status,
        private readonly UserId       $responsible,
        private          ?ProjectId   $project = null,
        private          ?InvestorId  $investor = null,
        private          ?Conditions  $conditions = null,
    ) {}


    /** Фабричный метод */

    public static function create(
        UserId                 $responsible,
        ProjectId | InvestorId $target
    ): self {
        $project = $target instanceof ProjectId ? $target : null;
        $investor = $target instanceof InvestorId ? $target : null;

        return new self(
            new DealId(),
            StatusesEnum::Initial,
            $responsible,
            $project,
            $investor
        );
    }


    /** Публичные методы */

    public function setProject(ProjectId $project): void {
        $this->project = $project;
    }

    public function unsetProject(): void {
        if ($this->investor === null) {
            throw new \Exception('Нельзя отвязать проект от сделки, т.к. отсутствует инвестор');
        }

        $this->status = StatusesEnum::SearchForProject;
        $this->investor = null;
    }

    public function setInvestor(InvestorId $investor): void {
        $this->investor = $investor;
    }

    public function unsetInvestor(): void {
        if ($this->project === null) {
            throw new \Exception('Нельзя отвязать инвестора от сделки, т.к. отсутствует проект');
        }

        $this->status = StatusesEnum::SearchForInvestor;
        $this->investor = null;
    }

    public function changeStatus(StatusesEnum $status): void {
        $this->status = $status;
    }

    public function changeConditions(int $investment): void {
        $this->conditions = new Conditions($investment);
    }

    public function closeSucceededDeal(): void {
        $this->status = StatusesEnum::Succeeded;
    }

    public function closeCanceledDeal(): void {
        $this->status = StatusesEnum::Canceled;
    }


    /** Приватные методы */
}
