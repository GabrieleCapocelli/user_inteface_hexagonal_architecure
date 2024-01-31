<?php

namespace Domain\Service;

use Domain\Entity\User;
use Domain\ValueObject\Id;
use Domain\Repository\EquipeDomainRepository;
use Domain\Repository\UserDomainRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserDomainRepository $userRepository;
    private EquipeDomainRepository $equipeRepository;

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserDomainRepository $userRepository, EquipeDomainRepository $equipeRepository, UserPasswordHasherInterface $hasher)
    {
        $this->userRepository = $userRepository;
        $this->equipeRepository = $equipeRepository;
        $this->hasher = $hasher;
    }

    public function createUser(array $userArray): string
    {
        $user = User::create(
            Id::generate(),
            $userArray['nom'],
            $userArray['prenom'],
            $userArray['email'],
            $userArray['role'],
            $this->equipeRepository->find($userArray['equipe'])
        );
        $user->setPassword($this->hasher->hashPassword($user,$userArray['password']));
        return $this->userRepository->addUser($user);
    }

}