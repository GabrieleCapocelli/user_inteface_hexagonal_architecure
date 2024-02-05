<?php

namespace App\Queries\Query;

use App\Queries\DTO\UserDTO;
use Domain\Entity\User;
use Domain\Repository\UserDomainRepository;

class UserQueries
{
    private UserDomainRepository $repository;

    public function __construct(UserDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function usersIndex(): array
    {
        $users = $this->repository->usersIndex();
        if(!empty($users)){
            return \array_map(function(User $user){
                return new UserDTO(
                    $user->getId(),
                    $user->getPrenom(),
                    $user->getNom(),
                    $user->getEmail(),
                    $user->getRoles(),
                    $user->getEquipe()->getId(),
                    $user->getEquipe()->getNom()
                );
            }, $users);
        }
        return [];
    }

    public function showUser(string $userId): ?UserDTO
    {
        if($this->repository->checkIfExists($userId)){
            $user = $this->repository->showUser($userId);
            return new UserDTO(
                $user->getId(),
                $user->getPrenom(),
                $user->getNom(),
                $user->getEmail(),
                $user->getRoles(),
                $user->getEquipe()?->getId(),
                $user->getEquipe()?->getNom()
            );
        }else{
            throw new \Exception('utilisateur inexistent', 404);
        }
    }

}
