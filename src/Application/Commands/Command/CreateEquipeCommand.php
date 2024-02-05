<?php

namespace App\Commands\Command;
use Symfony\Component\Validator\Constraints as Assert;

class CreateEquipeCommand
{
    public function __construct(#[Assert\NotNull]
                                #[Assert\NotBlank]
                                #[Assert\Regex(pattern: "/[<>\%\$\?*+\/!:;]/", match: false)]
                                private string $nom
    )
    {
    }

    public function getNom(): string
    {
        return $this->nom;
    }
}
