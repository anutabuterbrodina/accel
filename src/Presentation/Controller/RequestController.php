<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Investor\Application\Service\InvestorService;
use Accel\App\Core\Component\Project\Application\DTO\CreateProjectDTO;
use Accel\App\Core\Component\Project\Application\Service\ProjectService;
use Accel\App\Core\Component\Request\Application\Service\RequestService;
use Accel\App\Core\Component\Request\Domain\Request\RegisterProjectRequestContent;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;
use Accel\App\Presentation\Controller\DTO\RequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/request')]
class RequestController extends AbstractController
{
    public function __construct(
//        private readonly RequestQuery $requestQuery,
        private readonly RequestService $requestService,
        private readonly ProjectService $projectService,
        private readonly InvestorService $investorService,
    ) {}

    #[Route('/{id}', methods: ['GET'])]
    public function get(Request $serverRequest, string $id): Response {
        $requestDTO = $this->requestQuery
            ->execute(new RequestId($id))
            ->hydrateSingleResultAs(RequestDTO::class);

        return new JsonResponse($requestDTO);
    }

    #[Route('/{requestId}/accept', methods: ['POST'])]
    public function accept(Request $serverRequest, string $requestId) {
        $userId = $serverRequest->getPayload()->get('userId');
        $content = $this->requestService->acceptAndReturnRequestContent(new RequestId($requestId), new UserId($userId));

        // TODO: Перевести на EventSourcing

        if ($content instanceof RegisterProjectRequestContent) {
            $this->projectService->create(new CreateProjectDTO(
                $content->getProjectId(),
                $content->getProjectCreator(),
                $content->getProjectName(),
                $content->getProjectDescription(),
                $content->getProjectBusinessPlan(),
                $content->getProjectRequiredInvestmentMin(),
                $content->getProjectRequiredInvestmentMax(),
                $content->getProjectTags(),
            ));
        }
        return new Response('Success');

//        $this->investorService->create();
    }

    #[Route('/{requestId}/accept', methods: ['POST'])]
    public function reject(Request $serverRequest, string $requestId) {
        $payload = $serverRequest->getPayload();

        $this->requestService->reject($requestId, );

    }
}