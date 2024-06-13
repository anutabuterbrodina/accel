<?php

namespace Accel\App\Core\Component\Investor\Domain\Investor;

enum TypesEnum: string
{
    case Individual = 'individual';

    case LegalEntity = 'legal_entity';

    case SoleTrader = 'sole_trader';
}
