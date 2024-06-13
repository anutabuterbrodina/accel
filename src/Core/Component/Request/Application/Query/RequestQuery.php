<?php

namespace Accel\App\Core\Component\Request\Application\Query;

use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\Port\ResultCollection;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;

final class RequestQuery
{
    public function __construct(
        private readonly QueryBuilderInterface $queryBuilder,
        private readonly QueryServiceInterface $queryService,
    ) {}

    public function execute(RequestId $requestId): ResultCollection {
        $this->queryBuilder->create('Request', 'Request')
            ->select(
                'Request.id',
                'Request.status',
                'Request.type',
                'Creator.id as creatorId',
                'Creator.id as contactEmail',
                'Request.creatorComment',
                'Request.rejectReason',
                'Request.rejectMessage',
                'Request.content',
                'Request.createdAt',
                'Project.id as projectId',
                'Investor.id as investorId',
            )
            ->innerJoin('Request.creator', 'Creator')
            ->leftJoin('Request.project', 'Project')
            ->leftJoin('Request.investor', 'Investor')
            ->where('Request.id = :requestId')
            ->setParam('requestId', $requestId->toScalar())
            ->build();

        $queryWrapper = $this->queryBuilder->build();

        return $this->queryService->query($queryWrapper);
    }
}
