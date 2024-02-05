<?php

namespace App\Queries\DTO;

class UserDTO
{
    private string $id;
    private string $prenom;
    private string $nom;
    private string $email;
    private array $roles;
    private ?string $equipeId;
    private ?string $equipeNom;

    public function __construct(string $id, string $prenom, string $nom, string $email, array $roles, ?string $equipeId, ?string $equipeNom)
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->roles = $roles;
        $this->equipeId = $equipeId;
        $this->equipeNom = $equipeNom;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getEquipeId(): ?string
    {
        return $this->equipeId;
    }

    public function getEquipeNom(): ?string
    {
        return $this->equipeNom;
    }

}
