<?php

namespace Accel\App\Core\Component\User\Application\DTO;

use Accel\App\Core\SharedKernel\Component\User\UserId;

class UpdateProfileDataDTO
{
    public function __construct(
        private readonly UserId $id,
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email,
        private readonly string $phone,
    ) {}

    public function getId(): UserId {
        return $this->id;
    }

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
}