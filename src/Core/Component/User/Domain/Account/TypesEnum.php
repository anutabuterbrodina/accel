<?php

namespace Accel\App\Core\Component\User\Domain\Account;

enum TypesEnum: int
{
    case ADMIN = 0;

    case PROJECT = 1;

    case INVESTOR = 2;

    case EMPLOYEE = 3;
}
