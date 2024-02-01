<?php

namespace Api\Controller;

use App\Commands\Command\EditUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Stamp\HandledStamp;
#[Route('/api/v1/users/{userId}', name:'api_user_edit', methods:['PUT'])]
class UserEditController extends AbstractController
{
    private MessageBusInterface $messageBus;

   public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(#[MapRequestPayload] EditUserCommand $command): JsonResponse
    {
        try{
            $envelope = $this->messageBus->dispatch($command);
            $handledStamp = $envelope->last(HandledStamp::class);
            return $this->json($handledStamp->getResult());
        }catch(\Throwable $e){
            return $this->json(["Exception"=>$e->getMessage()]);
        }
    }

}