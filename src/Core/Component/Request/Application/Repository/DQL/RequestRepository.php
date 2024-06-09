<?php

namespace Accel\App\Core\Component\Request\Application\Repository\DQL;

use Accel\App\Core\Component\Request\Domain\Request\AbstractRequest;
use Accel\App\Core\Component\Request\Domain\Request\RequestInterface;
use Accel\App\Core\Port\PersistenceServiceInterface;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\RequestMapperInterface;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;

class RequestRepository
{
    public function __construct(
        private readonly QueryBuilderInterface        $queryBuilder,
        private readonly PersistenceServiceInterface  $persistenceService,
        private readonly QueryServiceInterface        $queryService,
        private readonly RequestMapperInterface       $requestMapper,
    ) {}

    public function findById(RequestId $id): RequestInterface
    {
        $query = $this->queryBuilder->create('', 'Request')
            ->where('Request.id = :id')
            ->setParameter('id', $id->toScalar())
            ->build();

        /** @var RequestInterface $entity */
        $entity = $this->queryService->query($query)->mapSingleResultTo(AbstractRequest::class, $this->requestMapper);

        return $entity;
    }

    public function add(RequestInterface $request): void
    {
        $this->persistenceService->upsert($request, $this->requestMapper);
    }

    public function remove(RequestInterface $request): void
    {
        $this->persistenceService->delete($request);
    }
}