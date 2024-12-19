<?php

namespace App\DTO;

class DetailDTO
{
    public ?float $prixVente = null;
    public ?int $qteVendu = null;
    public ?int $articleId = null;
    public ?int $detteId = null;

    public function __construct(array $data)
    {
        $this->prixVente = $data['prixVente'] ?? null;
        $this->qteVendu = $data['qteVendu'] ?? null;
        $this->articleId = $data['articleId'] ?? null;
        $this->detteId = $data['detteId'] ?? null;
    }
}
