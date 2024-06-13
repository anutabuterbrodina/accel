<?php

namespace Accel\App\Core\Component\Investor\Application\DTO;

use Accel\App\Core\Component\Investor\Domain\Investor\TypesEnum;
use Accel\App\Core\SharedKernel\Common\SortOrderEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class InvestorListFiltersDTO
{
    /**
     * @param Tag[]|null $interests
     * @param TypesEnum[]|null $types
     */
    public function __construct(
        private readonly ?int                         $limit = null,
        private readonly ?array                       $interests = null,
        private readonly ?array                       $types = null,
        private readonly ?UserId                      $userId = null,
        private readonly ?string                      $nameSearchString = null,
        private readonly ?InvestorListSortOptionsEnum $sortOption = null,
        private readonly ?SortOrderEnum               $sortOrder = null,
    ) {}

    public function getLimit(): ?int {
        return $this->limit;
    }

    /** @return Tag[]|null */
    public function getInterests(): ?array {
        return $this->interests;
    }

    /** @return TypesEnum[]|null */
    public function getTypes(): ?array {
        return $this->types;
    }

    public function getUserId(): ?UserId {
        return $this->userId;
    }

    public function getNameSearchString(): ?string {
        return $this->nameSearchString;
    }

    public function getSortOption(): ?InvestorListSortOptionsEnum {
        return $this->sortOption;
    }

    public function getSortOrder(): SortOrderEnum {
        return $this->sortOrder ?? SortOrderEnum::ASC;
    }
}