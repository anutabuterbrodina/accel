<?php

namespace Accel\App\Core\Component\User\Application\DTO;

use Accel\App\Core\SharedKernel\Component\User\UserId;

class CreateUserDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email,
        private readonly string $phone,
        private readonly string $password,
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getSurname(): string {
        return $this->surname;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function getPassword(): string {
        return $this->password;
    }
}