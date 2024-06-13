<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Project\Application\DTO\UpdateProjectCommonDataDTO;
use Accel\App\Core\Component\Project\Application\Query\ProjectQuery;
use Accel\App\Core\Component\Project\Application\Service\ProjectService;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Presentation\Controller\DTO\ProjectDTO;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/project')]
class ProjectController
{
    public function __construct(
        private readonly ProjectQuery   $projectQuery,
        private readonly ProjectService $projectService,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        $projectDTO = $this->projectQuery
            ->execute(new ProjectId($request->getQueryParams()['projectId']))
            ->hydrateSingleResultAs(ProjectDTO::class);

        return new JsonResponse($projectDTO);
    }

    #[Route('/edit-common-data', methods: ['POST'])]
    public function updateCommonData(ServerRequestInterface $request): Response {
        $this->projectService->updateCommonData(new UpdateProjectCommonDataDTO(
            new ProjectId($request->getParsedBody()['projectId']),
            $request->getParsedBody()['name'],
            $request->getParsedBody()['description'],
        ));

        return new Response('Описание проекта успешно обновлено');
    }

    #[Route('/set-status', methods: ['POST'])]
    public function deactivate(ServerRequestInterface $request): Response {
        $this->projectService->updateStatus(
            new ProjectId($request->getParsedBody()['projectId']),
            $request->getParsedBody()['status'],
        );

        return new Response('Статус проекта успешно обновлен');
    }

    #[Route('/set-contact', methods: ['POST'])]
    public function updateContact(ServerRequestInterface $request): Response {
        $this->projectService->updateContact(
            new ProjectId($request->getParsedBody()['projectId']),
            $request->getParsedBody()['status'],
        );

        return new Response('Контактное лицо проекта успешно обновлено');
    }

    #[Route('/add-member', methods: ['POST'])]
    public function addMember(ServerRequestInterface $request): Response {
        $this->projectService->addMember(
            new ProjectId($request->getParsedBody()['projectId']),
            new UserId($request->getParsedBody()['userId']),
        );

        return new Response('Участник проекта успешно добавлен');
    }

    #[Route('/remove-member', methods: ['POST'])]
    public function removeMember(ServerRequestInterface $request): Response {
        $this->projectService->removeMember(
            new ProjectId($request->getParsedBody()['projectId']),
            new UserId($request->getParsedBody()['userId']),
        );

        return new Response('Участник проекта успешно удален');
    }

    #[Route('/archive', methods: ['POST'])]
    public function archive(ServerRequestInterface $request): Response {
        $this->projectService->archive(
            new ProjectId($request->getParsedBody()['projectId']),
        );

        return new Response('Проект успешно архивирован');
    }

    #[Route('/unarchive', methods: ['POST'])]
    public function unarchive(ServerRequestInterface $request): Response {
        $this->projectService->unarchive(
            new ProjectId($request->getParsedBody()['projectId']),
        );

        return new Response('Проект успешно разархивирован');
    }
}
