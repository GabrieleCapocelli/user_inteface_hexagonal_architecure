<?php

namespace Api\Controller\User;

use App\Queries\Query\UserQueries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/users/{userId}', name:'api_user_show', methods:['GET'])]
class UserShowController extends AbstractController
{
    public function __invoke(string $userId, UserQueries $queries): JsonResponse
    {
        try {
            $user = $queries->showUser($userId);
            return $this->json($user, 200);//, [], ['groups'=>'userIndex']);
        }catch(\Throwable $e){
            return $this->json(['Exception'=>$e->getMessage()], $e->getCode());
        }
    }
}