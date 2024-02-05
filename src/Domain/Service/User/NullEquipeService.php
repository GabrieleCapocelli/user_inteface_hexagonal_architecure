<?php

namespace Domain\Service\User;

use Domain\Repository\UserDomainRepository;

class NullEquipeService implements \SplObserver
{
    private UserDomainRepository $repository;

    public function __construct(UserDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function setNullEQuipe(string $equipeId)
    {
        $this->repository->nullEquipe($equipeId);
    }

    public function update(\SplSubject $subject): void
    {
        $this->setNullEQuipe($subject->getId());
    }
}
