<?php

namespace Domain\Repository;

use Domain\Entity\User;

interface UserDomainRepository
{
    public function findAll();
    public function showUser(string $id);
    public function addUser(User $user);
    public function editUser(User $user);
    public function deleteUser(string $userId);
    public function checkUniqueEmail(string $email);
}