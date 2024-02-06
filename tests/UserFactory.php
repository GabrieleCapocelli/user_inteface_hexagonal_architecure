<?php

namespace Tests;

use Domain\Entity\User;
use Domain\Repository\UserDomainRepository;
use Domain\ValueObject\Id;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * insert a user in the database and returns it
 */
class UserFactory extends KernelTestCase
{
    public static function returnUser(): User
    {
        self::bootKernel();
        $user = User::create(
            Id::generate(),
            'test',
            'test',
            'test@test.test',
            'test',
            ['ROLE_ADMIN'],
            EquipeFactory::returnEquipe()
        );

        $repository = self::getContainer()->get(UserDomainRepository::class);
        //helping the IDE
        assert($repository instanceof UserDomainRepository);
        $repository->addUser($user);
        return $user;
    }
}
