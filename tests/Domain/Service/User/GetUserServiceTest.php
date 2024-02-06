<?php

namespace Tests\Domain\Service\User;

use Domain\Service\User\GetUserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\UserFactory;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetUserServiceTest extends KernelTestCase
{
    use ResetDatabase;
    public function testGetUser()
    {
        self::bootKernel();
        $getUserService = self::getContainer()->get(GetUserService::class);
        assert($getUserService instanceof GetUserService);
        $user = UserFactory::returnUser();
        $getUser = $getUserService->getUser($user->getId());
        $this->assertEquals($user, $getUser);
    }

}
