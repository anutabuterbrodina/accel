<?php

namespace App\Infrastructure\Controller;

use App\Core\Component\Project\Application\DTO\CreateProjectDTO;
use App\Core\Component\Request\Application\Service\RequestService;
use App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use App\Core\SharedKernel\Common\ValueObject\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestListController
{
    public function __construct(
        private readonly RequestService $requestService,
    ) {}

    public function create(Request $request): Response
    {
        $userId = $this->authenticationService->getCurrentUserId();

        $this->requestService->create( new CreateProjectDTO(
        ) );

        return new Response();
    }
}