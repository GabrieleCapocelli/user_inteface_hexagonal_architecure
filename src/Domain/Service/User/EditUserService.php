<?php

namespace Domain\Service\User;

use Domain\Repository\EquipeDomainRepository;
use Domain\Repository\UserDomainRepository;

class EditUserService
{
    private UserDomainRepository $userRepository;
    private EquipeDomainRepository $equipeRepository;
    private CheckUniqueEmailService $uniqueEmail;
    private GetUserService $getUserService;

    public function __construct(UserDomainRepository $userRepository, EquipeDomainRepository $equipeRepository, CheckUniqueEmailService $uniqueEmail, GetUserService $getUserService)
    {
        $this->userRepository = $userRepository;
        $this->equipeRepository = $equipeRepository;
        $this->uniqueEmail = $uniqueEmail;
        $this->getUserService = $getUserService;
    }

    /**
     * @param array $userArray
     * @return int
     * @throws \Exception
     */
    public function editUser(array $userArray): int
    {
        $user = $this->getUserService->getUser($userArray['id']);
        if($user->getEmail() !== $userArray['email']){
            $this->uniqueEmail->check($userArray['email']);
        }
        $user->setNom($userArray['nom'])
             ->setPrenom($userArray['prenom'])
             ->setEmail($userArray['email'])
             ->setRoles($userArray['roles'])
             ->setEquipe($this->equipeRepository->showEquipe($userArray['equipe']) ?? null);
        $this->userRepository->editUser($user);
        return 200;
    }
}
