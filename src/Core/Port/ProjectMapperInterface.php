<?php

namespace Accel\App\Core\Port;

use Accel\App\Core\Component\Project\Domain\Project\Project;

interface ProjectMapperInterface extends MapperInterface
{
    public function mapToORM($entityDomain);

    public function mapToDomain($entityORM): Project;
}