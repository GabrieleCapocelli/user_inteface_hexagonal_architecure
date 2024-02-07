<?php

namespace Api\Controller\Equipe;

use Api\Security\Voter\EquipeVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Queries\Query\EquipeQueries;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/v1/equipes/{equipeId}', name:'api_equipe_show', methods:['GET'])]
class EquipeShowController extends AbstractController
{
    public function __invoke(string $equipeId, EquipeQueries $queries): JsonResponse
    {
        $equipe = $queries->showEquipe($equipeId);
        return $this->json($equipe, 200);//, [], ['groups'=>'userIndex']);
    }
}
