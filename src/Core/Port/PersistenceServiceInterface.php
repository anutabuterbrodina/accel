<?php

namespace Accel\App\Core\Port;

use Accel\App\Core\Port\Mapper\MapperInterface;
use Accel\Extension\Entity\AbstractEntity;

interface PersistenceServiceInterface
{
    public function upsert(AbstractEntity $entity, MapperInterface $mapper = null): void;

}