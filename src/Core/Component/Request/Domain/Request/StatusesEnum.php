<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

enum StatusesEnum: string
{
    case OnModeration = 'on_moderation';

    case Rejected = 'rejected';

    case Accepted = 'accepted';
}
