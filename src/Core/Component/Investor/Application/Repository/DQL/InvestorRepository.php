<?php

namespace App\Core\Component\Investor\Application\Repository\DQL;

use App\Core\Component\Investor\Application\Repository\PersistenceServiceInterface;
use App\Core\Component\Investor\Application\Repository\QueryBuilder;
use App\Core\Component\Investor\Application\Repository\QueryServiceInterface;
use App\Core\Component\Investor\Domain\Investor\Investor;
use App\Core\SharedKernel\Abstract\Repository\RepositoryInterface;
use App\Core\SharedKernel\Component\Investor\InvestorId;

class InvestorRepository
{
    public function __construct(
        private readonly QueryBuilder $queryBuilder,
        private readonly QueryServiceInterface $queryService,
        private readonly PersistenceServiceInterface $persistenceService,
    ) {}

    public function findById(InvestorId $id): Investor
    {
        $query = $this->queryBuilder->create(Investor::class)
            ->where('Investor.id = :id')
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

    public function add(Investor $investor): void
    {
        $this->persistenceService->upsert($investor);
    }

    public function remove(Investor $investor): void
    {
        $this->persistenceService->delete($investor);
    }
}
