<?php

namespace App\Repository;

use App\Entity\Detail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Detail>
 */
class DetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Detail::class);
    }

    /**
     * Récupérer tous les détails.
     *
     * @return Detail[]
     */
    public function findAllDetails(): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupérer un détail par son ID.
     *
     * @param int $id
     * @return Detail|null
     */
    public function findDetailById(int $id): ?Detail
    {
        return $this->find($id);
    }

    /**
     * Enregistrer ou mettre à jour un détail.
     *
     * @param Detail $detail
     * @return void
     */
    public function save(Detail $detail): void
    {
        $this->_em->persist($detail);
        $this->_em->flush();
    }

    /**
     * Supprimer un détail.
     *
     * @param Detail $detail
     * @return void
     */
    public function delete(Detail $detail): void
    {
        $this->_em->remove($detail);
        $this->_em->flush();
    }
}
