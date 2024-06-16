<?php

namespace Accel\App\Core\Component\Request\Application\Repository;

use Accel\App\Core\Component\Request\Domain\Request\AbstractRequest;
use Accel\App\Core\Component\Request\Domain\Request\ChangeInvestorRequisitesRequest as ChangeInvestorReq;
use Accel\App\Core\Component\Request\Domain\Request\ChangeProjectBusinessDataRequest as ChangeProjectReq;
use Accel\App\Core\Component\Request\Domain\Request\RegisterInvestorRequest as RegisterInvestorReq;
use Accel\App\Core\Component\Request\Domain\Request\RegisterProjectRequest as RegisterProjectReq;
use Accel\App\Core\Component\Request\Domain\Request\RequestInterface;
use Accel\App\Core\Port\Mapper\RequestMapperInterface;
use Accel\App\Core\Port\PersistenceServiceInterface;
use Accel\App\Core\Port\QueryBuilderInterface;
use Accel\App\Core\Port\QueryServiceInterface;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;

class RequestRepository
{
    public function __construct(
        private readonly QueryBuilderInterface        $queryBuilder,
        private readonly PersistenceServiceInterface  $persistenceService,
        private readonly QueryServiceInterface        $queryService,
        private readonly RequestMapperInterface       $requestMapper,
    ) {}

    public function findById(RequestId $id): RegisterProjectReq
                                            | RegisterInvestorReq
                                            | ChangeInvestorReq
                                            | ChangeProjectReq {
        $query = $this->queryBuilder->create('', 'Request')
            ->where('Request.id = :id')
            ->setParameter('id', $id->toScalar())
            ->build();

        /** @var RegisterProjectReq|RegisterInvestorReq|ChangeInvestorReq|ChangeProjectReq $entity */
        $entity = $this->queryService
            ->query($query)
            ->mapSingleResultTo(AbstractRequest::class, $this->requestMapper);

        return $entity;
    }

    public function add(RegisterProjectReq|RegisterInvestorReq|ChangeInvestorReq|ChangeProjectReq $request): void {
        $this->persistenceService->upsert($request, $this->requestMapper);
    }
}