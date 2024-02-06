<?php

namespace Tests\Domain\Service\User;

use Domain\Service\User\CheckUniqueEmailService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\UserFactory;
use Zenstruck\Foundry\Test\ResetDatabase;

class CheckUniqueEmailServiceTest extends KernelTestCase
{
    use ResetDatabase;
    public function testCheckUniqueEmail()
    {
        self::bootKernel();
        $checkUniqueEmailService = self::getContainer()->get(CheckUniqueEmailService::class);
        //helping the IDE
        assert($checkUniqueEmailService instanceof CheckUniqueEmailService);
        //creating user
        UserFactory::returnUser();
        //preparing to receive exception with already used email
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('email déjà utilisé');
        $checkUniqueEmailService->check('test@test.test');
        //testing a valid email
        $this->assertTrue($checkUniqueEmailService->check('test'));
    }

}
