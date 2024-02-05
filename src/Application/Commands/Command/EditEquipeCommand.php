<?php

namespace App\Commands\Command;

use Symfony\Component\Validator\Constraints as Assert;
class EditEquipeCommand
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Uuid]
        private string $id,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: "/[<>\%\$\?*+\/!:;\d]/", match: false)]
        private string $nom,
    )
    {
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
