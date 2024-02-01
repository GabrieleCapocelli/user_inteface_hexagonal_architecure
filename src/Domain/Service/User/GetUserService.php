<?php

namespace Domain\Service\User;

use Domain\Entity\User;
use Domain\Repository\EquipeDomainRepository;
use Domain\Repository\UserDomainRepository;
use Domain\ValueObject\Id;

class GetUserService
{
    private UserDomainRepository $userRepository;
    private EquipeDomainRepository $equipeRepository;

    /**
     * @param UserDomainRepository $userRepository
     * @param EquipeDomainRepository $equipeRepository
     */
    public function __construct(UserDomainRepository $userRepository, EquipeDomainRepository $equipeRepository)
    {
        $this->userRepository = $userRepository;
        $this->equipeRepository = $equipeRepository;
    }

    public function getUser(string $userId): User
    {
        $user = $this->userRepository->showUser($userId);
        if($user){
            return User::create(
                Id::fromString($userId),
                $user->getNom(),
                $user->getPrenom(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getRoles(),
                $user->getEquipe()
            );
        }else{
            throw new \Exception('utilisateur inexistent');
        }
    }


}