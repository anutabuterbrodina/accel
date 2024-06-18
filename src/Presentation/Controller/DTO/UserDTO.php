<?php

namespace Accel\App\Presentation\Controller\DTO;

use Accel\Extension\Helpers\ConstructableFromArrayInterface;
use Accel\Extension\Helpers\ConstructableFromArrayTrait;

class UserDTO implements ConstructableFromArrayInterface
{
    use ConstructableFromArrayTrait;

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $phone,
        public readonly bool   $isActive,
        public readonly string $role,
        public readonly int    $createdAt,
        public readonly int    $type,
        public readonly ?int   $updatedAt = null,
    ) {}
}