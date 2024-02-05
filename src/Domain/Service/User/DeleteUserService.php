<?php

namespace Domain\Service\User;

use Domain\Repository\UserDomainRepository;

class DeleteUserService
{
    private UserDomainRepository $userDomainRepository;

    public function __construct(UserDomainRepository $userDomainRepository)
    {
        $this->userDomainRepository = $userDomainRepository;
    }

    public function deleteUser(string $userId): void
    {
        if($this->userDomainRepository->checkIfExists($userId)){
            $this->userDomainRepository->deleteUser($userId);
        }else{
            throw new \Exception('utilisateur inexistent', 404);
        }
    }

}
