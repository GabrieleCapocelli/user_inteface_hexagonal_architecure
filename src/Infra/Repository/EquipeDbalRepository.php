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

    /**
     * @return void
     * @throws Exception
     */
    public function equipesIndex(): ?array
    {
        $equipes = $this->connection->createQueryBuilder()
                                    ->select('*')
                                    ->from('equipe')
                                    ->fetchAllAssociative();
        if(!empty($equipes)){
            return \array_map(function(array $equipe){
                return Equipe::create(
                    Id::fromString($equipe['id']),
                    $equipe['nom']
                );
            }, $equipes);
        }
        return null;
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

    /**
     * @param Equipe $equipe
     * @return void
     * @throws Exception
     */
    public function addEquipe(Equipe $equipe): void
    {
        $this->connection->createQueryBuilder()
            ->insert('equipe')
            ->values([
                'id'=>':id',
                'nom'=>':nom'
            ])
            ->setParameters([
                'id'=>$equipe->getId(),
                'nom'=>$equipe->getNom()
            ])
            ->executeQuery();
    }

    /**
     * @param Equipe $equipe
     * @return void
     * @throws Exception
     */
    public function editEquipe(Equipe $equipe): void
    {
        $this->connection->createQueryBuilder()
            ->update('equipe')
            ->set('nom', ':nom')
            ->where('id = :id')
            ->setParameters([
                'id'=>$equipe->getId(),
                'nom'=>$equipe->getNom()
            ])
            ->executeQuery();
    }

    /**
     * @param string $equipeId
     * @return void
     * @throws Exception
     */
    public function deleteEquipe(string $equipeId): void
    {
        $this->connection->createQueryBuilder()
            ->delete('equipe')
            ->where('id = :id')
            ->setParameter('id', $equipeId)
            ->executeQuery();
    }

    /**
     * @param string $email
     * @return bool
     * @throws Exception
     */
    public function checkUniqueNom(string $nom): bool
    {
        $result = $this->connection->createQueryBuilder()->select('nom')
            ->from('equipe')
            ->where('nom = :nom')
            ->setParameter('nom', $nom)
            ->executeQuery();
        if($result->rowCount() === 0){
            return true;
        }
        return false;
    }

    /**
     * @param string $equipeId
     * @return bool
     * @throws Exception
     */
    public function checkIfExists(string $equipeId): bool
    {
        $result = $this->connection->createQueryBuilder()->select('id')
            ->from('equipe')
            ->where('id = :equipeId')
            ->setParameter('equipeId', $equipeId)
            ->executeQuery();
        if($result->rowCount() === 0){
            return false;
        }
        return true;
    }

}
