<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    shortName: "Client",
    normalizationContext: ['groups' => ['client:read']],
    denormalizationContext: ['groups' => ['client:write']],
    paginationEnabled: true
)]
#[ApiFilter(SearchFilter::class, properties: ['surname' => 'partial', 'telephone' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['surname', 'telephone'], arguments: ['orderParameterName' => 'order'])]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $surname = null;

    #[ORM\Column(length: 11, nullable: true)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $adresse = null;

    #[ORM\OneToOne(mappedBy: 'client', cascade: ['persist', 'remove'])]
    #[Groups(['client:read'])]
    private ?User $yes = null;

    #[ORM\OneToMany(targetEntity: Dette::class, mappedBy: 'client')]
    #[Groups(['client:read'])]
    private Collection $dettes;

    public function __construct()
    {
        $this->dettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getYes(): ?User
    {
        return $this->yes;
    }

    public function setYes(?User $yes): static
    {
        // unset the owning side of the relation if necessary
        if ($yes === null && $this->yes !== null) {
            $this->yes->setClient(null);
        }

        // set the owning side of the relation if necessary
        if ($yes !== null && $yes->getClient() !== $this) {
            $yes->setClient($this);
        }

        $this->yes = $yes;

        return $this;
    }

    /**
     * @return Collection<int, Dette>
     */
    public function getDettes(): Collection
    {
        return $this->dettes;
    }

    public function addDette(Dette $dette): static
    {
        if (!$this->dettes->contains($dette)) {
            $this->dettes->add($dette);
            $dette->setClient($this);
        }

        return $this;
    }

    public function removeDette(Dette $dette): static
    {
        if ($this->dettes->removeElement($dette)) {
            // set the owning side to null (unless already changed)
            if ($dette->getClient() === $this) {
                $dette->setClient(null);
            }
        }

        return $this;
    }
}
