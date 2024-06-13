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

    public function execute(InvestorListFiltersDTO $filters, ?string $userId = null): ResultCollection {
        $this->queryBuilder->create(Investor::class, 'Investor')
            ->select(
                'Investor.id',
                'Investor.name AS name',
                'Investor.description AS description',
                'Investor.type',
                'Investor.createdAt',
                'JSON_ARRAYAGG(TagAgg.name) AS interests',
                'JSON_ARRAYAGG(User.id) AS members',
            )
            ->innerJoin('Investor.tags', 'Tag')
            ->innerJoin('Investor.tags', 'TagAgg')
            ->innerJoin('Investor.users', 'User');

        if ($filters->getLimit() !== null) {
            $this->queryBuilder->setMaxResults($filters->getLimit());
        }

        foreach ($filters->getInterests() ?? [] as $interest) {
            $interests[] = $interest->toScalar();
        }

        foreach ($filters->getTypes() ?? [] as $type) {
            $types[] = $type->value;
        }

        $this->applyFilter(
            'Tag.name',
            'IN',
            'interests',
            $interests ?? null,
            102
        );
        $this->applyFilter(
            'Investor.type',
            'IN',
            'types',
            $types ?? null,
            102);
        $this->applyFilter(
            'Investor.name',
            'LIKE',
            'investorName',
            $filters->getNameSearchString() === null ? null : '%' . $filters->getNameSearchString() . '%',
        );
        $this->applyFilter(
            'User.id',
            '=',
            'userId',
            $filters->getUserId()?->toScalar(),
        );

//        if ($userId !== null) {
//            $this->memberedBy($userId);
//        }

        if ($filters->getSortOption() !== null) {
            $this->queryBuilder->orderBy(
                'Investor.' . $filters->getSortOption()->value,
                $filters->getSortOrder()->value,
            );
        }

        $this->queryBuilder->groupByColumn('Investor.id, Investor.name, Investor.description, Investor.type, Investor.createdAt');

        $queryWrapper = $this->queryBuilder->build();

        return $this->queryService->query($queryWrapper);
    }

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

//    private function memberedBy(string $userId): void {
//        $this->queryBuilder
//            ->innerJoin('Investor.users', 'User')
//            ->andWhere('User.id = :userId')
//            ->setParameter('userId', $userId)
//        ;
//    }
}