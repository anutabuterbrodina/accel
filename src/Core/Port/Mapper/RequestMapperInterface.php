<?php

namespace Accel\App\Core\Port\Mapper;

use Accel\App\Core\Component\Request\Domain\Request\RequestInterface;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Request as RequestORM;

interface RequestMapperInterface extends MapperInterface
{
    /** @param RequestInterface $entityDomain */
    public function mapToORM($entityDomain): RequestORM;

    /** @param RequestORM $entityORM */
    public function mapToDomain($entityORM);
}