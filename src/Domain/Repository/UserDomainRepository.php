<?php

namespace Domain\Repository;

use Domain\Entity\User;

interface UserDomainRepository
{
    public function usersIndex();
    public function showUser(string $userId);
    public function addUser(User $user);
    public function editUser(User $user);
    public function deleteUser(string $userId);
    public function nullEquipe(string $equipeId);
    public function checkUniqueEmail(string $email);
    public function checkIfExists(string $userId);
}
