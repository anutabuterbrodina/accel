<?php

namespace Accel\App\Core\Component\Project\Application\Query;

use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Project;

class BookmarkListQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    public function execute(UserId $userId): ResultCollection {
        $queryWrapper = $this->queryBuilder->create('Bookmark', 'Bookmark')
            ->select(
                'Project.id',
            )
            ->innerJoin('Bookmark.project', 'Project')
            ->where('Bookmark.user = :userId')
            ->setParam('userId', $userId->toScalar())
            ->useScalarColumnHydration()
            ->build();

        return $this->queryService->query($queryWrapper);
    }
}