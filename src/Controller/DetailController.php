<?php

namespace App\Controller;

use App\Entity\Detail;
use App\Service\DetailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/details', name: 'detail_')]
class DetailController extends AbstractController
{
    private DetailService $detailService;

    public function __construct(DetailService $detailService)
    {
        $this->detailService = $detailService;
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $details = $this->detailService->getAllDetails();

        

        return $this->json(
            $details
        );
    }

    /**
     * Récupérer un détail spécifique.
     *
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function getDetail(int $id): JsonResponse
    {
        $detail = $this->detailService->getDetailById($id);

        if (!$detail) {
            return $this->json(['error' => 'Detail not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(
            $detail,
            Response::HTTP_OK,
            [],
            ['groups' => 'detail:read']
        );
    }

    /**
     * Créer un nouveau détail.
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        // Décoder le contenu JSON
        $data = json_decode($request->getContent(), true);

        // Vérification de la validité du JSON
        if (!is_array($data)) {
            return $this->json(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        }

        // Vérification des champs nécessaires
        $requiredFields = ['prixVente', 'qteVendu', 'articleId', 'detteId'];
        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $data)) {
                return $this->json(['error' => "Missing field: $field"], Response::HTTP_BAD_REQUEST);
            }
        }

        try {
            // Appeler le service pour créer un détail
            $detail = $this->detailService->createDetail($data);

            return $this->json(
                $detail,
                Response::HTTP_CREATED,
                [],
                ['groups' => 'detail:read']
            );
        } catch (\InvalidArgumentException $e) {
            // Gestion des exceptions spécifiques
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Gestion des exceptions génériques
            return $this->json(['error' => 'An error occurred'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
