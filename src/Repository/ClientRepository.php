<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * Trouver un client par son numéro de téléphone.
     *
     * @param string $telephone
     * @return Client|null
     */
    public function findOneByTelephone(string $telephone): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.telephone = :telephone')
            ->setParameter('telephone', $telephone)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Rechercher des clients par une partie du prénom.
     *
     * @param string $surname
     * @return Client[]
     */
    public function searchBySurname(string $surname): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.surname LIKE :surname')
            ->setParameter('surname', '%' . $surname . '%')
            ->orderBy('c.surname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouver tous les clients triés par prénom et numéro de téléphone.
     *
     * @return Client[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.surname', 'ASC')
            ->addOrderBy('c.telephone', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Compter le nombre total de clients.
     *
     * @return int
     */
    public function countClients(): int
    {
        return (int) $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
