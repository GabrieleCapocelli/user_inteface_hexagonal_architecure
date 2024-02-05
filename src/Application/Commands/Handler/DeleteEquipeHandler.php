<?php

namespace App\Commands\Handler;

use App\Commands\Command\DeleteEquipeCommand;
use Domain\Service\Equipe\DeleteEquipeService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteEquipeHandler
{
    private DeleteEquipeService $deleteEquipeService;

    public function __construct(DeleteEquipeService $deleteEquipeService)
    {
        $this->deleteEquipeService = $deleteEquipeService;
    }

    public function __invoke(DeleteEquipeCommand $command): void
    {
        $this->deleteEquipeService->deleteEquipe($command->getEquipeId());
    }
}
