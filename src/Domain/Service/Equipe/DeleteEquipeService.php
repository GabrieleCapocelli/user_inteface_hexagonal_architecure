<?php

namespace Domain\Service\Equipe;

use Domain\Exceptions\EquipeUndefinedException;
use Domain\Repository\EquipeDomainRepository;
use Domain\Service\User\NullEquipeService;


class DeleteEquipeService
{
    private EquipeDomainRepository $equipeDomainRepository;

    private GetEquipeService $getEquipeService;
    private NullEquipeService $NullEquipeService;
    public function __construct(EquipeDomainRepository $equipeDomainRepository, NullEquipeService $nullEquipeService, GetEquipeService $getEquipeService)
    {
        $this->equipeDomainRepository = $equipeDomainRepository;
        $this->nullEquipeService = $nullEquipeService;
        $this->getEquipeService = $getEquipeService;
    }

    public function deleteEquipe(string $equipeId): void
    {
        if($this->equipeDomainRepository->checkIfExists($equipeId)){
            $equipe = $this->getEquipeService->getEquipe($equipeId);
            $equipe->attach($this->nullEquipeService);
            $equipe->notify();
            $this->equipeDomainRepository->deleteEquipe($equipeId);
            $equipe->detach($this->nullEquipeService);
        }else{
            throw new EquipeUndefinedException($equipeId);
        }
    }

}
