<?php

namespace App\Commands\Handler;

use App\Commands\Command\DeleteUserCommand;
use Domain\Service\User\DeleteUserService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteUserHandler
{
    private DeleteUserService $deleteUserService;

    public function __construct(DeleteUserService $deleteUserService)
    {
        $this->deleteUserService = $deleteUserService;
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->deleteUserService->deleteUser($command->getUserId());
    }
}