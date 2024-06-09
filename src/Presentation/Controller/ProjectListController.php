<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Project\Application\DTO\CreateProjectDTO;
use Accel\App\Core\Component\Project\Application\DTO\ProjectListFiltersDTO;
use Accel\App\Core\Component\Project\Application\DTO\ProjectListSortOptionsEnum;
use Accel\App\Core\Component\Project\Application\Query\ProjectListQuery;
use Accel\App\Core\Component\Project\Application\Query\SortOrderEnum;
use Accel\App\Core\Component\Project\Application\Service\ProjectService;
use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Accel\App\Presentation\Controller\DTO\ProjectListItemDTO;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/projects', methods: ['GET'])]
class ProjectListController
{
    public function __construct(
        private readonly ProjectService   $projectService,
        private readonly ProjectListQuery $projectListQuery,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function getAll(ServerRequestInterface $request): Response
    {
        $queryParams = $request->getQueryParams();

        $filters = new ProjectListFiltersDTO(
            $queryParams['limit'] ?? null,
            $queryParams['tags'] ?? null,
            $queryParams['nameSearchString'] ?? null,
            isset($queryParams['investmentMin']) ? (int) $queryParams['investmentMin'] : null,
            isset($queryParams['investmentMax']) ? (int) $queryParams['investmentMax'] : null,
            isset($queryParams['sortOption']) ? ProjectListSortOptionsEnum::from($queryParams['sortOption']) : null,
            isset($queryParams['sortOrder']) ? SortOrderEnum::from($queryParams['sortOrder']) : null,
        );

        $projectDTOList = $this->projectListQuery->execute($filters)
            ->hydrateResultItemsAs(ProjectListItemDTO::class);

        return new JsonResponse($projectDTOList);
    }

    #[Route('/u/{userId}', methods: ['GET'])]
    public function get(Request $request): Response
    {

        $userId = $payload->get('userId');
        $filter = new ProjectListFiltersDTO(
            $payload->get('limit'),
            $payload->get('tags'),
            $payload->get('nameSearchString'),
            $payload->get('investmentMin'),
            $payload->get('investmentMax'),
            $payload->get('sortOption') ? ProjectListSortOptionsEnum::from($payload->get('sortOption')) : null,
            $payload->get('sortOrder') ? SortOrderEnum::from($payload->get('sortOrder')) : null,
        );

        $projectDTOList = $this->projectListQuery->execute($filter, $userId)
            ->hydrateResultItemsAs(ProjectListItemDTO::class);

        return new JsonResponse($projectDTOList);
    }

    #[Route('/new', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $payload = $request->getPayload();

//        $userId = $this->authenticationService->getCurrentUserId();
        $userId = $payload->get('userId');

//        $businessPlan = BusinessPlan::of(FileUploader::load( $request->files )->getPath());
        $businessPlanPath = '/v01/business-plan_cklshlks.pdf';

        $tagList = [];
        foreach (json_decode($payload->get( 'tags' )) as $tagName) {
            $tagList[] = Tag::of( $tagName );
        }

        $this->projectService->create( new CreateProjectDTO(
            new UserId($userId),
            $payload->get( 'name' ),
            $payload->get( 'description' ),
            FileObject::of( $businessPlanPath ),
            InvestmentRangeEnum::from( $payload->get( 'investmentMin' ) ),
            InvestmentRangeEnum::from( $payload->get( 'investmentMax' ) ),
            $tagList,
        ) );

        return new Response();
    }
}