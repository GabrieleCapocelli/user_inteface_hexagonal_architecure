<?php

namespace App\Queries\DTO;

class EquipeDTO
{
    private string $id;
    private string $nom;

    public function __construct(string $id, string $nom)
    {
        $this->id = $id;
        $this->nom = $nom;
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