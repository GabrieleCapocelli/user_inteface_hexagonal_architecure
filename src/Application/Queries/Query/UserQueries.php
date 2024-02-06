<?php

namespace App\Queries\Query;

use App\Queries\DTO\UserDTO;
use Domain\Entity\User;
use Domain\Exceptions\UserUndefinedException;
use Domain\Repository\UserDomainRepository;

class UserQueries
{
    private UserDomainRepository $repository;

    public function __construct(UserDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function usersIndex(?string $equipeId): array
    {
        if(is_null($equipeId)){
            $users = $this->repository->usersIndex();
        }else{
            $users = $this->repository->usersIndexByEquipe($equipeId);
        }
        if(!empty($users)){
            return \array_map(function(User $user){
                return new UserDTO(
                    $user->getId(),
                    $user->getPrenom(),
                    $user->getNom(),
                    $user->getEmail(),
                    $user->getRoles(),
                    $user->getEquipe()?->getId(),
                    $user->getEquipe()?->getNom()
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
            throw new UserUndefinedException($userId);
        }
    }

}
