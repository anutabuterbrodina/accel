<?php

namespace Accel\App\Core\Component\Investor\Application\DTO;

use Accel\App\Core\SharedKernel\Common\SortOrderEnum;

class InvestorListFiltersDTO
{
    /**
     * @param string[]|null $tags
     * @param string[]|null $types
     */
    public function __construct(
        private readonly ?int $limit = null,
        private readonly ?array $tags = null,
        private readonly ?array $types = null,
        private readonly ?string $nameSearchString = null,
        private readonly ?InvestorListSortOptionsEnum $sortOption = null,
        private readonly ?SortOrderEnum $sortOrder = null,
    ) {}

    public function getLimit(): ?int {
        return $this->limit;
    }

    /** @return string[]|null */
    public function getTags(): ?array {
        return $this->tags;
    }

    /** @return string[]|null */
    public function getTypes(): ?array {
        return $this->types;
    }

    public function getNameSearchString(): ?string {
        return isset($this->nameSearchString) ? '%' . $this->nameSearchString . '%' : null;
    }

    public function getSortOption(): ?InvestorListSortOptionsEnum {
        return $this->sortOption;
    }

    public function getSortOrder(): SortOrderEnum {
        return $this->sortOrder ?? SortOrderEnum::ASC;
    }
}