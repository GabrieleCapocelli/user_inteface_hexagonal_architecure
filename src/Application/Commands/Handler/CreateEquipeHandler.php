<?php

namespace App\Commands\Handler;

use App\Commands\Command\CreateEquipeCommand;
use Domain\Service\Equipe\EquipeCreateService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateEquipeHandler
{
    private EquipeCreateService $equipeCreateService;
    public function __construct(EquipeCreateService $equipeCreateService)
    {
        $this->equipeCreateService = $equipeCreateService;
    }

    public function __invoke(CreateEquipeCommand $command): string
    {
        return $this->equipeCreateService->createEquipe($command->getNom());
    }
}
