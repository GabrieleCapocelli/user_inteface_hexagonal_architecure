<?php

namespace Domain\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private string $id;
    private string $prenom;
    private string $nom;
    private string $email;
    private array $roles;
    private string $password;
    private Equipe $equipe;

    private function __construct(string $id, string $nom, string $prenom, string $email, string $roles, Equipe $equipe)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->roles[] = $roles;
        $this->equipe = $equipe;
    }

    public static function create(string $id, string $nom, string $prenom, string $email, string $roles, Equipe $equipe): self
    {
        return new self($id, $nom, $prenom, $email, $roles, $equipe);
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static{
        $this->password = $password;
        return $this;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEquipe(): Equipe
    {
        return $this->equipe;
    }
}
