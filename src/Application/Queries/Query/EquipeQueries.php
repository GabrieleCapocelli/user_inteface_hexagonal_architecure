<?php

namespace App\Queries\Query;
use App\Queries\DTO\EquipeDTO;
use Domain\Entity\Equipe;
use Domain\Exceptions\EquipeUndefinedException;
use Domain\Repository\EquipeDomainRepository;
class EquipeQueries
{
    private EquipeDomainRepository $repository;

    public function __construct(EquipeDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function equipesIndex(): array
    {
        $equipes = $this->repository->equipesIndex();
        if(!empty($equipes)){
            return \array_map(function(Equipe $equipe){
                return new EquipeDTO(
                    $equipe->getId(),
                    $equipe->getNom(),
                );
            }, $equipes);
        }
        return [];
    }

    public function showEquipe(string $equipeId): ?EquipeDTO
    {
        if ($this->repository->checkIfExists($equipeId)) {
            $equipe = $this->repository->showEquipe($equipeId);
            return new EquipeDTO(
                $equipe->getId(),
                $equipe->getNom(),
            );
        } else {
            throw new EquipeUndefinedException($equipeId);
        }
    }

}
