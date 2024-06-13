<?php

namespace Accel\App\Core\Component\Request\Application\DTO;

use Accel\App\Core\Component\Request\Domain\Request\StatusesEnum;
use Accel\App\Core\SharedKernel\Common\SortOrderEnum;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class RequestListFiltersDTO
{
    /** @param StatusesEnum[]|null $statuses */
    public function __construct(
        private readonly ?int                        $limit = null,
        private readonly ?array                      $statuses = null,
        private readonly ?UserId                     $userId = null,
        private readonly ?ProjectId                  $projectId = null,
        private readonly ?InvestorId                 $investorId = null,
        private readonly ?RequestListSortOptionsEnum $sortOption = null,
        private readonly ?SortOrderEnum              $sortOrder = null,
    ) {}

    public function getLimit(): ?int {
        return $this->limit;
    }

    /** @return StatusesEnum[]|null */
    public function getStatuses(): ?array {
        return $this->statuses;
    }

    public function getUserId(): ?UserId {
        return $this->userId;
    }

    public function getProjectId(): ?ProjectId {
        return $this->projectId;
    }

    public function getInvestorId(): ?InvestorId {
        return $this->investorId;
    }

    public function getSortOption(): ?RequestListSortOptionsEnum {
        return $this->sortOption;
    }

    public function getSortOrder(): SortOrderEnum {
        return $this->sortOrder ?? SortOrderEnum::ASC;
    }
}