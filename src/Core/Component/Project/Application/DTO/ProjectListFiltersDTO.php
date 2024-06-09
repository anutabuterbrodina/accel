<?php

namespace Accel\App\Core\Component\Project\Application\DTO;

use Accel\App\Core\Component\Project\Application\Query\SortOrderEnum;

class ProjectListFiltersDTO
{
    /** @param string[]|null $tags */
    public function __construct(
        private readonly ?int $limit = null,
        private readonly ?array $tags = null,
        private readonly ?string $nameSearchString = null,
        private readonly ?int $investmentMin = null,
        private readonly ?int $investmentMax = null,
        private readonly ?ProjectListSortOptionsEnum $sortOption = null,
        private readonly ?SortOrderEnum $sortOrder = null,
    ) {}

    public function getLimit(): ?int {
        return $this->limit;
    }

    /** @return string[]|null */
    public function getTags(): ?array {
        return $this->tags;
    }

    public function getNameSearchString(): ?string {
        return '%' . $this->nameSearchString . '%';
    }

    public function getInvestmentMin(): ?int {
        return $this->investmentMin;
    }

    public function getInvestmentMax(): ?int {
        return $this->investmentMax;
    }

    public function getSortOption(): ?ProjectListSortOptionsEnum {
        return $this->sortOption;
    }

    public function getSortOrder(): SortOrderEnum {
        return $this->sortOrder ?? SortOrderEnum::ASC;
    }
}