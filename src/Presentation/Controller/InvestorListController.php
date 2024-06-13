<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Investor\Application\DTO\InvestorListFiltersDTO;
use Accel\App\Core\Component\Investor\Application\DTO\InvestorListSortOptionsEnum;
use Accel\App\Core\Component\Investor\Application\Query\InvestorListQuery;
use Accel\App\Core\Component\Investor\Domain\Investor\TypesEnum;
use Accel\App\Core\SharedKernel\Common\SortOrderEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\User\UserId;
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
        private readonly InvestorListQuery $investorListQuery,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        $queryParams = $request->getQueryParams();

        foreach ($queryParams['interests'] ?? [] as $interest) {
            $interestList[] = Tag::of($interest);
        }

        foreach ($queryParams['types'] ?? [] as $type) {
            $typeList[] = TypesEnum::from($type);
        }

        $filters = new InvestorListFiltersDTO(
            $queryParams['limit'] ?? null,
            $interestList ?? null,
            $typeList ?? null,
            isset($queryParams['userId']) ? new UserId($queryParams['userId']) : null,
            $queryParams['nameSearchString'] ?? null,
            isset($queryParams['sortOption']) ? InvestorListSortOptionsEnum::from($queryParams['sortOption']) : null,
            isset($queryParams['sortOrder']) ? SortOrderEnum::from($queryParams['sortOrder']) : null,
        );

        $investorDTOList = $this->investorListQuery->execute($filters)
            ->hydrateResultItemsAs(InvestorListItemDTO::class);

        return new JsonResponse($investorDTOList);
    }
}