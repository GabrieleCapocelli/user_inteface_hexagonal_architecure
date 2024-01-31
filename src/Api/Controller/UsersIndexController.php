<?php

namespace Api\Controller;

use App\Query\UserQueries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/users', name:'api_users_index', methods:['GET'])]
class UsersIndexController extends AbstractController
{
    public function __invoke(UserQueries $queries): JsonResponse
    {
        try {
            $users = $queries->usersIndex();
            return $this->json($users, 200, [], ['groups'=>'userIndex']);
        }catch(\Throwable $e){
            return $this->json(['Exception'=>$e->getMessage()], 400);
        }
    }
}