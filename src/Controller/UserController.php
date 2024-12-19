<?php

namespace App\Controller;

use App\Service\UserService;
use App\DTO\UserDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('', name: 'get_users', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        // Logic to fetch all users can be added here
        return new JsonResponse(['message' => 'Endpoint to fetch users']);
    }

    #[Route('/{email}', name: 'get_user_by_email', methods: ['GET'])]
    public function getUserByEmail(string $email): JsonResponse
    {
        $user = $this->userService->findUserByEmail($email);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $dto = UserDTO::fromEntity($user);

        return new JsonResponse($dto);
    }

    #[Route('', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return new JsonResponse(['error' => 'Email and password are required'], 400);
        }

        $user = $this->userService->createUser($email, $password);

        return new JsonResponse(UserDTO::fromEntity($user), 201);
    }
}
