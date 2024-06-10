<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Request\Application\DTO\CreateRegisterProjectRequestDTO;
use Accel\App\Core\Component\Request\Application\Service\RequestService;
use Accel\App\Core\SharedKernel\Common\Enum\InvestmentRangeEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\FileObject;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/requests')]
class RequestListController extends AbstractController
{
    public function __construct(
        private readonly RequestService $requestService,
    ) {}

    #[Route('/new/register-project', methods: ['POST'])]
    public function create(Request $serverRequest): Response
    {
        $payload = $serverRequest->getPayload();

        // TODO: Использовать authService
        $userId = $payload->get('userId');

//        $businessPlan = BusinessPlan::of(FileUploader::load( $request->files )->getPath());
        $businessPlanPath = '/v01/test.pdf';

        $tagList = [];
        foreach (json_decode($payload->get( 'tags' )) as $tagName) {
            $tagList[] = Tag::of($tagName);
        }

        $this->requestService->createRegisterProjectRequest(new CreateRegisterProjectRequestDTO(
            new UserId($userId),
            $payload->get('comment'),
            $payload->get( 'name' ),
            $payload->get( 'description' ),
            FileObject::of( $businessPlanPath ),
            InvestmentRangeEnum::from( $payload->get( 'investmentMin' ) ),
            InvestmentRangeEnum::from( $payload->get( 'investmentMax' ) ),
            $tagList,
        ));

        return new Response();
    }
}