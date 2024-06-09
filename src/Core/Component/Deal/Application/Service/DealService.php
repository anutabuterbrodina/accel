<?php

namespace Accel\App\Core\Component\Deal\Application\Service;

use Accel\App\Core\Component\Deal\Application\DTO\CreateDealDTO;
use Accel\App\Core\Component\Deal\Application\DTO\UpdateDealConditionsDTO;
use Accel\App\Core\Component\Deal\Application\Repository\DQL\DealRepository;
use Accel\App\Core\Component\Deal\Domain\Deal\Deal;
use Accel\App\Core\Component\Deal\Domain\Deal\DealId;
use Accel\App\Core\Component\Deal\Domain\Deal\StatusesEnum;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;

class DealService
{
    public function __construct(
        private readonly DealRepository $dealRepository,
    ) {}

    public function create(CreateDealDTO $DTO): void {
        $deal = Deal::create(
            $DTO->getResponsible(),
            $DTO->getTarget(),
        );

        $this->dealRepository->add($deal);
    }

    public function updateConditions(UpdateDealConditionsDTO $DTO): void {
        $project = $this->dealRepository->findById( $DTO->getId() );

        $project->changeConditions(
            $DTO->getInvestment(),
        );

        $this->dealRepository->add($project);
    }

    public function setProject(DealId $dealId, ProjectId $projectId): void {
        $project = $this->dealRepository->findById( $dealId );

        $project->setProject($projectId);

        $this->dealRepository->add($project);
    }

    /** @throws \Exception */
    public function unsetProject(DealId $dealId): void {
        $project = $this->dealRepository->findById( $dealId );

        $project->unsetProject();

        $this->dealRepository->add($project);
    }

    public function setInvestor(DealId $dealId, InvestorId $investorId): void {
        $project = $this->dealRepository->findById( $dealId );

        $project->setInvestor($investorId);

        $this->dealRepository->add($project);
    }

    /** @throws \Exception */
    public function unsetInvestor(DealId $dealId): void {
        $project = $this->dealRepository->findById( $dealId );

        $project->unsetInvestor();

        $this->dealRepository->add($project);
    }

    public function updateStatus(DealId $dealId, int $statusCode): void {
        $deal = $this->dealRepository->findById( $dealId );

        $deal->changeStatus(
            StatusesEnum::from($statusCode),
        );

        $this->dealRepository->add($deal);
    }

    public function closeSucceededDeal(DealId $dealId): void {
        $deal = $this->dealRepository->findById( $dealId );

        $deal->closeSucceededDeal();

        $this->dealRepository->add($deal);
    }

    public function closeCanceledDeal(DealId $dealId): void {
        $deal = $this->dealRepository->findById( $dealId );

        $deal->closeCanceledDeal();

        $this->dealRepository->add($deal);
    }
}
