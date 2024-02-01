<?php

namespace App\Commands\Handler;

use App\Commands\Command\CreateUserCommand;
use Domain\Service\User\UserCreateService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    private UserCreateService $userCreateService;

    public function __construct(UserCreateService $userCreateService)
    {
        $this->userCreateService = $userCreateService;
    }

    public function __invoke(CreateUserCommand $command): string
    {
        $userArray = [
          "nom"=>$command->getNom(),
          "prenom"=>$command->getPrenom(),
          "email"=>$command->getEmail(),
          "password"=>$command->getPassword(),
          "roles"=>$command->getRoles(),
          "equipe"=>$command->getEquipe()
        ];
        return $this->userCreateService->createUser($userArray);
    }
}