<?php

namespace Accel\App\Core\Component\Project\Application\Service;

use Accel\App\Core\Component\Project\Application\DTO\CreateProjectDTO;
use Accel\App\Core\Component\Project\Application\DTO\UpdateProjectBusinessDataDTO;
use Accel\App\Core\Component\Project\Application\DTO\UpdateProjectCommonDataDTO;
use Accel\App\Core\Component\Project\Application\Repository\ProjectRepository;
use Accel\App\Core\Component\Project\Domain\Project\Project;
use Accel\App\Core\Component\Project\Domain\Project\StatusesEnum;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;

class ProjectService
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {}

    public function create(CreateProjectDTO $DTO): void {
        $project = Project::create(
            $DTO->getProjectId(),
            $DTO->getName(),
            $DTO->getDescription(),
            $DTO->getBusinessPlan(),
            $DTO->getRequiredInvestmentMin(),
            $DTO->getRequiredInvestmentMax(),
            $DTO->getUserId(),
            $DTO->getTags(),
        );

        $this->projectRepository->add($project);
    }

    public function updateStatus(ProjectId $projectId, string $status): void {
        $project = $this->projectRepository->findById( $projectId );

        $project->changeStatus(
            StatusesEnum::from($status),
        );

        $this->projectRepository->add($project);
    }

    public function updateCommonData(UpdateProjectCommonDataDTO $DTO): void {
        $project = $this->projectRepository->findById( $DTO->getId() );

        $project->changeDescriptionData(
            $DTO->getName(),
            $DTO->getDescription(),
        );

        $this->projectRepository->add($project);
    }

    public function updateBusinessData(UpdateProjectBusinessDataDTO $DTO): void {
        $project = $this->projectRepository->findById( $DTO->getId() );

        $project->changeBusinessData(
            $DTO->getBusinessPlan(),
            $DTO->getRequiredInvestmentMin(),
            $DTO->getRequiredInvestmentMax(),
            $DTO->getTags(),
        );

        $this->projectRepository->add($project);
    }

    public function addMember(ProjectId $projectId, UserId $userId): void {
        $project = $this->projectRepository->findById( $projectId );

        $project->addMember( $userId );

        $this->projectRepository->add($project);
    }

    public function removeMember(ProjectId $projectId, UserId $userId): void {
        $project = $this->projectRepository->findById( $projectId );

        $project->removeMember( $userId );

        $this->projectRepository->add($project);
    }

    /** @throws \Exception */
    public function updateContact(ProjectId $projectId, UserId $userId): void {
        $project = $this->projectRepository->findById( $projectId );

        $project->changeContact( $userId );

        $this->projectRepository->add($project);
    }

    public function archive(ProjectId $projectId): void {
        $project = $this->projectRepository->findById( $projectId );

        $project->archive();

        $this->projectRepository->add($project);
    }

    public function unarchive(ProjectId $projectId): void {
        $project = $this->projectRepository->findById( $projectId );

        $project->unarchive();

        $this->projectRepository->add($project);
    }
}
