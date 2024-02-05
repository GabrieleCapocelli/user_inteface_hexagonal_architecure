<?php

namespace Domain\Service\Equipe;

use Domain\Repository\EquipeDomainRepository;
use Domain\Service\Equipe\CheckUniqueNomService;
use Domain\Service\Equipe\GetEquipeService;

class EditEquipeService
{
    private EquipeDomainRepository $equipeRepository;

    public function __construct(EquipeDomainRepository $equipeRepository, CheckUniqueNomService $uniqueNom, GetEquipeService $getEquipeService)
    {
        $this->equipeRepository = $equipeRepository;
        $this->uniqueNom = $uniqueNom;
        $this->getEquipeService = $getEquipeService;
    }

    /**
     * @param array $equipeArray
     * @return int
     * @throws \Exception
     */
    public function editEquipe(array $equipeArray): int
    {
        $equipe = $this->getEquipeService->getEquipe($equipeArray['id']);
        if($equipe->getNom() !== $equipeArray['nom']){
            $this->uniqueNom->check($equipeArray['nom']);
        }
        $equipe->setNom($equipeArray['nom']);
        $this->equipeRepository->editEquipe($equipe);
        return 200;
    }
}
