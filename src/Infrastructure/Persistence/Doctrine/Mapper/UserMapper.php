<?php

namespace Accel\App\Infrastructure\Persistence\Doctrine\Mapper;

use Accel\App\Core\Component\User\Domain\Account\Account;
use Accel\App\Core\Component\User\Domain\Account\AccountId;
use Accel\App\Core\Component\User\Domain\Account\TypesEnum;
use Accel\App\Core\Component\User\Domain\User\RolesEnum;
use Accel\App\Core\Component\User\Domain\User\User;
use Accel\App\Core\Port\Mapper\UserMapperInterface;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Account as AccountORM;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User as UserORM;
use Doctrine\ORM\EntityManagerInterface;

class UserMapper implements UserMapperInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private ?UserORM $userORM = null,
    ) {}

    public function isNew(): bool {
        return $this->userORM === null;
    }

    /** @param User $user */
    public function mapToORM($user): UserORM {
        $userORM = $this->userORM ?? new UserORM();

        $userORM->setId($user->getId());
        $userORM->setIsActive($user->isActive());
        $userORM->setName($user->getName());
        $userORM->setSurname($user->getSurname());
        $userORM->setEmail($user->getEmail());
        $userORM->setPhone($user->getPhone());
        $userORM->setPassword($user->getPassword());

        if ($this->userORM !== null) {
            $userORM->setUpdatedAt(time());
            $userORM->setAccount($this->findAccountById($user->getAccountId()->toScalar()));
        } else {
            $accountORM = new AccountORM();
            $accountORM->setId($user->getAccountId()->toScalar());
            $accountORM->setType($user->getType()->value);
            $accountORM->setCreatedAt(time());

            $userORM->setAccount($accountORM);
            $userORM->setId($user->getId()->toScalar());
            $userORM->setRole($user->getRole()->value);
            $userORM->setCreatedAt(time());
        }

        return $userORM;
    }

    private function findAccountById(string $id): AccountORM {
        return $this->em->getRepository(AccountORM::class)->findOneBy(['id' => $id]);
    }

    /** @param UserORM $userORM */
    public function mapToDomain($userORM): User {
        $this->userORM = $userORM;

        $account = new Account(
            new AccountId($userORM->getAccount()->getId()),
            TypesEnum::from($userORM->getAccount()->getType()),
        );

        return new User(
            new UserId($userORM->getId()),
            $account,
            $userORM->getIsActive(),
            $userORM->getName(),
            $userORM->getSurname(),
            $userORM->getEmail(),
            $userORM->getPhone(),
            $userORM->getPassword(),
            RolesEnum::from($userORM->getRole()),
        );
    }
}