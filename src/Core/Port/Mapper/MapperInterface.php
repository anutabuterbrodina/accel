<?php

namespace Accel\App\Core\Port\Mapper;

interface MapperInterface
{
    public function mapToORM($entityDomain);

    public function mapToDomain($entityORM);

    public function isNew(): bool;
}