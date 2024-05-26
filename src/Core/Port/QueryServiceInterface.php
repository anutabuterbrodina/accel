<?php

namespace App\Core\Port;

interface QueryServiceInterface
{
    public function query(QueryWrapperInterface $queryWrapper);
}