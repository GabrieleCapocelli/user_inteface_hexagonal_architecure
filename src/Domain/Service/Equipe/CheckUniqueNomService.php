<?php

namespace Domain\Service\Equipe;

use Domain\Exceptions\NotUniqueNomException;
use Domain\Repository\EquipeDomainRepository;

class CheckUniqueNomService
{
    private EquipeDomainRepository $repository;

    public function __construct(EquipeDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function check(string $nom): bool
    {
        if(!$this->repository->checkUniqueNom($nom)){
            throw new NotUniqueNomException($nom);
        }
        return true;
    }

}
