<?php

namespace Api\Controller;

use App\Commands\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/users', name:'api_user_create', methods:['POST'])]
class UserCreateController extends AbstractController
{
    private MessageBusInterface $messageBus;
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }
    public function __invoke(#[MapRequestPayload] CreateUserCommand $command): JsonResponse
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
