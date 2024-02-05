<?php

namespace App\Commands\Command;

class DeleteUserCommand
{
    private string $userId;
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
