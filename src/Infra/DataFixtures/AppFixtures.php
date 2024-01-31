<?php

namespace Infra\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Domain\Entity\Equipe;
use Domain\Entity\User;
use Domain\ValueObject\Id;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        //creation des equipes
        for($i=0;$i<2;$i++){
            $equipe = Equipe::create(Id::generate(), 'equipe'.($i+1));
            $manager->persist($equipe);
            $this->setReference('equipe'.($i+1), $equipe);
        }
        //creation des chefs d'equipe
        for($i=0;$i<2;$i++){
            $chef = User::create(
                Id::generate(),
                $faker->lastName,
                $faker->firstName,
                'chef'.($i+1).'@wimova.app',
                'ROLE_CHEF',
                $this->getReference('equipe'.($i+1))
            );
            $chef->setPassword(
                $this->hasher->hashPassword(
                    $chef,
                    'wimova'
                )
            );
            $manager->persist($chef);
            $this->setReference('chef'.($i+1), $chef);
        }

        //creation des employes
        for($i=0;$i<4;$i++){
            $employe = User::create(
                Id::generate(),
                $faker->lastName,
                $faker->firstName,
                'employe'.($i+1).'@wimova.app',
                'ROLE_EMPLOYE',
                $this->getReference('equipe1')
            );
            $employe->setPassword(
                $this->hasher->hashPassword(
                    $employe,
                    'wimova'
                )
            );
            $manager->persist($employe);
        }
        for($i=4;$i<8;$i++){
            $employe = User::create(
                Id::generate(),
                $faker->lastName,
                $faker->firstName,
                'employe'.($i+1).'@wimova.app',
                'ROLE_EMPLOYE',
                $this->getReference('equipe2')
            );
            $employe->setPassword(
                $this->hasher->hashPassword(
                    $employe,
                    'wimova'
                )
            );
            $manager->persist($employe);
        }

        $manager->flush();
    }
}
