<?php

namespace App\DTO;

use App\Entity\User;

class UserDTO
{
    public string $id;
    public string $email;
    public array $roles;

    public static function fromEntity(User $user): self
    {
        $dto = new self();
        $dto->id = (string) $user->getId();
        $dto->email = $user->getEmail();
        $dto->roles = $user->getRoles();

        return $dto;
    }
}
