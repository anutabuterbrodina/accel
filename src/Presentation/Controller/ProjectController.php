<?php

namespace Accel\App\Presentation\Controller;


use Accel\App\Core\Component\Project\Application\DTO\UpdateProjectCommonDataDTO;
use Accel\App\Core\Component\Project\Application\Query\ProjectQuery;
use Accel\App\Core\Component\Project\Application\Repository\ProjectRepository;
use Accel\App\Core\Component\Project\Application\Service\ProjectService;
use Accel\App\Core\SharedKernel\Component\Auth\UserId;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Infrastructure\Auth\AuthService;
use Accel\App\Presentation\Controller\DTO\ProjectDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/project')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectQuery         $projectQuery,
        private readonly ProjectService       $projectService,
    ) {}

    #[Route('/{id}', methods: ['GET'])]
    public function get(Request $request, string $id): Response {
        $projectDTO = $this->projectQuery
            ->withMembers()
            ->withTags()
            ->execute(new ProjectId($id))
            ->hydrateSingleResultAs(ProjectDTO::class);

        return new JsonResponse($projectDTO);
    }

    #[Route('/{projectId}/common-data', methods: ['POST'])]
    public function updateCommonData(Request $request, string $projectId): Response {
        $payload = $request->getPayload();

        $this->projectService->updateCommonData(new UpdateProjectCommonDataDTO(
            new ProjectId($projectId),
            $payload->get('name'),
            $payload->get('description'),
        ));

        return new Response(null, 201);
    }
}
