<?php

namespace App\Core\SharedKernel\Component\Request;

enum StatusesEnum: int
{
    case OnModeration = 0;

    case Rejected = 1;

    case Accepted = 2;
}
