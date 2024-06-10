<?php

namespace Accel\App\Core\SharedKernel\Common\Enum;

enum InvestmentRangeEnum: int
{
    case VALUE_100K = 100000;
    case VALUE_500K = 500000;
    case VALUE_1M = 1000000;
    case VALUE_5M = 5000000;
    case VALUE_10M = 10000000;
}
