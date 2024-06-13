<?php

namespace Accel\App\Core\Component\User\Domain\User;

use Accel\App\Core\Component\User\Domain\Account\Account;
use Accel\App\Core\Component\User\Domain\Account\AccountId;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\Extension\Entity\AbstractEntity;

class User extends AbstractEntity
{
    public function __construct(
        private readonly UserId $id,
        private readonly Account $account,
        private          bool $isActive,
        private          string $name,
        private          string $surname,
        private          string $email,
        private          string $phone,
        private          string $password,
        private readonly RolesEnum $role,
    ) {}


    /** Фабричный метод */

    public static function register(
        string $name,
        string $surname,
        string $email,
        string $phone,
        string $password,
    ): self {
       return new self(
           new UserId(),
           new Account(
               new AccountId()
           ),
           true,
           $name,
           $surname,
           $email,
           $phone,
           $password,
           RolesEnum::CommonUser,
       );
    }


    /** Публичные методы */

    public function changeProfileData(string $name, string $surname, string $email, string $phone) {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function changePassword(string $currentPassword, string $newPassword) {
        if ($currentPassword !== $this->password) {
            throw new \Exception('Неверный пароль');
        }

        $this->password = $newPassword;
    }

    public function activate(): void {
        $this->isActive = true;
    }

    public function deactivate(): void {
        $this->isActive = false;
    }


    /** Приватные методы */


    /** Immutable getters */

    public function getId(): UserId {
        return $this->id;
    }

    public function getAccountId(): AccountId {
        return $this->account->getId();
    }

    public function getAccount(): Account {
        return $this->account;
    }

    public function isActive(): bool {
        return $this->isActive;
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

    public function getPassword(): string {
        return $this->password;
    }

    public function getRole(): RolesEnum {
        return $this->role;
    }
}
