<?php

namespace Accel\App\Core\Component\Request\Application\Service;

use Accel\App\Core\Component\Request\Application\DTO\CreateChangeInvestorRequisitesRequestDTO;
use Accel\App\Core\Component\Request\Application\DTO\CreateChangeProjectBusinessDataRequestDTO;
use Accel\App\Core\Component\Request\Application\DTO\CreateRegisterInvestorRequestDTO;
use Accel\App\Core\Component\Request\Application\DTO\CreateRegisterProjectRequestDTO;
use Accel\App\Core\Component\Request\Application\Repository\RequestRepository;
use Accel\App\Core\Component\Request\Domain\Request\CanAcceptOnce;
use Accel\App\Core\Component\Request\Domain\Request\ChangeInvestorRequisitesRequest;
use Accel\App\Core\Component\Request\Domain\Request\ChangeProjectBusinessDataRequest;
use Accel\App\Core\Component\Request\Domain\Request\RegisterInvestorRequest;
use Accel\App\Core\Component\Request\Domain\Request\RegisterProjectRequest;
use Accel\App\Core\Component\Request\Domain\Request\RejectReasonsEnum;
use Accel\App\Core\Component\Request\Domain\Request\RequestContentInterface;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;

class RequestService
{
    public function __construct(
        private readonly RequestRepository $requestRepository,
    ) {}

    public function createRegisterProjectRequest(CreateRegisterProjectRequestDTO $DTO): void {
        $request = RegisterProjectRequest::create(
            $DTO->getCreator(),
            $DTO->getCreatorComment(),
            $DTO->getProjectName(),
            $DTO->getProjectDescription(),
            $DTO->getProjectBusinessPlan(),
            $DTO->getProjectRequiredInvestmentMin(),
            $DTO->getProjectRequiredInvestmentMax(),
            $DTO->getProjectTags(),
        );

        $this->requestRepository->add($request);
    }

    public function createChangeProjectBusinessDataRequest(CreateChangeProjectBusinessDataRequestDTO $DTO): void {
        $request = ChangeProjectBusinessDataRequest::create(
            $DTO->getProjectId(),
            $DTO->getCreator(),
            $DTO->getCreatorComment(),
            $DTO->getProjectBusinessPlan(),
            $DTO->getProjectRequiredInvestmentMin(),
            $DTO->getProjectRequiredInvestmentMax(),
            $DTO->getProjectTags(),
        );

        $this->requestRepository->add($request);
    }

    public function createRegisterInvestorRequest(CreateRegisterInvestorRequestDTO $DTO): void {
        $request = RegisterInvestorRequest::create(
            $DTO->getCreator(),
            $DTO->getCreatorComment(),
            $DTO->getInvestorType(),
            $DTO->getInvestorName(),
            $DTO->getInvestorDescription(),
            $DTO->getInvestorRequisites(),
            $DTO->getInvestorInterests(),
        );

        $this->requestRepository->add($request);
    }

    public function createChangeInvestorRequisitesRequest(CreateChangeInvestorRequisitesRequestDTO $DTO): void {
        $request = ChangeInvestorRequisitesRequest::create(
            $DTO->getInvestorId(),
            $DTO->getCreator(),
            $DTO->getCreatorComment(),
            $DTO->getInvestorType(),
            $DTO->getInvestorRequisites(),
        );

        $this->requestRepository->add($request);
    }

    /** @throws CanAcceptOnce */
    public function acceptAndReturnRequestContent(RequestId $requestId, UserId $moderator): RequestContentInterface {
        $request = $this->requestRepository->findById($requestId);

        $request->accept($moderator);

        $this->requestRepository->add($request);

        return $request->getContent();
    }

    public function reject(RequestId $requestId, UserId $moderator, string $rejectReason, ?string $rejectMessage): void {
        $request = $this->requestRepository->findById($requestId);

        $request->reject(
            $moderator,
            RejectReasonsEnum::from($rejectReason),
            $rejectMessage,
        );

        $this->requestRepository->add($request);
    }
}