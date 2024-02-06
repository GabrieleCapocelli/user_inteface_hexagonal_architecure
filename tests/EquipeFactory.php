<?php

namespace Tests;

use Domain\Entity\Equipe;
use Domain\Repository\EquipeDomainRepository;
use Domain\ValueObject\Id;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
*insert an equipe in the database and returns it
*/
class EquipeFactory extends KernelTestCase
{
    public static function returnEquipe(): Equipe
    {
        self::bootKernel();
        $equipe = Equipe::create(
            Id::generate(),
            'equipeTest'
        );

        $repository = self::getContainer()->get(EquipeDomainRepository::class);
        //helping the IDE
        assert($repository instanceof EquipeDomainRepository);
        $repository->addEquipe($equipe);
        return $equipe;
    }
}