<?php

namespace App\Commands\Handler;

use App\Commands\Command\EditEquipeCommand;
use Domain\Service\Equipe\EditEquipeService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EditEquipeHandler
{
    private EditEquipeService $editEquipeService;

   public function __construct(EditEquipeService $editEquipeService)
    {
        $this->editEquipeService = $editEquipeService;
    }

    public function __invoke(EditEquipeCommand $command): int
    {
        $equipeArray = [
            "id"=>$command->getId(),
            "nom"=>$command->getNom()
        ];
        return $this->editEquipeService->editEquipe($equipeArray);
    }

}
