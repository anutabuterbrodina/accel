<?php

namespace Accel\App\Core\Component\Investor\Application\Query;

use Accel\App\Core\Component\Investor\Domain\Investor\Investor;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;

final class InvestorQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    public function execute(InvestorId $investorId): ResultCollection {
        $this->queryBuilder->create(Investor::class, 'Investor')
            ->select(
                'Investor.id',
                'Investor.isActive',
                'Investor.type',
                'Investor.name',
                'Investor.description',
                'Investor.legalName',
                'Investor.address',
                'Investor.inn',
                'Investor.ogrn',
                'Investor.kpp',
                'Investor.okpo',
                'Investor.bik',
                'Investor.createdAt',
                'JSON_ARRAYAGG(Tag.name) AS interests',
                'JSON_ARRAYAGG(Member.id) AS members',
            )
            ->innerJoin('Investor.tags', 'Tag')
            ->innerJoin('Investor.users', 'Member')
            ->where('Investor.id = :investorId')
            ->setParam('investorId', $investorId->toScalar());

        $queryWrapper = $this->queryBuilder->build();

        return $this->queryService->query($queryWrapper);
    }
}
