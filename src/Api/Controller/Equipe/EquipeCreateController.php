<?php

namespace Api\Controller\Equipe;

use App\Commands\Command\CreateEquipeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/v1/equipes', name:'api_equipe_create', methods:['POST'])]
#[IsGranted('ROLE_CHEF')]
class EquipeCreateController extends AbstractController
{
    private MessageBusInterface $messageBus;
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }
    public function __invoke(#[MapRequestPayload] CreateEquipeCommand $command): JsonResponse
    {
        try{
            $envelope = $this->messageBus->dispatch($command);
            $handledStamp = $envelope->last(HandledStamp::class);
            return $this->json($handledStamp->getResult(), 201);
        }catch(\Throwable $e){
            return $this->json(['Exception'=>$e->getMessage()], $e->getCode());
        }
    }
}
