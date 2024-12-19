<?php
namespace App\DTO;

use App\Entity\Article;

class ArticleDTO
{
    public ?int $id;
    public ?string $libelle;
    public ?string $reference;
    public ?int $qteStock;
    public ?float $prix;

    public static function fromEntity(Article $article): self
    {
        $dto = new self();
        $dto->id = $article->getId();
        $dto->libelle = $article->getLibelle();
        $dto->reference = $article->getReference();
        $dto->qteStock = $article->getQteStock();
        $dto->prix = $article->getPrix();
        
        return $dto;
    }
}
