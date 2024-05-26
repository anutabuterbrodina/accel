<?php

namespace App\Core\SharedKernel\Component\Request;

enum TypesEnum: int
{
    case RegisterProject = 1;

    case RegisterInvestor = 2;

    case ChangeInvestorBusinessData = 3;

    case ChangeProjectBusinessData = 4;
}
