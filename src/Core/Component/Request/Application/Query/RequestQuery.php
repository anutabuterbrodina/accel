<?php

namespace Accel\App\Core\Component\Request\Application\Query;

use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;

final class RequestQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
        private          bool                  $isWithMembers = false,
        private          bool                  $isWithTags    = false,
    ) {}

    public function execute(RequestId $requestId): ResultCollection {
        $queryObj = $this->queryBuilder->create(Abstra::class, 'Project')
            ->select(
                'Project.id',
                'Project.status',
                'Project.name',
                'Project.description',
                'Project.region',
                'Project.businessPlanPath',
                'Project.investmentMin',
                'Project.investmentMax',
                'Project.contactEmail',
                'Project.createdAt',
                'Project.updatedAt',
            )
            ->where('Project.id = :projectId')
            ->setParam('projectId', $projectId)
            ->build();

        $projectData = $this->queryService->query($queryObj)
            ->getSingleResult();

        if ($this->isWithTags) {
            $projectData['tags'] = $this->findTags($projectId);
        }

        if (empty($projectData)) {
            return new ResultCollection();
        }

        return new ResultCollection([$projectData]);
    }

    public function withMembers(): self {
        $this->isWithMembers = true;
        return $this;
    }

    public function withTags(): self {
        $this->isWithTags = true;
        return $this;
    }

    private function findTags($projectId): array {
        return $this->tagListQuery->execute($projectId)->toArray();
    }
}
