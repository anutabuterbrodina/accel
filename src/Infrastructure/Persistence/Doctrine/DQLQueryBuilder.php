<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine;

use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Infrastructure\Query\DQLQuery;
use Accel\Extension\Helpers\ClassHelper;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

final class DQLQueryBuilder extends QueryBuilder implements QueryBuilderInterface
{
    private const ORM_ENTITIES_NAMESPACE = 'Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity';

    private int $hydrationMode;

    public function build(): DQLQuery {

        $query = $this->getQuery();
        $query->setCacheable(false);

        $dqlQuery = new DQLQuery($query);
        $dqlQuery->setHydrationMode($this->hydrationMode);

        return $dqlQuery;
    }

    public function create(string $entityName, string $alias, string $indexBy = null): self {
        // TODO: Найти лучший способ формирования алиасов и названия ORM классов
        $alias ??= ClassHelper::extractClassName($entityName);
        $ORMEntityName = self::ORM_ENTITIES_NAMESPACE . '\\' . $alias;

        $this->setCacheable(false);

        $this->reset();

        $this
            ->select($alias)
            ->from($ORMEntityName, $alias, $indexBy)
            ->setMaxResults(self::DEFAULT_MAX_RESULTS);

        return $this;
    }

    public function setParam($key, $value, $type = null): self {
        $this->setParameter($key, $value, $type);
        return $this;
    }

    public function groupByColumn(string $column): self {
        $this->groupBy($column);
        return $this;
    }

    public function addGroupByColumn(string $column): self {
        $this->addGroupBy($column);
        return $this;
    }

    public function useScalarHydration(): self
    {
        $this->hydrationMode = AbstractQuery::HYDRATE_SCALAR;
        return $this;
    }

    public function useScalarColumnHydration(): self
    {
        $this->hydrationMode = AbstractQuery::HYDRATE_SCALAR_COLUMN;
        return $this;
    }

    private function reset() {
        $this->hydrationMode = AbstractQuery::HYDRATE_OBJECT;
        $this->resetDQLParts();
    }
}