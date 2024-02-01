<?php

namespace Domain\Service\User;

use Domain\Repository\UserDomainRepository;

class CheckUniqueEmailService
{
    private UserDomainRepository $repository;

    public function __construct(UserDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function check(string $email): bool
    {
        if(!$this->repository->checkUniqueEmail($email)){
            throw new \Exception("email déjà utilisé");
        }
        return true;
    }

}