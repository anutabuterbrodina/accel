<?php

namespace App\Core\Component\Investor\Application\Service;

use App\Core\Component\Investor\Application\DTO\CreateInvestorDTO;
use App\Core\Component\Investor\Application\DTO\UpdateInvestorDescriptionDataDTO;
use App\Core\Component\Investor\Application\Repository\DQL\InvestorRepository;
use App\Core\Component\Investor\Domain\Investor\Investor;
use App\Core\Component\Investor\Domain\Investor\TypesEnum;
use App\Core\SharedKernel\Common\ValueObject\Requisites;
use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Core\SharedKernel\Component\Auth\UserId;
use App\Core\SharedKernel\Component\Investor\InvestorId;

class InvestorService
{
    public function __construct(
        private readonly InvestorRepository $investorRepository,
    ) {}

    public function create(CreateInvestorDTO $DTO): void {
        $investor = Investor::register(
            $DTO->getName(),
            $DTO->getDescription(),
            TypesEnum::from($DTO->getType()),
            $DTO->getRequisites(),
            $DTO->getUserId(),
            $DTO->getInterests(),
        );

        $this->investorRepository->add($investor);
    }

    public function updateDescriptionData(UpdateInvestorDescriptionDataDTO $DTO): void {
        $investor = $this->investorRepository->findById( $DTO->getId() );

        $investor->changeDescriptionData(
            $DTO->getName(),
            $DTO->getDescription(),
        );

        $this->investorRepository->add($investor);
    }

    public function updateRequisites(InvestorId $investorId, Requisites $requisites, int $type): void {
        $investor = $this->investorRepository->findById( $investorId );

        $investor->changeRequisites($requisites);
        $investor->changeType(TypesEnum::from($type));

        $this->investorRepository->add($investor);
    }

    /** @param Tag[] $interests */
    public function updateInterests(InvestorId $investorId, array $interests): void {
        $investor = $this->investorRepository->findById( $investorId );

        $investor->changeInterests($interests);

        $this->investorRepository->add($investor);
    }

    public function addMember(InvestorId $investorId, UserId $userId): void {
        $investor = $this->investorRepository->findById( $investorId );

        $investor->addMember( $userId );

        $this->investorRepository->add($investor);
    }

    public function removeMember(InvestorId $investorId, UserId $userId): void {
        $investor = $this->investorRepository->findById( $investorId );

        $investor->removeMember( $userId );

        $this->investorRepository->add($investor);
    }

    public function deactivate(InvestorId $investorId): void {
        $investor = $this->investorRepository->findById( $investorId );

        $investor->deactivate();

        $this->investorRepository->add($investor);
    }

    public function activate(InvestorId $investorId): void {
        $investor = $this->investorRepository->findById( $investorId );

        $investor->activate();

        $this->investorRepository->add($investor);
    }
}
