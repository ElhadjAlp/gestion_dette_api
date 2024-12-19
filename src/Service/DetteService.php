<?php
namespace App\Service;

use App\Repository\DetteRepository;
use App\Entity\Dette;
use App\Entity\Client;

class DetteService
{
    private DetteRepository $detteRepository;

    public function __construct(DetteRepository $detteRepository)
    {
        $this->detteRepository = $detteRepository;
    }

    // Récupérer toutes les dettes d'un client spécifique
    public function getDettesByClient(Client $client): array
    {
        return $this->detteRepository->findByClient($client);
    }

    // Vérifier si une dette est entièrement payée
    public function isDebtFullyPaid(Dette $dette): bool
    {
        return $this->detteRepository->isFullyPaid($dette);
    }

    // Récupérer toutes les dettes impayées
    public function getUnpaidDettes(): array
    {
        return $this->detteRepository->findUnpaidDettes();
    }

    // Récupérer les dettes dans une période spécifique
    public function getDettesByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
    {
        return $this->detteRepository->findDettesByDateRange($startDate, $endDate);
    }

    // Récupérer les dettes impayées d'un client spécifique
    public function getUnpaidDettesByClient(Client $client): array
    {
        return $this->detteRepository->findUnpaidDettesByClient($client);
    }

    // Récupérer les dettes payées d'un client spécifique
    public function getPaidDettesByClient(Client $client): array
    {
        return $this->detteRepository->findPaidDettesByClient($client);
    }

    // Récupérer les dettes avec un montant restant supérieur à un seuil
    public function getDettesByRemainingAmount(float $amount): array
    {
        return $this->detteRepository->findDettesByRemainingAmount($amount);
    }
}
