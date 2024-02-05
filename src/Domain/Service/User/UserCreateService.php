<?php

namespace Domain\Service\User;

use Domain\Entity\User;
use Domain\Repository\EquipeDomainRepository;
use Domain\Repository\UserDomainRepository;
use Domain\ValueObject\Id;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateService
{
    private UserDomainRepository $userRepository;
    private EquipeDomainRepository $equipeRepository;
    private UserPasswordHasherInterface $hasher;
    private CheckUniqueEmailService $uniqueEmail;

    public function __construct(UserDomainRepository $userRepository, EquipeDomainRepository $equipeRepository, UserPasswordHasherInterface $hasher, CheckUniqueEmailService $uniqueEmail)
    {
        $this->userRepository = $userRepository;
        $this->equipeRepository = $equipeRepository;
        $this->hasher = $hasher;
        $this->uniqueEmail = $uniqueEmail;
    }

    /**
     * @param array $userArray
     * @return string
     * @throws \Exception
     */
    public function createUser(array $userArray): string
    {
       $this->uniqueEmail->check($userArray['email']);
        $user = User::create(
            Id::generate(),
            $userArray['nom'],
            $userArray['prenom'],
            $userArray['email'],
            $userArray['password'],
            $userArray['roles'],
            $this->equipeRepository->showEquipe($userArray['equipe']) ?? null
        );
        $user->setPassword($this->hasher->hashPassword($user,$userArray['password']));
        $this->userRepository->addUser($user);
        return $user->getId();
    }

}
