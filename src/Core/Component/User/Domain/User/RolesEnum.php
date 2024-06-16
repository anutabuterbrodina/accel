<?php

namespace Accel\App\Core\Component\User\Domain\User;

enum RolesEnum: string
{
    case Anonymous = 'anonymous';

    case CommonUser = 'user';

    case Admin = 'admin';

    case Moderator = 'moderator';

    case CEO = 'ceo';

    case PR = 'pr_empl';
}
