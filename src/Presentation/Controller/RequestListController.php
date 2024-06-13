<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Request\Application\DTO\CreateChangeInvestorRequisitesRequestDTO;
use Accel\App\Core\Component\Request\Application\DTO\CreateChangeProjectBusinessDataRequestDTO;
use Accel\App\Core\Component\Request\Application\DTO\CreateRegisterInvestorRequestDTO;
use Accel\App\Core\Component\Request\Application\DTO\CreateRegisterProjectRequestDTO;
use Accel\App\Core\Component\Request\Application\DTO\RequestListFiltersDTO;
use Accel\App\Core\Component\Request\Application\DTO\RequestListSortOptionsEnum;
use Accel\App\Core\Component\Request\Application\Query\RequestListQuery;
use Accel\App\Core\Component\Request\Application\Service\RequestService;
use Accel\App\Core\Component\Request\Domain\Request\StatusesEnum;
use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\SortOrderEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Requisites;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Presentation\Controller\DTO\RequestListItemDTO;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/requests')]
class RequestListController
{
    public function __construct(
        private readonly RequestService   $requestService,
        private readonly RequestListQuery $requestListQuery,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        $queryParams = $request->getQueryParams();

        foreach ($queryParams['statuses'] ?? [] as $status) {
            $statusesList[] = StatusesEnum::from($status);
        }

        $filters = new RequestListFiltersDTO(
            $queryParams['limit'] ?? null,
            $statusesList ?? null,
            isset($queryParams['userId']) ? new UserId($queryParams['userId']) : null,
            isset($queryParams['projectId']) ? new ProjectId($queryParams['projectId']) : null,
            isset($queryParams['investorId']) ? new InvestorId($queryParams['investorId']) : null,
            isset($queryParams['sortOption']) ? RequestListSortOptionsEnum::from($queryParams['sortOption']) : null,
            isset($queryParams['sortOrder']) ? SortOrderEnum::from($queryParams['sortOrder']) : null,
        );

        $requestDTOList = $this->requestListQuery->execute($filters)
            ->hydrateResultItemsAs(RequestListItemDTO::class);

        return new JsonResponse($requestDTOList);
    }

    #[Route('/new/register-project', methods: ['POST'])]
    public function createRegisterProjectRequest(ServerRequestInterface $serverRequest): Response {
        $userId = new UserId(
            $serverRequest->getParsedBody()['userId']
        );

        // TODO: Заменить костыль на обработку файлов
        $businessPlanPath = '/v01/test.pdf';

        $tagsList = [];
        foreach ($serverRequest->getParsedBody()['tags'] as $tagName) {
            $tagsList[] = Tag::of($tagName);
        }

        $this->requestService->createRegisterProjectRequest(
            new CreateRegisterProjectRequestDTO(
                new UserId($userId),
                $serverRequest->getParsedBody()['comment'],
                $serverRequest->getParsedBody()['name'],
                $serverRequest->getParsedBody()['description'],
                FileObject::of($businessPlanPath),
                InvestmentRangeEnum::from($serverRequest->getParsedBody()['investmentMin']),
                InvestmentRangeEnum::from($serverRequest->getParsedBody()['investmentMax']),
                $tagsList
            )
        );

        return new Response('Заявка на создание проекта успешно создана');
    }

    #[Route('/new/edit-project-business-data', methods: ['POST'])]
    public function createChangeProjectBusinessDataRequest(ServerRequestInterface $serverRequest): Response {
        $userId = new UserId(
            $serverRequest->getParsedBody()['userId']
        );

        // TODO: Заменить костыль на обработку файлов
        $businessPlanPath = '/v01/test.pdf';

        $tagsList = [];
        foreach ($serverRequest->getParsedBody()['tags'] as $tagName) {
            $tagsList[] = Tag::of($tagName);
        }
        $this->requestService->createChangeProjectBusinessDataRequest(
            new CreateChangeProjectBusinessDataRequestDTO(
                new ProjectId($serverRequest->getParsedBody()['projectId']),
                new UserId($userId),
                $serverRequest->getParsedBody()['comment'],
                FileObject::of($businessPlanPath),
                InvestmentRangeEnum::from($serverRequest->getParsedBody()['investmentMin']),
                InvestmentRangeEnum::from($serverRequest->getParsedBody()['investmentMax']),
                $tagsList
            )
        );

        return new Response('Заявка на регистрацию инвестора успешно создана');
    }

    #[Route('/new/register-investor', methods: ['POST'])]
    public function createRegisterInvestorRequest(ServerRequestInterface $serverRequest): Response {
        $userId = new UserId(
            $serverRequest->getParsedBody()['userId']
        );

        $tagsList = [];
        foreach ($serverRequest->getParsedBody()['tags'] as $tagName) {
            $tagsList[] = Tag::of($tagName);
        }

        $requisites = new Requisites(
            $serverRequest->getParsedBody()['requisites']['legalName'],
            $serverRequest->getParsedBody()['requisites']['address'],
            $serverRequest->getParsedBody()['requisites']['INN'],
            $serverRequest->getParsedBody()['requisites']['OGRN'],
            $serverRequest->getParsedBody()['requisites']['KPP'],
            $serverRequest->getParsedBody()['requisites']['OKPO'],
            $serverRequest->getParsedBody()['requisites']['BIK'],
        );

        $this->requestService->createRegisterInvestorRequest(
            new CreateRegisterInvestorRequestDTO(
                new UserId($userId),
                $serverRequest->getParsedBody()['comment'],
                $serverRequest->getParsedBody()['investorType'],
                $serverRequest->getParsedBody()['name'],
                $serverRequest->getParsedBody()['description'],
                $requisites,
                $tagsList,
            )
        );

        return new Response('Заявка на регистрацию инвестора успешно создана');
    }

    #[Route('/new/edit-investor-requisites', methods: ['POST'])]
    public function createChangeInvestorRequisitesRequest(ServerRequestInterface $serverRequest): Response {
        $userId = new UserId(
            $serverRequest->getParsedBody()['userId']
        );

        $requisites = new Requisites(
            $serverRequest->getParsedBody()['requisites']['legalName'],
            $serverRequest->getParsedBody()['requisites']['address'],
            $serverRequest->getParsedBody()['requisites']['INN'],
            $serverRequest->getParsedBody()['requisites']['OGRN'],
            $serverRequest->getParsedBody()['requisites']['KPP'],
            $serverRequest->getParsedBody()['requisites']['OKPO'],
            $serverRequest->getParsedBody()['requisites']['BIK'],
        );

        $this->requestService->createChangeInvestorRequisitesRequest(
            new CreateChangeInvestorRequisitesRequestDTO(
                new InvestorId($serverRequest->getParsedBody()['investorId']),
                new UserId($userId),
                $serverRequest->getParsedBody()['comment'],
                $serverRequest->getParsedBody()['investorType'],
                $requisites,
            )
        );

        return new Response('Заявка на регистрацию инвестора успешно создана');
    }
}