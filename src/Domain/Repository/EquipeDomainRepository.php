<?php

namespace Domain\Repository;

use Domain\Entity\Equipe;

interface EquipeDomainRepository
{
    public function equipesIndex();
    public function showEquipe(string $id);
    public function addEquipe(Equipe $equipe);
    public function editEquipe(Equipe $equipe);
    public function deleteEquipe(string $equipeId);
    public function checkUniqueNom(string $nom);
    public function checkIfExists(string $equipeId);

}
