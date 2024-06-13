<?php

namespace Accel\App\Core\Component\Project\Application\Query;

use Accel\App\Core\Component\Project\Application\DTO\ProjectListFiltersDTO;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Project;

class ProjectListQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    public function execute(ProjectListFiltersDTO $filters): ResultCollection {
        $this->queryBuilder->create(Project::class, 'Project')
            ->select(
                'Project.id',
                'Project.name AS name',
                'Project.description',
                'Project.investmentMin',
                'Project.investmentMax',
                'Project.createdAt',
                'JSON_ARRAYAGG(TagAgg.name) AS tags',
                'JSON_ARRAYAGG(User.id) AS members',
            )
            ->innerJoin('Project.tags', 'Tag')
            ->innerJoin('Project.tags', 'TagAgg')
            ->innerJoin('Project.users', 'User');

        if ($filters->getLimit() !== null) {
            $this->queryBuilder->setMaxResults($filters->getLimit());
        }

        foreach ($filters->getTags() ?? [] as $tag) {
            $tags[] = $tag->toScalar();
        }

        $this->applyFilter(
            'Tag.name',
            'IN',
            'tags',
            $tags ?? null,
            102,
        );
        $this->applyFilter(
            'Project.name',
            'LIKE',
            'projectName',
            $filters->getNameSearchString() === null ? null : '%' . $filters->getNameSearchString() . '%',
        );
        $this->applyFilter(
            'Project.investmentMin',
            '>=',
            'investmentMin',
            $filters->getInvestmentMin()?->value,
            1,
        );
        $this->applyFilter(
            'Project.investmentMax',
            '<=',
            'investmentMax',
            $filters->getInvestmentMax()?->value,
            1,
        );
        $this->applyFilter(
            'User.id',
            '=',
            'userId',
            $filters->getUserId()?->toScalar(),
        );

//        if ($filters->getUserId() !== null) {
//            $this->memberedBy($filters->getUserId());
//        }

        if ($filters->getSortOption() !== null) {
            $this->queryBuilder->orderBy(
                'Project.' . $filters->getSortOption()->value,
                $filters->getSortOrder()->value,
            );
        }

        $this->queryBuilder->groupByColumn('Project.id, Project.name, Project.description, Project.investmentMin, Project.investmentMax, Project.createdAt');

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

//    private function memberedBy(UserId $userId): void {
//        $this->queryBuilder
//            ->innerJoin('Project.users', 'User')
//            ->andWhere('User.id = :userId')
//            ->setParameter('userId', $userId->toScalar())
//        ;
//    }
}