<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['detail:read']],
    denormalizationContext: ['groups' => ['detail:write']],
    paginationEnabled: true
)]
class Detail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['detail:read'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['detail:read', 'detail:write'])]
    private ?float $prixVente = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['detail:read', 'detail:write'])]
    private ?int $qteVendu = null;

    #[ORM\ManyToOne(inversedBy: 'details')]
    #[Groups(['detail:read', 'detail:write'])]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'details')]
    #[Groups(['detail:read', 'detail:write'])]
    private ?Dette $dette = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixVente(): ?float
    {
        return $this->prixVente;
    }

    public function setPrixVente(?float $prixVente): static
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getQteVendu(): ?int
    {
        return $this->qteVendu;
    }

    public function setQteVendu(?int $qteVendu): static
    {
        $this->qteVendu = $qteVendu;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getDette(): ?Dette
    {
        return $this->dette;
    }

    public function setDette(?Dette $dette): static
    {
        $this->dette = $dette;

        return $this;
    }
}
