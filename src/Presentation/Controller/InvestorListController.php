<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Investor\Application\DTO\InvestorListFiltersDTO;
use Accel\App\Core\Component\Investor\Application\DTO\investorListSortOptionsEnum;
use Accel\App\Core\Component\Investor\Application\Query\InvestorListQuery;
use Accel\App\Core\SharedKernel\Common\SortOrderEnum;
use Accel\App\Presentation\Controller\DTO\InvestorListItemDTO;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/investors', methods: ['GET'])]
class InvestorListController
{
    public function __construct(
        private readonly InvestorListQuery $projectListQuery,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response
    {
        $queryParams = $request->getQueryParams();
        $userId = $queryParams['userId'] ?? null;

        $filters = new InvestorListFiltersDTO(
            $queryParams['limit'] ?? null,
            $queryParams['tags'] ?? null,
            $queryParams['types'] ?? null,
            $queryParams['nameSearchString'] ?? null,
            isset($queryParams['sortOption']) ? InvestorListSortOptionsEnum::from($queryParams['sortOption']) : null,
            isset($queryParams['sortOrder']) ? SortOrderEnum::from($queryParams['sortOrder']) : null,
        );

        $projectDTOList = $this->projectListQuery->execute($filters, $userId)
            ->hydrateResultItemsAs(InvestorListItemDTO::class);

        return new JsonResponse($projectDTOList);
    }
}