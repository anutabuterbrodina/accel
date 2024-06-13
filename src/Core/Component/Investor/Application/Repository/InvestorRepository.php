<?php

namespace Accel\App\Core\Component\Investor\Application\Repository;

use Accel\App\Core\Component\Investor\Domain\Investor\Investor;
use Accel\App\Core\Port\Mapper\InvestorMapperInterface;
use Accel\App\Core\Port\PersistenceServiceInterface;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;

class InvestorRepository
{
    public function __construct(
        private readonly QueryBuilderInterface       $queryBuilder,
        private readonly QueryServiceInterface       $queryService,
        private readonly PersistenceServiceInterface $persistenceService,
        private readonly InvestorMapperInterface     $investorMapper,
    ) {}

    public function findById(InvestorId $id): Investor {
        $query = $this->queryBuilder->create(Investor::class, 'Investor')
            ->where('Investor.id = :id')
            ->setParameter('id', $id->toScalar())
            ->build();

        /** @var Investor $entity */
        $entity = $this->queryService
            ->query($query)
            ->mapSingleResultTo(Investor::class, $this->investorMapper);

        return $entity;
    }

    public function add(Investor $investor): void {
        $this->persistenceService->upsert($investor, $this->investorMapper);
    }
}
