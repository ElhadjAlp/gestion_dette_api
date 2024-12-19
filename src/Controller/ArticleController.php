<?php
namespace App\Controller;

use App\DTO\ArticleDTO;
use App\Service\ArticleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    #[Route('', name: 'get_articles', methods: ['GET'])]
    public function getArticles(): JsonResponse
    {
        $articles = $this->articleService->getAllArticles();

        $articleDTOs = array_map(fn($article) => ArticleDTO::fromEntity($article), $articles);

        return new JsonResponse($articleDTOs);
    }

    #[Route('/{id}', name: 'get_article_by_id', methods: ['GET'])]
    public function getArticleById(int $id): JsonResponse
    {
        $article = $this->articleService->getArticleById($id);

        if (!$article) {
            return new JsonResponse(['error' => 'Article not found'], 404);
        }

        $dto = ArticleDTO::fromEntity($article);

        return new JsonResponse($dto);
    }

    #[Route('', name: 'create_article', methods: ['POST'])]
    public function createArticle(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $libelle = $data['libelle'] ?? null;
        $reference = $data['reference'] ?? null;
        $qteStock = $data['qteStock'] ?? null;
        $prix = $data['prix'] ?? null;

        if (!$libelle || !$reference || !$qteStock || !$prix) {
            return new JsonResponse(['error' => 'Libelle, reference, qteStock, and prix are required'], 400);
        }

        $article = $this->articleService->createArticle($libelle, $reference, $qteStock, $prix);

        return new JsonResponse(ArticleDTO::fromEntity($article), 201);
    }
}
