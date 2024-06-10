<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\Mapper;

use Accel\App\Core\Port\MapperInterface;

class MapperFactory
{
    public function make($className, $entityManager = null): MapperInterface {
        $mapperFQCN = __NAMESPACE__ . '\\' . $className . 'Mapper';
        return new $mapperFQCN($entityManager);
    }
}