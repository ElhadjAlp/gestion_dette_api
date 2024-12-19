<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ClientDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=25)
     */
    private $surname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=11)
     * @Assert\Regex("/^\d+$/") // uniquement des chiffres
     */
    private $telephone;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $adresse;

    // Getters et Setters

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }
}
