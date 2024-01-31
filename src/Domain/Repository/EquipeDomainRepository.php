<?php

namespace Domain\Repository;

interface EquipeDomainRepository
{
    public function findAll();
    public function show(string $id);

}