<?php

namespace Accel\App\Core\Component\User\Application\Service;

use Accel\App\Core\Component\User\Application\DTO\CreateUserDTO;
use Accel\App\Core\Component\User\Application\DTO\UpdateProfileDataDTO;
use Accel\App\Core\Component\User\Application\Repository\UserRepository;
use Accel\App\Core\Component\User\Domain\User\User;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}

    public function createAndReturnUser(CreateUserDTO $DTO): User {
        $user = User::register(
            $DTO->getName(),
            $DTO->getSurname(),
            $DTO->getEmail(),
            $DTO->getPhone(),
            $DTO->getPassword(),
        );

        $this->userRepository->add($user);

        return $user;
    }

    public function updateProfileData(UpdateProfileDataDTO $DTO): void {
        if ($this->userRepository->findByEmail($DTO->getEmail()) !== null) {
            throw new \Exception('Email занят');
        }

        if ($this->userRepository->findByEmail($DTO->getPhone()) !== null) {
            throw new \Exception('Номер занят');
        }

        $user = $this->userRepository->findById($DTO->getId());

        $user->changeProfileData(
            $DTO->getName(),
            $DTO->getSurname(),
            $DTO->getEmail(),
            $DTO->getPhone(),
        );

        $this->userRepository->add($user);
    }

    public function updatePassword(UserId $userId, string $currentPassword, string $newPassword) {
        $user = $this->userRepository->findById($userId);

        $user->changePassword(
            $currentPassword,
            $newPassword,
        );
    }

    public function activate(UserId $userId): void {
        $user = $this->userRepository->findById($userId);

        $user->deactivate();

        $this->userRepository->add($user);
    }

    public function deactivate(UserId $userId): void {
        $user = $this->userRepository->findById($userId);

        $user->deactivate();

        $this->userRepository->add($user);
    }
}