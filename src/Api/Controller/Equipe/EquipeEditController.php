<?php

namespace Api\Controller\Equipe;

use App\Commands\Command\EditEquipeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/equipes/{equipeId}', name:'api_equipe_edit', methods:['PUT'])]
class EquipeEditController extends AbstractController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(#[MapRequestPayload] EditEquipeCommand $command): JsonResponse
    {
        try{
            $envelope = $this->messageBus->dispatch($command);
            $handledStamp = $envelope->last(HandledStamp::class);
            return $this->json($handledStamp->getResult());
        }catch(\Throwable $e){
            return $this->json(["Exception"=>$e->getMessage()], $e->getCode());
        }
    }

}
