<?php

namespace Accel\App\Core\Component\Deal\Application\Repository\DQL;

use Accel\App\Core\Component\Deal\Domain\Deal\Deal;
use Accel\App\Core\Component\Deal\Domain\Deal\DealId;

class DealRepository
{
    public function __construct(
        private readonly QueryBuilder $queryBuilder,
        private readonly QueryServiceInterface $queryService,
        private readonly PersistenceServiceInterface $persistenceService,
    ) {}

    public function findById(DealId $id): Deal
    {
        $query = $this->queryBuilder->create(Deal::class)
            ->where('Deal.id = :id')
            ->setParameter('id', $id)
            ->build();

        return $this->queryService->query($query)->getSingleResult();
    }

//    public function findBySlug(string $slug): Post
//    {
//        $dqlQuery = $this->dqlQueryBuilder->create(Post::class)
//            ->where('Post.slug = :slug')
//            ->setParameter('slug', $slug)
//            ->build();
//
//        return $this->queryService->query($dqlQuery)->getSingleResult();
//    }

    public function add(Deal $deal): void
    {
        $this->persistenceService->upsert($deal);
    }

    public function remove(Deal $deal): void
    {
        $this->persistenceService->delete($deal);
    }
}
