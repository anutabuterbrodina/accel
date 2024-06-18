<?php

namespace Accel\App\Core\Component\User\Application\Query;

use Accel\App\Core\Component\User\Domain\User\User;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Component\User\UserId;

class UserListQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    /** @param UserId[] $userIdsList */
    public function execute(array $userIdsList): ResultCollection {
        $userIds = [];
        foreach ($userIdsList as $id) {
            $userIds[] = $id->toScalar();
        }

        $queryWrapper = $this->queryBuilder->create(User::class, 'User')
            ->select(
                'User.id',
                'User.name',
                'User.surname',
                'User.email',
                'User.phone',
                'User.phone',
                'Account.type',
            )
            ->innerJoin('User.account', 'Account')
            ->where('User.isActive = 1')
            ->andWhere('User.id IN (:userIds)')
            ->setParameter('userIds', $userIds)
            ->build();

        return $this->queryService->query($queryWrapper);
    }
}