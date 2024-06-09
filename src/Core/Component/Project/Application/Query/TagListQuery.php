<?php

namespace Accel\App\Core\Component\Project\Application\Query;

use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Project;

class TagListQuery
{
    private const TAG_ALIAS = 'tag';

    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    /** @param ProjectId|InvestorId $id */
    public function execute($id): ResultCollection {
        $queryWrapper = $this->queryBuilder->create(Project::class, 'Project')
            ->select('Tag.name AS ' . self::TAG_ALIAS)
            ->innerJoin('Project.tags', 'Tag')
            ->where('Project.id = :projectId')
            ->setParameter('projectId', $id->toScalar())
            ->useScalarColumnHydration()
            ->build();

        return $this->queryService->query($queryWrapper);
    }
}