<?php

namespace App\Core\Component\Project\Application\Repository;

use App\Core\Component\Project\Domain\Project\Project;
use App\Core\Port\Mapper\DomainProjectMapperInterface;
use App\Core\Port\PersistenceServiceInterface;
use App\Core\Port\QueryBuilderInterface;
use App\Core\Port\QueryServiceInterface;
use App\Core\SharedKernel\Component\Project\ProjectId;

class ProjectRepository
{
    public function __construct(
        private readonly QueryBuilderInterface        $queryBuilder,
        private readonly PersistenceServiceInterface  $persistenceService,
        private readonly QueryServiceInterface        $queryService,
        private readonly DomainProjectMapperInterface $mapper,
    ) {}

    public function findById(ProjectId $id): Project
    {
        $query = $this->queryBuilder->create(Project::class)
            ->where('Post.id = :id')
            ->setParameter('id', $id)
            ->build();

        return $this->queryService->query($query);
    }

    public function add(Project $project): void
    {
        $projectORM = $this->mapper->mapToORM($project);
        $this->persistenceService->upsert($projectORM);
        var_dump('SUCC');die();
    }

    public function remove(Project $project): void
    {
        $projectORM = $this->mapper->mapToORM($project);
        $this->persistenceService->delete($projectORM);
    }
}
