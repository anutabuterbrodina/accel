<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\Project\Application\DTO\ProjectListFiltersDTO;
use Accel\App\Core\Component\Project\Application\DTO\ProjectListSortOptionsEnum;
use Accel\App\Core\Component\Project\Application\Query\BookmarkListQuery;
use Accel\App\Core\Component\Project\Application\Query\ProjectListQuery;
use Accel\App\Core\Port\EmptyListException;
use Accel\App\Core\SharedKernel\Common\SortOrderEnum;
use Accel\App\Core\SharedKernel\Common\ValueObject\Tag;
use Accel\App\Core\SharedKernel\Component\Project\ProjectId;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Bookmark;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\Project;
use Accel\App\Infrastructure\Persistence\Doctrine\ORMEntity\User;
use Accel\App\Presentation\Controller\DTO\ProjectListItemDTO;
use Doctrine\ORM\EntityManagerInterface;
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
        private readonly BookmarkListQuery $bookmarkListQuery,
        private readonly EntityManagerInterface $em,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        $queryParams = $request->getQueryParams();

        foreach ($queryParams['tags'] ?? [] as $tag) {
            $tagList[] = Tag::of($tag);
        }

        $projectIdsList = [];
        foreach ($queryParams['projectIds'] ?? [] as $projectId) {
            $projectIdsList[] = new ProjectId($projectId);
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

        try {
            $projectDTOList = $this->projectListQuery->execute($filters, $projectIdsList)
                ->hydrateResultItemsAs(ProjectListItemDTO::class);
        } catch (EmptyListException $e) {
            return new Response('По данным критериям ничего не найдено');
        }

        return new JsonResponse($projectDTOList);
    }

    #[Route('/bookmarks', methods: ['GET'])]
    public function bookmarks(ServerRequestInterface $request): Response {
        $queryParams = $request->getQueryParams();
        $userId = isset($queryParams['userId']) ? new UserId($queryParams['userId']) : null;

        $projectBookmarks = $this->bookmarkListQuery->execute($userId)->toArray();

        return new JsonResponse($projectBookmarks);
    }

    #[Route('/add-bookmark', methods: ['POST'])]
    public function addBookmark(ServerRequestInterface $request): Response {
        $userId = isset($request->getParsedBody()['userId']) ? new UserId($request->getParsedBody()['userId']) : null;
        $projectId = isset($request->getParsedBody()['projectId']) ? new ProjectId($request->getParsedBody()['projectId']) : null;

        $bookmark = new Bookmark();
        $project = $this->em->getRepository(Project::class)->find($projectId->toScalar());
        $user = $this->em->getRepository(User::class)->find($userId->toScalar());
        $bookmark->setProject($project);
        $bookmark->setUser($user);
        $this->em->persist($bookmark);
        $this->em->flush();

        return new Response('Закладка создана');
    }
}