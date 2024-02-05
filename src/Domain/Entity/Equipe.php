<?php

namespace Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Infra\Repository\EquipeDbalRepository;

#[ORM\Entity(repositoryClass: EquipeDbalRepository::class)]
class Equipe
{
    private string $id;
    private string $nom;

    private function __construct(string $equipeId, string $nom)
    {
        $this->id = $equipeId;
        $this->nom = $nom;
    }

    public static function create(string $equipeId, string $nom): self
    {
        return new self($equipeId, $nom);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

}
