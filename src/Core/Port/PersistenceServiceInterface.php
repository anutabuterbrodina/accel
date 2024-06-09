<?php

namespace Accel\App\Core\Port;

interface PersistenceServiceInterface
{
    public function upsert($entity, MapperInterface $mapper = null): void;

}