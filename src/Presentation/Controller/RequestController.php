<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Investor\Application\DTO\CreateInvestorDTO;
use Accel\App\Core\Component\Investor\Application\Service\InvestorService;
use Accel\App\Core\Component\Project\Application\DTO\CreateProjectDTO;
use Accel\App\Core\Component\Project\Application\DTO\UpdateProjectBusinessDataDTO;
use Accel\App\Core\Component\Project\Application\Service\ProjectService;
use Accel\App\Core\Component\Request\Application\Query\RequestQuery;
use Accel\App\Core\Component\Request\Application\Service\RequestService;
use Accel\App\Core\Component\Request\Domain\Request\ChangeInvestorRequisitesRequestContent;
use Accel\App\Core\Component\Request\Domain\Request\ChangeProjectBusinessDataRequestContent;
use Accel\App\Core\Component\Request\Domain\Request\RegisterInvestorRequestContent;
use Accel\App\Core\Component\Request\Domain\Request\RegisterProjectRequestContent;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Core\SharedKernel\Component\Request\RequestId;
use Accel\App\Presentation\Controller\DTO\RequestDTO;
use Accel\Extension\Helpers\TypeHelper;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/request')]
class RequestController
{
    public function __construct(
        private readonly RequestQuery $requestQuery,
        private readonly RequestService $requestService,
        private readonly ProjectService $projectService,
        private readonly InvestorService $investorService,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        $requestDTO = $this->requestQuery
            ->execute(new RequestId($request->getQueryParams()['requestId']))
            ->hydrateSingleResultAs(RequestDTO::class);

        return new JsonResponse($requestDTO);
    }

    #[Route('/accept', methods: ['POST'])]
    public function accept(ServerRequestInterface $request): Response {
        $userId = new UserId(
            $request->getParsedBody()['userId']
        );
        // TODO: Fetch from auth headers
        // TODO: Сделать проверку на роль модератора пользователя

        $content = $this->requestService->acceptAndReturnRequestContent(
            new RequestId($request->getParsedBody()['requestId']),
            new UserId($userId)
        );

        // TODO: Перевести на EventSourcing

        $type = TypeHelper::getType($content);
        switch ($type) {
            case RegisterProjectRequestContent::class: {
                /** @var RegisterProjectRequestContent $content */
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

                return new Response('Заявка принята. Проект успешно создан');
            }

            case RegisterInvestorRequestContent::class: {
                /** @var RegisterInvestorRequestContent $content */
                $this->investorService->create(new CreateInvestorDTO(
                    $content->getInvestorId(),
                    $content->getInvestorCreator(),
                    $content->getInvestorName(),
                    $content->getInvestorDescription(),
                    $content->getInvestorType(),
                    $content->getInvestorRequisites(),
                    $content->getInvestorInterests(),
                ));

                return new Response('Заявка принята. Инвестор успешно зарегистрирован');
            }

            case ChangeProjectBusinessDataRequestContent::class: {
                /** @var ChangeProjectBusinessDataRequestContent $content */
                $this->projectService->updateBusinessData(new UpdateProjectBusinessDataDTO(
                    $content->getProjectId(),
                    $content->getProjectBusinessPlan(),
                    $content->getProjectRequiredInvestmentMin(),
                    $content->getProjectRequiredInvestmentMax(),
                    $content->getProjectTags(),
                ));

                return new Response('Заявка принята. Проект успешно создан');
            }

            case ChangeInvestorRequisitesRequestContent::class: {
                /** @var ChangeInvestorRequisitesRequestContent $content */
                $this->investorService->updateRequisites(
                    $content->getInvestorId(),
                    $content->getInvestorRequisites(),
                    $content->getInvestorType(),
                );

                return new Response('Заявка принята. Проект успешно создан');
            }

            default:
                return new Response('Не удалось принять заявку. Неизвестный тип контента заявки: ' . $type);
        }
    }

    #[Route('/reject', methods: ['POST'])]
    public function reject(ServerRequestInterface $request) {
        $userId = new UserId(
            $request->getParsedBody()['userId']
        );
        // TODO: Fetch from auth headers
        // TODO: Сделать проверку на роль модератора пользователя

        $this->requestService->reject(
            new RequestId($request->getParsedBody()['requestId']),
            $userId,
            $request->getParsedBody()['rejectReason'],
            $request->getParsedBody()['rejectMessage'],
        );

    }
}