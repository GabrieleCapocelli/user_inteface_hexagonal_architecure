<?php

namespace Domain\Service\User;

use Domain\Entity\User;
use Domain\Repository\EquipeDomainRepository;
use Domain\Repository\UserDomainRepository;
use Domain\ValueObject\Id;

class GetUserService
{
    private UserDomainRepository $userRepository;
    /**
     * @param UserDomainRepository $userRepository
     */
    public function __construct(UserDomainRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $userId
     * @return User
     * @throws \Exception
     */
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
            throw new \Exception('utilisateur inexistent', 404);
        }
    }

}
