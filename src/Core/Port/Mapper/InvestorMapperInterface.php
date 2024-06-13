<?php

namespace Accel\App\Core\Port\Mapper;

use Accel\App\Core\Component\Investor\Domain\Investor\Investor;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Investor as InvestorORM;

interface InvestorMapperInterface extends MapperInterface
{
    /** @param Investor $entityDomain */
    public function mapToORM($entityDomain): InvestorORM;

    /** @param InvestorORM $entityORM */
    public function mapToDomain($entityORM): Investor;
}