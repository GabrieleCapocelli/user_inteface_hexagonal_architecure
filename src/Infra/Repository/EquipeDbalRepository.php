<?php

namespace Infra\Repository;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Connection;
use Domain\Repository\EquipeDomainRepository;
use Domain\Entity\Equipe;
use Domain\ValueObject\Id;

class EquipeDbalRepository implements EquipeDomainRepository
{
    private  $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function equipesIndex()
    {
        // TODO: Implement findAll() method.
    }

    public function showEquipe(string $id): ?Equipe
    {
        $equipe = $this->connection->createQueryBuilder()
                                   ->select('*')
                                   ->from('equipe')
                                   ->where('id = :id')
                                   ->setParameter('id', $id)
                                   ->fetchAllAssociative();
        if(!empty($equipe)){
            return Equipe::create(
                Id::fromString($equipe[0]['id']),
                $equipe[0]['nom']
            );
        }
        return null;
    }
}
