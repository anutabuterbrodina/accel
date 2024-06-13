<?php

namespace Accel\App\Core\Component\User\Application\Repository;

use Accel\App\Core\Component\User\Domain\User\User;
use Accel\App\Core\Port\Mapper\UserMapperInterface;
use Accel\App\Core\Port\PersistenceServiceInterface;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class UserRepository
{
    public function __construct(
        private readonly QueryBuilderInterface       $queryBuilder,
        private readonly PersistenceServiceInterface $persistenceService,
        private readonly QueryServiceInterface       $queryService,
        private readonly UserMapperInterface         $userMapper,
    ) {}

    public function findById(UserId $id): User {
        $query = $this->queryBuilder->create(User::class, 'User')
            ->where('User.id = :id')
            ->setParameter('id', $id->toScalar())
            ->build();

        return $this->find($query);
    }

    public function findByEmail(string $email): User {
        $query = $this->queryBuilder->create(User::class, 'User')
            ->where('User.email = :email')
            ->setParameter('email', $email)
            ->build();

        return $this->find($query);
    }

    public function findByPhone(string $phone): User {
        $query = $this->queryBuilder->create(User::class, 'User')
            ->where('User.phone = :phone')
            ->setParameter('phone', $phone)
            ->build();

        return $this->find($query);
    }

    public function add(User $user): void {
        $this->persistenceService->upsert($user, $this->userMapper);
    }

    private function find(QueryInterface $query): User {
        /** @var User $entity */
        $entity = $this->queryService
            ->query($query)
            ->mapSingleResultTo(User::class, $this->userMapper);

        return $entity;
    }
}
