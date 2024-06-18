<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\User\Application\DTO\CreateUserDTO;
use Accel\App\Core\Component\User\Application\Query\UserListQuery;
use Accel\App\Core\Component\User\Application\Service\UserService;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Presentation\Controller\DTO\UserListItemDTO;
use Accel\Extension\Helpers\JWTHelper;
use Accel\Extension\Helpers\Payload;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/users')]
class UserListController
{
    public function __construct(
        private readonly UserService   $userService,
        private readonly UserListQuery $userListQuery,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        // TODO: Добавить фильтры по nameSearchQuery (email, name, surname), по projectId, по investorId + limit = 15

        $queryParams = $request->getQueryParams();

        $userIdsList = [];
        foreach ($queryParams['userIds'] as $id) {
            $userIdsList[] = new UserId($id);
        }

        $userDTOList = $this->userListQuery
            ->execute($userIdsList)
            ->hydrateResultItemsAs(UserListItemDTO::class);

        return new JsonResponse($userDTOList);
    }

    // TODO: Переместить в AuthService
    #[Route('/signup', methods: ['POST'])]
    public function create(ServerRequestInterface $request) {
        $user = $this->userService->createAndReturnUser(new CreateUserDTO(
            $request->getParsedBody()['name'],
            $request->getParsedBody()['surname'],
            $request->getParsedBody()['email'],
            $request->getParsedBody()['phone'],
//            password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT),
            $request->getParsedBody()['password'],
            $request->getParsedBody()['type'],
        ));

        $authToken = JWTHelper::generateJWT(
            new Payload(
                $user->getId()->toScalar(),
                $user->getName(),
                $user->getSurname(),
                $user->getEmail(),
                $user->getPhone(),
            )
        );

        return new JsonResponse([
            "payload" => [
                "id" => $user->getId()->toScalar(),
                "email" => $user->getEmail(),
                "role" => $user->getRole(),
                "type" => $user->getType(),
            ],
            "token" => $authToken
        ]);
    }
}