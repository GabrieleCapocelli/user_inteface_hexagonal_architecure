<?php

namespace Api\Controller\Equipe;

use App\Queries\Query\EquipeQueries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/v1/equipes', name:'api_equipes_index', methods:['GET'])]
class EquipeIndexController extends AbstractController
{
    public function __invoke(EquipeQueries $queries): JsonResponse
    {
        try{
            return $this->json($queries->equipesIndex(), 200);
        }catch(\Throwable $e){
            return $this->json(['Exception'=>$e->getMessage()], $e->getCode());
        }
    }
}
