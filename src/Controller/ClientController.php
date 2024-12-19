<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/client', name: 'client_')]
class ClientController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(ClientRepository $clientRepository): JsonResponse
    {
        $clients = $clientRepository->findAll();

        return $this->json($clients, Response::HTTP_OK, [], ['groups' => 'client:read']);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Client $client): JsonResponse
    {
        return $this->json($client, Response::HTTP_OK, [], ['groups' => 'client:read']);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client = new Client();
        $client->setSurname($data['surname'] ?? null);
        $client->setTelephone($data['telephone'] ?? null);
        $client->setAdresse($data['adresse'] ?? null);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $this->json($client, Response::HTTP_CREATED, [], ['groups' => 'client:read']);
    }

    #[Route('/update/{id}', name: 'update', methods: ['PUT', 'PATCH'])]
    public function update(Request $request, Client $client): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client->setSurname($data['surname'] ?? $client->getSurname());
        $client->setTelephone($data['telephone'] ?? $client->getTelephone());
        $client->setAdresse($data['adresse'] ?? $client->getAdresse());

        $this->entityManager->flush();

        return $this->json($client, Response::HTTP_OK, [], ['groups' => 'client:read']);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Client $client): JsonResponse
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();

        return $this->json(['message' => 'Client deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
