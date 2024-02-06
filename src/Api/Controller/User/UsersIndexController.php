<?php

namespace Api\Controller\User;

use App\Queries\Query\UserQueries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/users', name:'api_users_index', methods:['GET'])]
class UsersIndexController extends AbstractController
{
    public function __invoke(UserQueries $queries): JsonResponse
    {
        if($this->isGranted('ROLE_ADMIN')){
            $users = $queries->usersIndex(null);
        }else{
            $users = $queries->usersIndex($this->getUser()->getEquipe()->getId());
        }
        return $this->json($users, 200);//, [], ['groups'=>'userIndex']);
    }
}
