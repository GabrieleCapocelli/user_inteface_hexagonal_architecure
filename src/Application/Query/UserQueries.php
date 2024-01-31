<?php

namespace App\Query;

use Domain\Entity\User;
use Domain\Repository\UserDomainRepository;

class UserQueries
{
    private UserDomainRepository $repository;

    public function __construct(UserDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function usersIndex(): ?array
    {
        return $this->repository->findAll();
    }

    public function showUser(string $userId): ?User
    {
        return $this->repository->show($userId);
    }

}