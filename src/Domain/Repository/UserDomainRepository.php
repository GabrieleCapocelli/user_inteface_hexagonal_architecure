<?php

namespace Domain\Repository;

use Domain\Entity\User;

interface UserDomainRepository
{
    public function findAll();
    public function addUser(User $user);
    public function show(string $id);
}