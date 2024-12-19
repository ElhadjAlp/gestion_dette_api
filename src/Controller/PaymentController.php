<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @Route("/api/payments", methods={"GET"})
     */
    public function getAllPayments(): JsonResponse
    {
        // Récupérer tous les paiements
        $payments = $this->paymentService->getAllPayments();

        // Retourner la liste des paiements en JSON
        return new JsonResponse($payments, 200);
    }

    /**
     * @Route("/api/payments/{detteId}", methods={"GET"})
     */
    public function getPaymentsByDette(int $detteId): JsonResponse
    {
        $payments = $this->paymentService->getPaymentsByDette($detteId);

        return new JsonResponse($payments, 200);
    }

    /**
     * @Route("/api/payments", methods={"POST"})
     */
    public function createPayment(Request $request): JsonResponse
    {
        $paymentDTO = $this->serializer->deserialize($request->getContent(), PaymentDTO::class, 'json');

        // Récupérer la dette associée à partir de l'ID
        $detteId = $paymentDTO->getDetteId();
        $dette = $this->getDoctrine()->getRepository(Dette::class)->find($detteId);

        if (!$dette) {
            return new JsonResponse(['error' => 'Dette not found'], 404);
        }

        $payment = new Payment();
        $payment->setMontant($paymentDTO->getMontant());
        $payment->setDate($paymentDTO->getDate());
        $payment->setYes($dette);  // Associer la dette au paiement

        $this->paymentService->addPayment($payment);

        return new JsonResponse(['status' => 'Payment added'], 201);
    }
}
