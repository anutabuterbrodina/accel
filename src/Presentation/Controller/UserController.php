<?php

namespace Accel\App\Presentation\Controller;

use Accel\App\Core\Component\User\Application\DTO\UpdateProfileDataDTO;
use Accel\App\Core\Component\User\Application\Query\UserQuery;
use Accel\App\Core\Component\User\Application\Repository\UserRepository;
use Accel\App\Core\Component\User\Application\Service\UserService;
use Accel\App\Core\SharedKernel\Component\User\UserId;
use Accel\App\Presentation\Controller\DTO\UserDTO;
use Accel\Extension\Helpers\JWTHelper;
use Accel\Extension\Helpers\Payload;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/user')]
class UserController
{
    public function __construct(
        private readonly UserService    $userService,
        private readonly UserRepository $userRepository,
        private readonly UserQuery      $userQuery,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function get(ServerRequestInterface $request): Response {
        $userId = new UserId(
            $request->getQueryParams()['userId']
        );
        // TODO: Fetch from auth headers

        $userDTO = $this->userQuery
            ->execute($userId)
            ->hydrateSingleResultAs(UserDTO::class);

        return new JsonResponse($userDTO);
    }

    #[Route('/edit-profile-data', methods: ['POST'])]
    public function updateProfileData(ServerRequestInterface $request): Response {
        $userId = new UserId(
            $request->getQueryParams()['userId']
        );
        // TODO: Fetch from auth headers

        $this->userService->updateProfileData(new UpdateProfileDataDTO(
            $userId,
            $request->getParsedBody()['name'],
            $request->getParsedBody()['surname'],
            $request->getParsedBody()['email'],
            $request->getParsedBody()['phone'],
        ));

        return new Response('Данные пользователя успешно обновлены');
    }

    #[Route('/reset-password', methods: ['POST'])]
    public function updatePassword(ServerRequestInterface $request): Response {
        $userId = new UserId(
            $request->getQueryParams()['userId']
        );
        // TODO: Fetch from auth headers

        $this->userService->updatePassword(
            $userId,
            password_hash($request->getParsedBody()['currentPassword'], PASSWORD_DEFAULT),
            password_hash($request->getParsedBody()['newPassword'], PASSWORD_DEFAULT),
        );

        return new Response('Данные пользователя успешно обновлены');
    }

    #[Route('/deactivate', methods: ['POST'])]
    public function deactivate(ServerRequestInterface $request): Response {
        $userId = new UserId(
            $request->getParsedBody()['userId']
        );

        $this->userService->deactivate($userId);

        return new Response('Пользователя успешно деактивирован');
    }

    #[Route('/activate', methods: ['POST'])]
    public function activate(ServerRequestInterface $request): Response {
        $userId = new UserId(
            $request->getParsedBody()['userId']
        );

        $this->userService->activate($userId);

        return new Response('Пользователя успешно активирован');
    }

    // TODO: Переместить в AuthService
    #[Route('/login', methods: ['POST'])]
    public function login(ServerRequestInterface $request): Response {
        $email = $request->getParsedBody()['email'];
//        $password = password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT);
        $password = $request->getParsedBody()['password'];
        $user = $this->userRepository->findByEmail($email);

        if ($password !== $user->getPassword()) {
            throw new \Exception('Неверный email или пароль');
        }

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