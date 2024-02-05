<?php

namespace Api\Controller\Equipe;

use App\Commands\Command\DeleteEquipeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/equipes/{equipeId}', name:'api_equipe_delete', methods:['DELETE'])]
class EquipeDeleteController extends AbstractController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(string $equipeId): JsonResponse
    {
        //try{
            $this->messageBus->dispatch(new DeleteEquipeCommand($equipeId));
            return new JsonResponse(null, 204);
        //}catch(\Throwable $e){
          //  return $this->json(["Exception"=>$e->getMessage()], $e->getCode());
        //}
    }
}
