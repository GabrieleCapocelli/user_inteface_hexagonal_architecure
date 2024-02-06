<?php

namespace Api\Security\Voter;

use App\Queries\DTO\EquipeDTO;
use Domain\Entity\User;
use App\Queries\Query\EquipeQueries;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;

class EquipeVoter extends Voter
{
    public const EDIT = 'EQUIPE_EDIT';
    public const SHOW = 'EQUIPE_SHOW';
    public const DELETE = 'EQUIPE_DELETE';

    private Security $security;
    private EquipeQueries $equipeQueries;

    public function __construct(Security $security, EquipeQueries $equipeQueries)
    {
        $this->security = $security;
        $this->equipeQueries = $equipeQueries;
    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::SHOW, self::DELETE]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        if($this->security->isGranted('ROLE_ADMIN')) return true;

        $subject = $this->equipeQueries->showEquipe($subject);
        if(!($subject instanceof EquipeDTO)) return false;

        switch ($attribute) {
            case self::SHOW:
                return $this->canShow($subject, $user);
            case self::EDIT:
            case self::DELETE:
                return $this->canEditOrDelete($subject, $user);
        }

        return false;
    }

    private function canShow(EquipeDTO $subject, User $user)
    {
        if($user->getEquipe()->getId() === $subject->getId()) return true;
        return false;
    }

    private function canEditOrDelete(EquipeDTO $subject, User $user): bool
    {
        if (
            (
                $this->security->isGranted('ROLE_CHEF')
                &&
                $subject->getId() === $user->getEquipe()->getId()
            )
        )
        {
            return true;
        }
        return false;
    }

}
