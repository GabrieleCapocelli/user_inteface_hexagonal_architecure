<?php

namespace Domain\Service\User;

use Domain\Repository\UserDomainRepository;

class DeleteUserService
{
    private UserDomainRepository $userDomainRepository;
    private GetUserService $getUserService;

    public function __construct(UserDomainRepository $userDomainRepository, GetUserService $getUserService)
    {
        $this->userDomainRepository = $userDomainRepository;
        $this->getUserService = $getUserService;
    }

    public function deleteUser(string $userId): void
    {
        if($this->getUserService->getUser($userId)){
            $this->userDomainRepository->deleteUser($userId);
        }
    }

}