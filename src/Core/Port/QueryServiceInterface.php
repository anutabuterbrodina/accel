<?php

namespace Accel\App\Core\Port;

use Accel\Extension\Entity\AbstractEntity;

interface QueryServiceInterface
{

    /**
     * @return ResultCollection<AbstractEntity>
     */
    public function query(QueryInterface $queryWrapper): ResultCollection;
}