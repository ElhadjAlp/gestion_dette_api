<?php

namespace App\Service;

use App\Entity\Detail;
use App\Repository\ArticleRepository;
use App\Repository\DetailRepository;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\JsonException;

class DetailService
{
    private DetailRepository $detailRepository;
    private ArticleRepository $articleRepository;
    private DetteRepository $detteRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        DetailRepository $detailRepository,
        ArticleRepository $articleRepository,
        DetteRepository $detteRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->detailRepository = $detailRepository;
        $this->articleRepository = $articleRepository;
        $this->detteRepository = $detteRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère tous les détails.
     *
     * @return array
     */
    public function getAllDetails(): array
    {
        return $this->detailRepository->findAllDetails(); // Méthode personnalisée dans le repository
    }

    /**
     * Récupère un détail par son ID.
     *
     * @param int $id
     * @return Detail|null
     */
    public function getDetailById(int $id): ?Detail
    {
        return $this->detailRepository->findDetailById($id); // Méthode personnalisée dans le repository
    }

    /**
     * Crée un nouveau détail à partir des données fournies.
     *
     * @param array $data
     * @return Detail
     * @throws \Exception
     */
    public function createDetail(array $data): Detail
    {
        // Validation des données nécessaires
        $requiredFields = ['prixVente', 'qteVendu', 'articleId', 'detteId'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new JsonException("Missing required field: $field");
            }
        }

        // Récupérer l'article associé
        $article = $this->articleRepository->find($data['articleId']);
        if (!$article) {
            throw new \Exception('Article not found');
        }

        // Récupérer la dette associée
        $dette = $this->detteRepository->find($data['detteId']);
        if (!$dette) {
            throw new \Exception('Dette not found');
        }

        // Création de l'entité Detail
        $detail = new Detail();
        $detail->setPrixVente((float) $data['prixVente']);
        $detail->setQteVendu((int) $data['qteVendu']);
        $detail->setArticle($article);
        $detail->setDette($dette);

        // Sauvegarde en base de données
        $this->entityManager->persist($detail);
        $this->entityManager->flush();

        return $detail;
    }
}
