<?php

namespace Accel\App\Core\Component\Project\Application\DTO;

enum ProjectListSortOptionsEnum: string
{
    case DATE_CREATED = 'createdAt';
    case MIN_INVESTMENT = 'investmentMin';
    case MAX_INVESTMENT = 'investmentMax';
}