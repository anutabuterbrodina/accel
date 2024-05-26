<?php

namespace App\Infrastructure\Query;

use App\Core\Port\QueryWrapperInterface;
use Doctrine\ORM\Query;

class DQLQueryWrapper implements QueryWrapperInterface
{
    public function __construct(
        private readonly Query $query,
    ) {}

    public function getQuery(): Query {
        return $this->query;
    }
}
