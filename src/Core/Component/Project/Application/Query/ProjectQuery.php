<?php

namespace Accel\App\Core\Component\Project\Application\Query;

use Accel\App\Core\Component\Project\Domain\Project\Project;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;

final class ProjectQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    public function execute(ProjectId $projectId): ResultCollection {
        $this->queryBuilder->create(Project::class, 'Project')
            ->select(
                'Project.id',
                'Project.status',
                'Project.name',
                'Project.description',
                'Project.businessPlanPath',
                'Project.investmentMin',
                'Project.investmentMax',
                'Project.createdAt',
                'Contact.id as contactId',
                'JSON_ARRAYAGG(Tag.name) AS tags',
                'JSON_ARRAYAGG(User.id) AS members',
            )
            ->where('Project.id = :projectId')
            ->innerJoin('Project.users', 'User')
            ->innerJoin('Project.tags', 'Tag')
            ->innerJoin('Project.contact', 'Contact')
            ->setParam('projectId', $projectId->toScalar());

        $queryWrapper = $this->queryBuilder->build();

        return $this->queryService->query($queryWrapper);
    }
}
