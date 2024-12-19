<?php
namespace App\Controller;

use App\Service\DetteService;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DetteController extends AbstractController
{
    private DetteService $detteService;

    public function __construct(DetteService $detteService)
    {
        $this->detteService = $detteService;
    }

    /**
     * @Route("/api/dettes/{clientId}", methods={"GET"})
     */
    public function getDettesByClient(int $clientId): JsonResponse
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($clientId);

        if (!$client) {
            return new JsonResponse(['error' => 'Client not found'], 404);
        }

        $dettes = $this->detteService->getDettesByClient($client);

        return new JsonResponse($dettes, 200);
    }

    /**
     * @Route("/api/dettes/unpaid", methods={"GET"})
     */
    public function getUnpaidDettes(): JsonResponse
    {
        $unpaidDettes = $this->detteService->getUnpaidDettes();
        return new JsonResponse($unpaidDettes, 200);
    }

    /**
     * @Route("/api/dettes/date-range", methods={"GET"})
     */
    public function getDettesByDateRange(Request $request): JsonResponse
    {
        $startDate = new \DateTime($request->query->get('start_date'));
        $endDate = new \DateTime($request->query->get('end_date'));

        $dettes = $this->detteService->getDettesByDateRange($startDate, $endDate);

        return new JsonResponse($dettes, 200);
    }

    /**
     * @Route("/api/dettes/{clientId}/unpaid", methods={"GET"})
     */
    public function getUnpaidDettesByClient(int $clientId): JsonResponse
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($clientId);

        if (!$client) {
            return new JsonResponse(['error' => 'Client not found'], 404);
        }

        $unpaidDettes = $this->detteService->getUnpaidDettesByClient($client);

        return new JsonResponse($unpaidDettes, 200);
    }
}
