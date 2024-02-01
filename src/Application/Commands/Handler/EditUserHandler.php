<?php

namespace App\Commands\Handler;

use App\Commands\Command\EditUserCommand;
use Domain\Service\User\EditUserService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EditUserHandler
{
    private EditUserService $editUserService;

   public function __construct(EditUserService $editUserService)
    {
        $this->editUserService = $editUserService;
    }

    public function __invoke(EditUserCommand $command): int
    {
        $userArray = [
            "id"=>$command->getId(),
            "nom"=>$command->getNom(),
            "prenom"=>$command->getPrenom(),
            "email"=>$command->getEmail(),
            "roles"=>$command->getRoles(),
            "equipe"=>$command->getEquipe()
        ];
        return $this->editUserService->editUser($userArray);
    }

}