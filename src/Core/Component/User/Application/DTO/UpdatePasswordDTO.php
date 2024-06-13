<?php

namespace Accel\App\Core\Component\User\Application\DTO;

use Accel\App\Core\SharedKernel\Component\User\UserId;

class UpdatePasswordDTO
{
    public function __construct(
        private readonly UserId $id,
        private readonly string $currentPassword,
        private readonly string $newPassword,
    ) {}

    public function getId(): UserId {
        return $this->id;
    }

    public function getCurrentPassword(): string {
        return $this->currentPassword;
    }

    public function getNewPassword(): string {
        return $this->newPassword;
    }
}