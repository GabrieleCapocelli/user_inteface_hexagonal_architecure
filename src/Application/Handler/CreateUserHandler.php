<?php

namespace App\Handler;

use App\Command\CreateUserCommand;
use Domain\Service\UserService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(CreateUserCommand $command): string
    {
        $userArray = [
          "nom"=>$command->getNom(),
          "prenom"=>$command->getPrenom(),
          "email"=>$command->getEmail(),
          "password"=>$command->getPassword(),
          "role"=>$command->getRole(),
          "equipe"=>$command->getEquipe()
        ];
        return $this->userService->createUser($userArray);
    }
}