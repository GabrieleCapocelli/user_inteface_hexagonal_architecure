<?php

namespace Tests\Domain\Service\User;

use Domain\Entity\Equipe;
use Domain\Repository\UserDomainRepository;
use Domain\Service\Equipe\DeleteEquipeService;
use Domain\Service\User\GetUserService;
use Domain\Service\User\NullEquipeService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\UserFactory;
use Zenstruck\Foundry\Test\ResetDatabase;

class NullEquipeTest extends KernelTestCase
{
    use ResetDatabase;
    public function testNullEquipe()
    {
        self::bootKernel();
        $user = UserFactory::returnUser();
        $equipe = $user->getEquipe();
        $this->assertInstanceOf(Equipe::class, $equipe);
        //this class observes equipe and calls NullEquipeService when an equipe is deleted
        $deleteEquipeService = self::getContainer()->get(DeleteEquipeService::class);
        assert($deleteEquipeService instanceof DeleteEquipeService);
        $deleteEquipeService->deleteEquipe($equipe->getId());
        //retrieving the user from the db
        $getUserService = $this->getContainer()->get(GetUserService::class);
        assert($getUserService instanceof GetUserService);
        $userFromDb = $getUserService->getUser($user->getId());
        $this->assertNull($userFromDb->getEquipe());
    }
}
