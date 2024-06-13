<?php

namespace Accel\App\Core\Port\Mapper;

use Accel\App\Core\Component\Project\Domain\Project\Project;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Project as ProjectORM;

interface ProjectMapperInterface extends MapperInterface
{
    /** @param Project $entityDomain */
    public function mapToORM($entityDomain): ProjectORM;

    /** @param ProjectORM $entityORM */
    public function mapToDomain($entityORM): Project;
}