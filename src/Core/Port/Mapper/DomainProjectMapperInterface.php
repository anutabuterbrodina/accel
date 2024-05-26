<?php

namespace App\Core\Port\Mapper;

use App\Core\Component\Project\Domain\Project\Project;

interface DomainProjectMapperInterface
{
    public function mapToORM(Project $entity);
}