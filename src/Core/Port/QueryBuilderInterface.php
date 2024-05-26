<?php

namespace App\Core\Port;

interface QueryBuilderInterface
{
    public const DEFAULT_MAX_RESULTS = 30;

    public function create(string $entityName, string $alias = null, string $indexBy = null): self;

    public function setParam($key, $value, $type = null): self;

    public function setMaxResults(int $maxResults): static;

    public function select(string ...$select): static;

    public function distinct(bool $flag = true): static;

    public function addSelect(string ...$select): static;

    public function delete(string $delete = null, string $alias = null): static;

    public function update(string|null $update = null, string|null $alias = null): static;

    public function from(string $from, string $alias, string $indexBy = null): static;

    public function indexBy(string $alias, string $indexBy): static;

    public function join(
        string $join,
        string $alias,
        string $conditionType = null,
        string $condition = null,
        string $indexBy = null
    ): static;

    public function innerJoin(
        string $join,
        string $alias,
        string $conditionType = null,
        string $condition = null,
        string $indexBy = null
    ): static;

    public function leftJoin(
        string $join,
        string $alias,
        string $conditionType = null,
        string $condition = null,
        string $indexBy = null
    ): static;

    public function where(string $predicates): static;

    public function andWhere(string $predicates): static;

    public function orWhere(string $predicates): static;

    public function groupByColumn(string $column): self;

    public function addGroupByColumn(string $column): self;

    public function having(string $having): static;

    public function andHaving(string $having): static;

    public function orHaving(string $having): static;

    public function orderBy(string $sort, string $order = null): static;

    public function addOrderBy(string $sort, string $order = null): static;

    public function build(): QueryWrapperInterface;
}