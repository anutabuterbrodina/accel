<?php

namespace Accel\App\Core\Component\Investor\Application\Query;

use Accel\App\Core\Component\Investor\Application\DTO\InvestorListFiltersDTO;
use Accel\App\Core\Component\Investor\Domain\Investor\Investor;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;

class InvestorListQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    public function applyFilter(
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

    public function execute(InvestorListFiltersDTO $filters, ?string $userId = null): ResultCollection {
        $this->queryBuilder->create(Investor::class, 'Investor')
            ->select(
                'Investor.id',
                'Investor.name AS name',
                'Investor.description AS description',
                'Investor.type',
                'Investor.createdAt',
                'JSON_ARRAYAGG(TagAgg.name) AS tags',
                'JSON_ARRAYAGG(User.id) AS users',
            )
            ->innerJoin('Investor.tags', 'Tag')
            ->innerJoin('Investor.tags', 'TagAgg')
            ->innerJoin('Investor.users', 'User');

        if ($filters->getLimit() !== null) {
            $this->queryBuilder->setMaxResults($filters->getLimit());
        }

        $this->applyFilter('Tag.name', 'IN', 'tags', $filters->getTags(), 102);
        $this->applyFilter('Investor.type', 'IN', 'types', $filters->getTypes(), 102);
        $this->applyFilter('Investor.name', 'LIKE', 'investorName', $filters->getNameSearchString());

        if ($userId !== null) {
            $this->memberedBy($userId);
        }

        if ($filters->getSortOption() !== null) {
            $this->queryBuilder->orderBy(
                'Investor.' . $filters->getSortOption()->value,
                $filters->getSortOrder()->value,
            );
        }

        $this->queryBuilder->groupByColumn('Investor.id, Investor.name, Investor.type, Investor.createdAt');

        $queryWrapper = $this->queryBuilder->build();

        return $this->queryService->query($queryWrapper);
    }

    private function memberedBy(string $userId): void {
        $this->queryBuilder
            ->innerJoin('Investor.users', 'User')
            ->andWhere('User.id = :userId')
            ->setParameter('userId', $userId)
        ;
    }
}