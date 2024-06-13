<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Project\Application\DTO\ProjectListFiltersDTO;
use Accel\App\Core\Component\Project\Application\DTO\ProjectListSortOptionsEnum;
use Accel\App\Core\Component\Project\Application\Query\ProjectListQuery;
use Accel\App\Core\SharedKernel\Common\SortOrderEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Presentation\Controller\DTO\ProjectListItemDTO;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/projects', methods: ['GET'])]
class ProjectListController
{
    public function __construct(
        private readonly ProjectListQuery $projectListQuery,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        $queryParams = $request->getQueryParams();

        foreach ($queryParams['tags'] ?? [] as $tag) {
            $tagList[] = Tag::of($tag);
        }

        $filters = new ProjectListFiltersDTO(
            $queryParams['limit'] ?? null,
            $tagList ?? null,
            isset($queryParams['userId']) ? new UserId($queryParams['userId']) : null,
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
}