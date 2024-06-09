<?php

namespace Accel\App\Core\Component\Project\Domain\Project;

enum StatusesEnum: string
{
    case OnBoard = 'on_board';
    case OnModeration = 'on_moderation';
    case Archived = 'archived';
}
