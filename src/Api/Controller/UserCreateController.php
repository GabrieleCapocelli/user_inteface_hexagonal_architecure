<?php

namespace Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Command\CreateUserCommand;
use Symfony\Component\Messenger\Stamp\HandledStamp;

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
            return $this->json(['Exception'=>$e->getMessage()]);
        }
    }
}