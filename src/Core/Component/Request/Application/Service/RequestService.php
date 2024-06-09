<?php

namespace Accel\App\Core\Component\Request\Application\Service;

use Accel\App\Core\Component\Request\Application\DTO\CreateRegisterProjectRequestDTO;
use Accel\App\Core\Component\Request\Application\Repository\DQL\RequestRepository;
use Accel\App\Core\Component\Request\Domain\Request\RegisterProjectRequest;
use Accel\App\Core\Component\Request\Domain\Request\RejectReasonsEnum;
use Accel\App\Core\Component\Request\Domain\Request\RequestContentInterface;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
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

    public function acceptAndReturnRequestContent(RequestId $requestId, UserId $moderator): RequestContentInterface {
        $request = $this->requestRepository->findById($requestId);

        $request->accept($moderator);

        $this->requestRepository->add($request);

        return $request->getContent();
    }

    public function reject(RequestId $requestId, string $rejectReason, string $rejectMessage): void {
        $request = $this->requestRepository->findById( $requestId );

        $request->reject(
            RejectReasonsEnum::from($rejectReason),
            $rejectMessage,
        );

        $this->requestRepository->add($request);
    }
}