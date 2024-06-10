<?php

namespace Accel\App\Core\Component\Project\Application\Query;

use Accel\App\Core\Component\Project\Application\DTO\ProjectListFiltersDTO;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Project;

class ProjectListQuery
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

    public function execute(ProjectListFiltersDTO $filters, ?string $userId = null): ResultCollection {
        $this->queryBuilder->create(Project::class, 'Project')
            ->select(
                'Project.id',
                'Project.name AS name',
                'Project.description AS description',
                'Project.investmentMin',
                'Project.investmentMax',
                'Project.createdAt',
                'JSON_ARRAYAGG(TagAgg.name) AS tags',
                'JSON_ARRAYAGG(User.id) AS users',
            )
            ->innerJoin('Project.tags', 'Tag')
            ->innerJoin('Project.tags', 'TagAgg')
            ->innerJoin('Project.users', 'User');

        if ($filters->getLimit() !== null) {
            $this->queryBuilder->setMaxResults($filters->getLimit());
        }

        $this->applyFilter('Tag.name', 'IN', 'tags', $filters->getTags(), 102);
        $this->applyFilter('Project.name', 'LIKE', 'projectName', $filters->getNameSearchString());
        $this->applyFilter('Project.investmentMin', '>=', 'investmentMin', $filters->getInvestmentMin(), 1);
        $this->applyFilter('Project.investmentMax', '<=', 'investmentMax', $filters->getInvestmentMax(), 1);

        if ($userId !== null) {
            $this->memberedBy($userId);
        }

        if ($filters->getSortOption() !== null) {
            $this->queryBuilder->orderBy(
                'Project.' . $filters->getSortOption()->value,
                $filters->getSortOrder()->value,
            );
        }

        $this->queryBuilder->groupByColumn('Project.id, Project.name, Project.investmentMin, Project.investmentMax, Project.createdAt');

        $queryWrapper = $this->queryBuilder->build();

        return $this->queryService->query($queryWrapper);
    }

    private function memberedBy(string $userId): void {
        $this->queryBuilder
            ->innerJoin('Project.users', 'User')
            ->andWhere('User.id = :userId')
            ->setParameter('userId', $userId)
        ;
    }
}