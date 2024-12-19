<?php

namespace App\Repository;

use App\Entity\Dette;
use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dette>
 *
 * @method Dette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dette[]    findAll()
 * @method Dette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dette::class);
    }

    // Exemple des méthodes supplémentaires mentionnées plus haut

    public function findByClient(Client $client): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.client = :client')
            ->setParameter('client', $client)
            ->orderBy('d.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function isFullyPaid(Dette $dette): bool
    {
        return $dette->getMontant() <= $dette->getMontantVerser();
    }

    public function findUnpaidDettes(): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.montantRestant > 0')
            ->orderBy('d.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findDettesByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.date BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('d.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findUnpaidDettesByClient(Client $client): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.client = :client')
            ->andWhere('d.montantRestant > 0')
            ->setParameter('client', $client)
            ->orderBy('d.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findPaidDettesByClient(Client $client): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.client = :client')
            ->andWhere('d.montantRestant = 0')
            ->setParameter('client', $client)
            ->orderBy('d.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findDettesByRemainingAmount(float $amount): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.montantRestant > :amount')
            ->setParameter('amount', $amount)
            ->orderBy('d.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

