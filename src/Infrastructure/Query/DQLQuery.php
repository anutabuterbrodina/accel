<?php

namespace Accel\App\Infrastructure\Query;

use Accel\App\Core\Port\QueryInterface;
use Doctrine\ORM\Query;

class DQLQuery implements QueryInterface
{
    public function __construct(
        private readonly Query $query,
    ) {}

    public function getQuery(): Query {
        return $this->query;
    }

    public function setHydrationMode(int $hydrationMode): void {
        $this->query->setHydrationMode($hydrationMode);
    }
}
