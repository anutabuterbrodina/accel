<?php

namespace Accel\App\Core\Component\Project\Application\Repository;

use Accel\App\Core\Component\Project\Domain\Project\Project;
use Accel\App\Core\Port\Mapper\ProjectMapperInterface;
use Accel\App\Core\Port\PersistenceServiceInterface;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;

class ProjectRepository
{
    public function __construct(
        private readonly QueryBuilderInterface       $queryBuilder,
        private readonly PersistenceServiceInterface $persistenceService,
        private readonly QueryServiceInterface       $queryService,
        private readonly ProjectMapperInterface      $projectMapper,
    ) {}

    public function findById(ProjectId $id): Project {
        $query = $this->queryBuilder->create(Project::class, 'Project')
            ->where('Project.id = :id')
            ->setParameter('id', $id->toScalar())
            ->build();

        /** @var Project $entity */
        $entity = $this->queryService
            ->query($query)
            ->mapSingleResultTo(Project::class, $this->projectMapper);

        return $entity;
    }

    public function add(Project $project): void {
        $this->persistenceService->upsert($project, $this->projectMapper);
    }
}
