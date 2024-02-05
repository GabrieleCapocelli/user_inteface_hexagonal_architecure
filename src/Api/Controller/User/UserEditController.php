<?php

namespace Api\Controller\User;

use Api\Security\Voter\UserVoter;
use App\Commands\Command\EditUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/users/{userId}', name:'api_user_edit', methods:['PUT'])]
class UserEditController extends AbstractController
{
    private MessageBusInterface $messageBus;

   public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(#[MapRequestPayload] EditUserCommand $command, string $userId): JsonResponse
    {
        try{
            $this->denyAccessUnlessGranted(UserVoter::EDIT, $userId);
            $envelope = $this->messageBus->dispatch($command);
            $handledStamp = $envelope->last(HandledStamp::class);
            return $this->json($handledStamp->getResult());
        }catch(\Throwable $e){
            return $this->json(["Exception"=>$e->getMessage()], $e->getCode());
        }
    }

}
