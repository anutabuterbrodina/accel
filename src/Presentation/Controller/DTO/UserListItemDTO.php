<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class UserListItemDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    public function __construct(
        public readonly string  $id,
        public readonly string  $name,
        public readonly string  $surname,
        public readonly string  $email,
        public readonly string  $phone,
    ) {}
}