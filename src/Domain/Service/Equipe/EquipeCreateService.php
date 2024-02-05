<?php

namespace Domain\Service\Equipe;

use Domain\Entity\Equipe;
use Domain\Repository\EquipeDomainRepository;
use Domain\ValueObject\Id;

class EquipeCreateService
{
    private EquipeDomainRepository $equipeRepository;

    private CheckUniqueNomService $uniqueNom;

    public function __construct(EquipeDomainRepository $equipeRepository, CheckUniqueNomService
    $uniqueNom)
    {
        $this->equipeRepository = $equipeRepository;
        $this->uniqueNom = $uniqueNom;
    }

    /**
     * @param array $equipeArray
     * @return string
     * @throws \Exception
     */
    public function createEquipe(string $nom): string
    {
       $this->uniqueNom->check($nom);
        $equipe = Equipe::create(
            Id::generate(),
            $nom
        );
        $this->equipeRepository->addEquipe($equipe);
        return $equipe->getId();
    }

}
