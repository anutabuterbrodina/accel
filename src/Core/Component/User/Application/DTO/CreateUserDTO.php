<?php

namespace Accel\App\Core\Component\User\Application\DTO;

class CreateUserDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email,
        private readonly string $phone,
        private readonly string $password,
        private readonly int    $type,
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

    public function getType(): int {
        return $this->type;
    }
}