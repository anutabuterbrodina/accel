<?php

namespace Accel\App\Core\Component\User\Application\Query;

use Accel\App\Core\Component\User\Domain\User\User;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class UserQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    public function execute(UserId $id): ResultCollection {
        $queryWrapper = $this->queryBuilder->create(User::class, 'User')
            ->select(
                'User.id',
                'User.name',
                'User.surname',
                'User.email',
                'User.phone',
                'User.isActive',
                'User.role',
                'User.createdAt',
                'User.updatedAt',
                'Account.type',
            )
            ->innerJoin('User.account', 'Account')
            ->andWhere('User.id = :id')
            ->setParameter('id', $id->toScalar())
            ->build();

        return $this->queryService->query($queryWrapper);
    }
}