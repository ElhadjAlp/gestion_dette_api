<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Groups;

class PaymentDTO
{
    #[Groups(['payment:read', 'payment:write'])]
    private ?int $id = null;

    #[Groups(['payment:read', 'payment:write'])]
    private ?\DateTimeInterface $date = null;

    #[Groups(['payment:read', 'payment:write'])]
    private ?float $montant = null;

    #[Groups(['payment:read'])]
    private ?int $detteId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): static
    {
        $this->montant = $montant;
        return $this;
    }

    public function getDetteId(): ?int
    {
        return $this->detteId;
    }

    public function setDetteId(?int $detteId): static
    {
        $this->detteId = $detteId;
        return $this;
    }
}
