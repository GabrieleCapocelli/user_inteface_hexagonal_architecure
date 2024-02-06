<?php

namespace Domain\Service\Equipe;

use Domain\Entity\Equipe;
use Domain\Exceptions\EquipeUndefinedException;
use Domain\Repository\EquipeDomainRepository;
use Domain\ValueObject\Id;

class GetEquipeService
{
    private EquipeDomainRepository $equipeRepository;
    /**
     * @param EquipeDomainRepository $equipeRepository
     */
    public function __construct(EquipeDomainRepository $equipeRepository)
    {
        $this->equipeRepository = $equipeRepository;
    }

    /**
     * @param string $equipeId
     * @return Equipe
     * @throws \Exception
     */
    public function getEquipe(string $equipeId): Equipe
    {
        $equipe = $this->equipeRepository->showEquipe($equipeId);
        if($equipe){
            return Equipe::create(
                Id::fromString($equipeId),
                $equipe->getNom()
            );
        }else{
            throw new EquipeUndefinedException($equipeId);
        }
    }

}
