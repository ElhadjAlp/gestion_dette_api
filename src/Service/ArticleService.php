<?php
namespace App\Service;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticleService
{
    private ArticleRepository $articleRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $this->articleRepository = $articleRepository;
        $this->entityManager = $entityManager;
    }

    public function findArticlesByLibelle(string $libelle): array
    {
        return $this->articleRepository->findByLibelle($libelle);
    }

    public function findArticleByReference(string $reference): ?Article
    {
        return $this->articleRepository->findByReference($reference);
    }

    public function findArticlesBelowStock(int $threshold): array
    {
        return $this->articleRepository->findArticlesBelowStock($threshold);
    }

    public function findArticlesAbovePrice(float $price): array
    {
        return $this->articleRepository->findArticlesAbovePrice($price);
    }

    public function countArticlesInStock(): int
    {
        return $this->articleRepository->countArticlesInStock();
    }

    public function findLatestArticles(int $limit): array
    {
        return $this->articleRepository->findLatestArticles($limit);
    }

    public function findArticlesByPriceAndStock(float $prix, int $qteStock): array
    {
        return $this->articleRepository->findByPriceAndStock($prix, $qteStock);
    }

    // Méthode ajoutée pour récupérer tous les articles
    public function getAllArticles(): array
    {
        return $this->articleRepository->findAll();
    }

    // D'autres méthodes CRUD comme créer, mettre à jour, supprimer, etc. peuvent être ajoutées ici
}
