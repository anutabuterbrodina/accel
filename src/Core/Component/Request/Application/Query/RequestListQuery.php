<?php

namespace Accel\App\Core\Component\Request\Application\Query;

use Accel\App\Core\Component\Request\Application\DTO\RequestListFiltersDTO;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;

final class RequestListQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    public function execute(RequestListFiltersDTO $filters): ResultCollection {
        $this->queryBuilder->create('Request', 'Request')
            ->select(
                'Request.id',
                'Request.status',
                'Request.type',
                'Request.rejectReason',
                'Creator.id AS creatorId',
                'Project.id AS projectId',
                'Investor.id AS investorId',
                'Request.createdAt',
            )
            ->innerJoin('Request.creator', 'Creator')
            ->leftJoin('Request.project', 'Project')
            ->leftJoin('Request.investor', 'Investor');

        if ($filters->getLimit() !== null) {
            $this->queryBuilder->setMaxResults($filters->getLimit());
        }

        foreach ($filters->getStatuses() ?? [] as $status) {
            $statuses[] = $status->value;
        }

        $this->applyFilter(
            'Request.status',
            'IN',
            'statuses',
            $statuses ?? null,
            102,
        );

        $this->applyFilter(
            'Creator.id',
            '=',
            'userId',
            $filters->getUserId()?->toScalar(),
        );

        $this->applyFilter(
            'Project.id',
            '=',
            'projectId',
            $filters->getProjectId()?->toScalar(),
        );

        $this->applyFilter(
            'Investor.id',
            '=',
            'investorId',
            $filters->getInvestorId()?->toScalar(),
        );

        if ($filters->getSortOption() !== null) {
            $this->queryBuilder->orderBy(
                'Request.' . $filters->getSortOption()->value,
                $filters->getSortOrder()->value,
            );
        }

        $queryWrapper = $this->queryBuilder->build();

        return $this->queryService->query($queryWrapper);
    }

    private function applyFilter(
        string $paramAlias,
        string $operator,
        string $paramKey,
        mixed  $paramValue,
        int    $paramType = 2,
    ): void {
        if ($paramValue !== null) {
            if (is_array($paramValue)) {
                $this->queryBuilder->andWhere($paramAlias . ' ' . $operator . ' (:' . $paramKey . ')');
            } else {
                $this->queryBuilder->andWhere($paramAlias . ' ' . $operator . ' :' . $paramKey);
            }

            $this->queryBuilder->setParam($paramKey, $paramValue, $paramType);
        }
    }
}
