<?php

namespace Accel\App\Core\Port\Mapper;

use Accel\App\Core\Component\Deal\Domain\Deal\Deal;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Deal as DealORM;

interface DealMapperInterface extends MapperInterface
{
    /** @param Deal $entityDomain */
    public function mapToORM($entityDomain): DealORM;

    /** @param DealORM $entityORM */
    public function mapToDomain($entityORM): Deal;
}