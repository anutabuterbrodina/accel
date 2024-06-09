<?php

namespace Accel\App\Core\Port;

interface RequestMapperInterface extends MapperInterface
{
    public function mapToORM($entityDomain);

    public function mapToDomain($entityORM);
}