<?php

namespace App\Core\Component\Project\Domain\Project;

enum StatusesEnum: int
{
    case OnBoard = 1;
    case OnModeration = 2;
    case Archived = 3;
}
