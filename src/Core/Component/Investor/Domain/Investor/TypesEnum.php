<?php

namespace App\Core\Component\Investor\Domain\Investor;

enum TypesEnum: int
{
    case Individual = 1;

    case LegalEntity = 2;

    case SoleTrader = 3;
}
