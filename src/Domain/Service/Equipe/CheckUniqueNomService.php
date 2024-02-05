<?php

namespace Domain\Service\Equipe;

use Domain\Repository\UserDomainRepository;

class CheckUniqueNomService
{
    private UserDomainRepository $repository;

    public function __construct(UserDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function check(string $email): bool
    {
        if(!$this->repository->checkUniqueEmail($email)){
            throw new \Exception("email déjà utilisé", 400);
        }
        return true;
    }

}
