<?php

namespace Api\Controller\User;

use Api\Security\Voter\UserVoter;
use App\Commands\Command\DeleteUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/users/{userId}', name:'api_user_delete', methods:['DELETE'])]
class UserDeleteController extends AbstractController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(string $userId): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserVoter::DELETE, $userId);
        $this->messageBus->dispatch(new DeleteUserCommand($userId));
        return new JsonResponse(null, 204);
    }
}
