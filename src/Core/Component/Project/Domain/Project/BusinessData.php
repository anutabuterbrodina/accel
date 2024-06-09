<?php

namespace Accel\App\Core\Component\Project\Domain\Project;

use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;

class BusinessData
{
	/** @param Tag[] $tags */
	public function __construct(
        private readonly FileObject          $businessPlan,
		private readonly InvestmentRangeEnum $requiredInvestmentMin,
		private readonly InvestmentRangeEnum $requiredInvestmentMax,
        private readonly array               $tags,
	) {}

	public function getBusinessPlan(): FileObject {
		return $this->businessPlan;
	}

	public function getRequiredInvestmentMin(): InvestmentRangeEnum {
		return $this->requiredInvestmentMin;
	}

	public function getRequiredInvestmentMax(): InvestmentRangeEnum {
		return $this->requiredInvestmentMax;
	}

	/** @return Tag[] */
	public function getTags(): array {
		return $this->tags;
	}
}