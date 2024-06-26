<?php

namespace Accel\App\Core\Port;

interface MapperInterface
{
    public function mapToORM($entityDomain);

    public function mapToDomain($entityORM);

    public function isNew(): bool;
}