<?php

namespace App\Infrastructure\Controller;

use App\Core\Component\Project\Application\DTO\CreateProjectDTO;
use App\Core\Component\Project\Application\Service\ProjectService;
use App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use App\Core\SharedKernel\Common\ValueObject\FileObject;
use App\Core\SharedKernel\Common\ValueObject\Tag;
use App\Core\SharedKernel\Component\Auth\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectListController extends AbstractController
{
    public function __construct(
//        private readonly AuthenticationService $authenticationService,
        private readonly ProjectService        $projectService,
    ) {}

    public function get($query): Response
    {
//        $postDtoList = $postListQuery->execute($this->authenticationService->getLoggedInUserId())
//            ->hydrateResultItemsAs(PostDto::class);
        return new JsonResponse();
    }

    #[Route('/projects/new', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $payload = $request->getPayload();
//        $userId = $this->authenticationService->getCurrentUserId();

//        $businessPlan = BusinessPlan::of(FileUploader::load( $request->files )->getPath());
        $businessPlanPath = '/v01/business-plan_cklshlks.pdf';

        $tagList = [];
        foreach (json_decode($payload->get( 'tags' )) as $tagName) {
            $tagList[] = Tag::of( $tagName );
        }

        $this->projectService->create( new CreateProjectDTO(
            new UserId(),
            $payload->get( 'name' ),
            $payload->get( 'description' ),
            FileObject::of( $businessPlanPath ),
            InvestmentRangeEnum::from( $payload->get( 'investmentMin' ) ),
            InvestmentRangeEnum::from( $payload->get( 'investmentMax' ) ),
            $tagList,
        ) );

        return new JsonResponse();
    }
}