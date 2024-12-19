<?php

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClientService
{
    private ClientRepository $clientRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ClientRepository $clientRepository, EntityManagerInterface $entityManager)
    {
        $this->clientRepository = $clientRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Trouver un client par son numéro de téléphone.
     *
     * @param string $telephone
     * @return Client|null
     */
    public function findOneByTelephone(string $telephone): ?Client
    {
        return $this->clientRepository->findOneByTelephone($telephone);
    }

    /**
     * Rechercher des clients par une partie du prénom.
     *
     * @param string $surname
     * @return Client[]
     */
    public function searchBySurname(string $surname): array
    {
        return $this->clientRepository->searchBySurname($surname);
    }

    /**
     * Trouver tous les clients triés par prénom et numéro de téléphone.
     *
     * @return Client[]
     */
    public function findAllOrdered(): array
    {
        return $this->clientRepository->findAllOrdered();
    }

    /**
     * Compter le nombre total de clients.
     *
     * @return int
     */
    public function countClients(): int
    {
        return $this->clientRepository->countClients();
    }

    /**
     * Ajouter un client.
     *
     * @param Client $client
     */
    public function addClient(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    /**
     * Supprimer un client.
     *
     * @param Client $client
     */
    public function removeClient(Client $client): void
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}
