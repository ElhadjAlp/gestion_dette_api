<?php
namespace App\Repository;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findByLibelle(string $libelle): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.libelle LIKE :libelle')
            ->setParameter('libelle', '%' . $libelle . '%')
            ->getQuery()
            ->getResult();
    }

    public function findByReference(string $reference): ?Article
    {
        return $this->createQueryBuilder('a')
            ->where('a.reference = :reference')
            ->setParameter('reference', $reference)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findArticlesBelowStock(int $threshold): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.qteStock < :threshold')
            ->setParameter('threshold', $threshold)
            ->getQuery()
            ->getResult();
    }

    public function findArticlesAbovePrice(float $price): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix > :price')
            ->setParameter('price', $price)
            ->getQuery()
            ->getResult();
    }

    public function countArticlesInStock(): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.qteStock > 0')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findLatestArticles(int $limit): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByPriceAndStock(float $prix, int $qteStock): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix = :prix')
            ->andWhere('a.qteStock = :qteStock')
            ->setParameter('prix', $prix)
            ->setParameter('qteStock', $qteStock)
            ->getQuery()
            ->getResult();
    }
    public function findAll(): array
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
    }
}
