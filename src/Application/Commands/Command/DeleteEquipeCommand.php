<?php

namespace App\Commands\Command;

class DeleteEquipeCommand
{
    private string $equipeId;
    public function __construct(string $equipeId)
    {
        $this->equipeId = $equipeId;
    }

    public function getEquipeId(): string
    {
        return $this->equipeId;
    }
}
