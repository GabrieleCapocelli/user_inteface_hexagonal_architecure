<?php

namespace Api\Controller\Equipe;

use Api\Security\Voter\EquipeVoter;
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
        $this->denyAccessUnlessGranted(EquipeVoter::DELETE, $equipeId);
        $this->messageBus->dispatch(new DeleteEquipeCommand($equipeId));
        return new JsonResponse(null, 204);
    }
}
