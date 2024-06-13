<?php

namespace Accel\App\Core\Component\Deal\Application\Repository;

use Accel\App\Core\Component\Deal\Domain\Deal\Deal;
use Accel\App\Core\Component\Deal\Domain\Deal\DealId;
use Accel\App\Core\Port\Mapper\DealMapperInterface;
use Accel\App\Core\Port\PersistenceServiceInterface;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;

class DealRepository
{
    public function __construct(
        private readonly QueryBuilderInterface       $queryBuilder,
        private readonly QueryServiceInterface       $queryService,
        private readonly PersistenceServiceInterface $persistenceService,
        private readonly DealMapperInterface         $dealMapper,
    ) {}

    public function findById(DealId $id): Deal {
        $query = $this->queryBuilder->create(Deal::class, 'Deal')
            ->where('Deal.id = :id')
            ->setParameter('id', $id)
            ->build();

        /** @var Deal $entity */
        $entity = $this->queryService
            ->query($query)
            ->mapSingleResultTo(Deal::class, $this->dealMapper);

        return $entity;
    }

    public function add(Deal $deal): void {
        $this->persistenceService->upsert($deal, $this->dealMapper);
    }
}
