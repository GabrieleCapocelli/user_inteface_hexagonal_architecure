<?php

namespace Api\Controller\User;

use App\Queries\Query\UserQueries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/usersExport', name:'api_users_export', methods:['GET'])]
class UsersExportController extends AbstractController
{
    public function __invoke(UserQueries $queries): Response
    {
        try {
            $users = $queries->usersIndex($this->getUser()->getEquipe()->getId());
            $rows = [];
            foreach ($users as $user) {
                $data = [$user->getId(), $user->getNom(), $user->getPrenom(), $user->getEmail()];
                $rows[] = implode(',', $data);
            }
            $content = implode("\n", $rows);
            return new Response($content, 200, ['Content-Type'=>'text/csv']);//, [], ['groups'=>'userIndex']);
        }catch(\Throwable $e){
            return $this->json(['Exception'=>$e->getMessage()], $e->getCode());
        }
    }
}
