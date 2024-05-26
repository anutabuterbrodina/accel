<?php

namespace App\Core\Component\Request\Application\Service;

use App\Core\Component\Request\Application\Repository\DQL\RequestRepository;
use App\Core\SharedKernel\Component\Request\RequestId;

class RequestService
{
    public function __construct(
        private readonly RequestRepository $requestRepository,
    ) {}

    public function create(): void {
        $request = "Re";
    }

    public function acceptAndReturnRequestContent(RequestId $requestId): array {
        $request = $this->requestRepository->findById( $requestId );

        $request->accept();

        $this->requestRepository->add($request);

        return $request->getContent();
    }

    public function reject(RequestId $requestId, int $rejectReasonCode, string $rejectMessage): void {
        $request = $this->requestRepository->findById( $requestId );

        $request->reject(
            $rejectReasonCode,
            $rejectMessage
        );

        $this->requestRepository->add($request);
    }
}