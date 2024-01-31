<?php

namespace App\Command;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserCommand
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: "/[<>\%\$\?*+\/!:;\d]/", match: false)]
        private string $nom,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: "/[<>\%\$\?*+\/!:;\d]/", match: false)]
        private string $prenom,

        #[Assert\NotNull]
        #[Assert\Email]
        private string $email,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        private string $password,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: "/^(ROLE_CHEF|ROLE_EMPLOYE)$/")]
        private string $role,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Uuid]
        private string $equipe,
    ){
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getEquipe(): string
    {
        return $this->equipe;
    }

}