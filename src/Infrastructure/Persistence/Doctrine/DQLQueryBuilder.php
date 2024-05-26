<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Core\Port\QueryBuilderInterface;
use App\Infrastructure\Query\DQLQueryWrapper;
use Doctrine\ORM\QueryBuilder;

final class DQLQueryBuilder extends QueryBuilder implements QueryBuilderInterface
{
    public function build(): DQLQueryWrapper {
        return new DQLQueryWrapper($this->getQuery());
    }

    public function create(string $entityName, string $alias = null, string $indexBy = null): self {
//        $alias = $alias ?? ClassHelper::extractCanonicalClassName($entityName);

//        $this->reset();

        return $this->select($alias)->from($entityName, $alias, $indexBy)->setMaxResults(self::DEFAULT_MAX_RESULTS);
    }

    public function setParam($key, $value, $type = null): self {
        return $this->setParameter($key, $value, $type);
    }

    public function groupByColumn(string $column): self {
        return $this->groupBy($column);
    }

    public function addGroupByColumn(string $column): self {
        return $this->addGroupBy($column);
    }
}