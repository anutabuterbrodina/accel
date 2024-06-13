<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Investor\Application\DTO\UpdateInvestorDescriptionDataDTO;
use Accel\App\Core\Component\Investor\Application\Query\InvestorQuery;
use Accel\App\Core\Component\Investor\Application\Service\InvestorService;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Investor\InvestorId;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Presentation\Controller\DTO\InvestorDTO;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/investor')]
class InvestorController
{
    public function __construct(
        private readonly InvestorQuery   $investorQuery,
        private readonly InvestorService $investorService,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        $investorDTO = $this->investorQuery
            ->execute(new InvestorId($request->getQueryParams()['investorId']))
            ->hydrateSingleResultAs(InvestorDTO::class);

        return new JsonResponse($investorDTO);
    }

    #[Route('/edit-description-data', methods: ['POST'])]
    public function updateCommonData(ServerRequestInterface $request): Response {
        $this->investorService->updateDescriptionData(new UpdateInvestorDescriptionDataDTO(
            new InvestorId($request->getParsedBody()['investorId']),
            $request->getParsedBody()['name'],
            $request->getParsedBody()['description'],
        ));

        return new Response('Описание инвестора успешно обновлено');
    }

    #[Route('/edit-interests', methods: ['POST'])]
    public function updateInterests(ServerRequestInterface $request): Response {
        $interestsList = [];
        foreach ($request->getParsedBody()['interests'] as $interest) {
            $interestsList[] = Tag::of($interest);
        }

        $this->investorService->updateInterests(
            new InvestorId($request->getParsedBody()['investorId']),
            $interestsList,
        );

        return new Response('Категории интересов инвестора успешно обновлены');
    }

    #[Route('/deactivate', methods: ['POST'])]
    public function deactivate(ServerRequestInterface $request): Response {
        $this->investorService->deactivate(
            new InvestorId($request->getParsedBody()['investorId']),
        );

        return new Response('Инвестор переведен в статус неактивного');
    }

    #[Route('/activate', methods: ['POST'])]
    public function activate(ServerRequestInterface $request): Response {
        $this->investorService->activate(
            new InvestorId($request->getParsedBody()['investorId']),
        );

        return new Response('Инвестор переведен в статус активного');
    }

    #[Route('/add-member', methods: ['POST'])]
    public function addMember(ServerRequestInterface $request): Response {
        $this->investorService->addMember(
            new InvestorId($request->getParsedBody()['investorId']),
            new UserId($request->getParsedBody()['userId']),
        );

        return new Response('Представитель инвестора успешно добавлен');
    }

    #[Route('/remove-member', methods: ['POST'])]
    public function removeMember(ServerRequestInterface $request): Response {
        $this->investorService->removeMember(
            new InvestorId($request->getParsedBody()['investorId']),
            new UserId($request->getParsedBody()['userId']),
        );

        return new Response('Представитель инвестора успешно удален');
    }
}