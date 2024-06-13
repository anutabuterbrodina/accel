<?php

namespace Accel\App\Core\Component\Project\Application\DTO;

use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\SortOrderEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class ProjectListFiltersDTO
{
    /** @param Tag[]|null $tags */
    public function __construct(
        private readonly ?int                        $limit = null,
        private readonly ?array                      $tags = null,
        private readonly ?UserId                     $userId = null,
        private readonly ?string                     $nameSearchString = null,
        private readonly ?InvestmentRangeEnum        $investmentMin = null,
        private readonly ?InvestmentRangeEnum        $investmentMax = null,
        private readonly ?ProjectListSortOptionsEnum $sortOption = null,
        private readonly ?SortOrderEnum              $sortOrder = null,
    ) {}

    public function getLimit(): ?int {
        return $this->limit;
    }

    /** @return Tag[]|null */
    public function getTags(): ?array {
        return $this->tags;
    }

    public function getUserId(): ?UserId {
        return $this->userId;
    }

    public function getNameSearchString(): ?string {
        return $this->nameSearchString;
    }

    public function getInvestmentMin(): ?InvestmentRangeEnum {
        return $this->investmentMin;
    }

    public function getInvestmentMax(): ?InvestmentRangeEnum {
        return $this->investmentMax;
    }

    public function getSortOption(): ?ProjectListSortOptionsEnum {
        return $this->sortOption;
    }

    public function getSortOrder(): SortOrderEnum {
        return $this->sortOrder ?? SortOrderEnum::ASC;
    }
}