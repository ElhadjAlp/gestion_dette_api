<?php

namespace App\Service;

use App\Entity\Payment;
use App\Entity\Dette;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;

class PaymentService
{
    private PaymentRepository $paymentRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(PaymentRepository $paymentRepository, EntityManagerInterface $entityManager)
    {
        $this->paymentRepository = $paymentRepository;
        $this->entityManager = $entityManager;
    }

    // Ajouter un paiement
    public function addPayment(Payment $payment): void
    {
        $this->entityManager->persist($payment);
        $this->entityManager->flush();
    }

    // Trouver un paiement par ID
    public function findPaymentById(int $id): ?Payment
    {
        return $this->paymentRepository->find($id);
    }

    // Récupérer les paiements d'une dette
    public function getPaymentsByDette(int $detteId): array
    {
        return $this->paymentRepository->findByDette($detteId);
    }

    // Calculer les paiements restants pour une dette
    public function calculateRemainingPayments(Dette $dette): float
    {
        $totalPaid = 0.0;

        // Récupérer tous les paiements associés à cette dette
        $payments = $this->getPaymentsByDette($dette->getId());

        // Calculer le montant total payé
        foreach ($payments as $payment) {
            $totalPaid += $payment->getMontant();
        }

        // Calculer le montant restant à payer
        $remainingAmount = $dette->getMontantRestant() - $totalPaid;

        // Retourner le montant restant (si c'est inférieur à 0, on retourne 0)
        return max(0, $remainingAmount);
    }

            /**
         * @Route("/api/dettes/{detteId}/remaining", methods={"GET"})
         */
        public function getRemainingPayments(int $detteId): JsonResponse
        {
            // Récupérer la dette à partir de son ID
            $dette = $this->getDoctrine()->getRepository(Dette::class)->find($detteId);

            if (!$dette) {
                return new JsonResponse(['error' => 'Dette not found'], 404);
            }

            // Calculer le montant restant
            $remainingPayments = $this->paymentService->calculateRemainingPayments($dette);

            // Retourner la réponse
            return new JsonResponse(['remaining_payments' => $remainingPayments], 200);
        }
}
