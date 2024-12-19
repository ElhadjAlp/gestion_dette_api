<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    // Méthodes personnalisées (par exemple, trouver tous les paiements par dette)
    public function findByDette($detteId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.yes = :detteId')
            ->setParameter('detteId', $detteId)
            ->getQuery()
            ->getResult();
    }
}

