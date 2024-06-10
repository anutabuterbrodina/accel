<?php

namespace Accel\App\Core\Component\Deal\Domain\Deal;

enum StatusesEnum: int
{
    case Initial = 0;

    case SearchForProject = 1;

    case ProjectFound = 2;

    case SearchForInvestor = 3;

    case InvestorFound = 4;

    case DetailsDiscussion = 5;

    case PreparingAgreement = 6;

    case Succeeded = 100;

    case Canceled = 200;
}
