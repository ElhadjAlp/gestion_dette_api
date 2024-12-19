<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class DetteDTO
{
    #[Assert\NotBlank]
    #[Assert\Type("float")]
    public ?float $montant;

    #[Assert\Type("float")]
    public ?float $montantVerser;

    #[Assert\Type("float")]
    public ?float $montantRestant;

    #[Assert\Type("\DateTimeInterface")]
    public ?\DateTimeInterface $date;

    public function __construct(float $montant, float $montantVerser = null, float $montantRestant = null, \DateTimeInterface $date = null)
    {
        $this->montant = $montant;
        $this->montantVerser = $montantVerser;
        $this->montantRestant = $montantRestant;
        $this->date = $date;
    }
}
