<?php

namespace Infra\Repository;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Connection;
use Domain\Entity\User;
use Domain\Repository\UserDomainRepository;
use Domain\ValueObject\Id;
use Domain\Repository\EquipeDomainRepository;

class UserDbalRepository implements UserDomainRepository
{
    private  $connection;
    private EquipeDomainRepository $equipeDomainRepository;

    public function __construct(Connection $connection, EquipeDomainRepository $equipeDomainRepository)
    {
        $this->connection = $connection;
        $this->equipeDomainRepository = $equipeDomainRepository;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function usersIndex(): ?array
    {
        $users = $this->connection->createQueryBuilder()->select('*')
            ->from('user')
            ->executeQuery()
            ->fetchAllAssociative();
        if(!empty($users)){
            return \array_map(function(array $user){
                return User::create(
                    Id::fromString($user['id']),
                    $user['nom'],
                    $user['prenom'],
                    $user['email'],
                    $user['password'],
                    json_decode($user['roles']),
                    $this->equipeDomainRepository->showEquipe($user['equipe'])
                );
            }, $users);
        }
        return null;
    }

    /**
     * @param string $userId
     * @return User|null
     * @throws Exception
     */
    public function showUser(string $userId): ?User
    {
        $user = $this->connection->createQueryBuilder()
                                 ->select('*')
                                 ->from('user')
                                 ->where('id = :id')
                                 ->setParameter('id', $userId)
                                 ->fetchAllAssociative();
        if(!empty($user)){
            return User::create(
                Id::fromString($user[0]['id']),
                $user[0]['nom'],
                $user[0]['prenom'],
                $user[0]['email'],
                $user[0]['password'],
                json_decode($user[0]['roles']),
                $user[0]['equipe'] ? $this->equipeDomainRepository->showEquipe($user[0]['equipe']) : null
            );
        }
        return null;
    }

    /**
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function addUser(User $user): void
    {
        $this->connection->createQueryBuilder()
                         ->insert('user')
                         ->values([
                             'id'=>':id',
                             'nom'=>':nom',
                             'prenom'=>':prenom',
                             'email'=>':email',
                             'password'=>':password',
                             'roles'=>':roles',
                             'equipe'=>':equipe'
                         ])
                         ->setParameters([
                             'id'=>$user->getId(),
                             'nom'=>$user->getNom(),
                             'prenom'=>$user->getPrenom(),
                             'email'=>$user->getEmail(),
                             'password'=>$user->getPassword(),
                             'roles'=>json_encode($user->getRoles()),
                             'equipe'=>$user->getEquipe()?->getId()
                         ])
                         ->executeQuery();
    }

    /**
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function editUser(User $user): void
    {
        $this->connection->createQueryBuilder()
                         ->update('user')
                         ->set('nom', ':nom')
                         ->set('prenom', ':prenom')
                         ->set('email', ':email')
                         ->set('roles', ':roles')
                         ->set('equipe', ':equipe')
                         ->where('id = :id')
                         ->setParameters([
                             'id'=>$user->getId(),
                             'nom'=>$user->getNom(),
                             'prenom'=>$user->getPrenom(),
                             'email'=>$user->getEmail(),
                             'roles'=>json_encode($user->getRoles()),
                             'equipe'=>$user->getEquipe()?->getId()
                         ])
                         ->executeQuery();
    }

    /**
     * @param string $userId
     * @return void
     * @throws Exception
     */
    public function deleteUser(string $userId): void
    {
        $this->connection->createQueryBuilder()
                         ->delete('user')
                         ->where('id = :id')
                         ->setParameter('id', $userId)
                         ->executeQuery();
    }

    /**
     * @param string $equipeId
     * @return void
     * @throws Exception
     */
    public function nullEquipe(string $equipeId): void
    {
        $this->connection->createQueryBuilder()
                         ->update('user')
                         ->set('equipe', 'null')
                         ->where('equipe = :equipeId')
                         ->setParameter('equipeId', $equipeId)
                         ->executeQuery();
    }

    /**
     * @param string $email
     * @return bool
     * @throws Exception
     */
    public function checkUniqueEmail(string $email): bool
    {
        $result = $this->connection->createQueryBuilder()->select('email')
            ->from('user')
            ->where('email = :email')
            ->setParameter('email', $email)
            ->executeQuery();
        if($result->rowCount() === 0){
            return true;
        }
        return false;
    }

    /**
     * @param string $userId
     * @return bool
     * @throws Exception
     */
    public function checkIfExists(string $userId): bool
    {
        $result = $this->connection->createQueryBuilder()->select('id')
            ->from('user')
            ->where('id = :userId')
            ->setParameter('userId', $userId)
            ->executeQuery();
        if($result->rowCount() === 0){
            return false;
        }
        return true;
    }
}
