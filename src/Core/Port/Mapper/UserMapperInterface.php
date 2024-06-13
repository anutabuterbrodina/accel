<?php

namespace Accel\App\Core\Port\Mapper;

use Accel\App\Core\Component\User\Domain\User\User;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User as UserORM;

interface UserMapperInterface extends MapperInterface
{
    /** @param User $entityDomain */
    public function mapToORM($entityDomain): UserORM;

    /** @param UserORM $entityORM */
    public function mapToDomain($entityORM): User;
}