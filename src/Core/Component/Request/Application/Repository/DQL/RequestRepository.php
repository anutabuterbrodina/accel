<?php

namespace App\Core\Component\Request\Application\Repository\DQL;

use App\Core\SharedKernel\Component\Request\AbstractRequest;
use App\Core\SharedKernel\Component\Request\RequestId;
use App\Core\SharedKernel\Component\Request\RequestInterface;

/**
 * This repository uses DQL language, so it is custom realization of ProjectRepository
 * therefore there is need of implementing ProjectRepositoryInterface
 */
class RequestRepository
{
    private $queryBuilder;

    private $queryService;

    private $persistenceService;

    public function __construct()
    {

    }

    public function findById(RequestId $id): RequestInterface
    {
        $query = $this->queryBuilder->create(Project::class)
            ->where('Post.id = :id')
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

    public function add(RequestInterface $project): void
    {
        $this->persistenceService->upsert($project);
    }

    public function remove(RequestInterface $project): void
    {
        $this->persistenceService->delete($project);
    }
}
