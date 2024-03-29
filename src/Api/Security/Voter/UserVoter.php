<?php

namespace Api\Security\Voter;

use App\Queries\DTO\UserDTO;
use Domain\Entity\User;
use App\Queries\Query\UserQueries;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;

class UserVoter extends Voter
{
    public const EDIT = 'USER_EDIT';
    public const DELETE = 'USER_DELETE';

    private Security $security;
    private UserQueries $userQueries;

    public function __construct(Security $security, UserQueries $userQueries)
    {
        $this->security = $security;
        $this->userQueries = $userQueries;
    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        if($this->security->isGranted('ROLE_ADMIN')) return true;

        $subject = $this->userQueries->showUser($subject);
        if(!($subject instanceof UserDTO)) return false;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }

        return false;
    }

    private function canEdit(UserDTO $subject, User $user): bool
    {
        if (
            ($this->security->isGranted('ROLE_CHEF')
                && $subject->getEquipeId() === $user->getEquipe()->getId())
            || $subject->getId() === $user->getId()
        )
        {
            return true;
        }
        return false;
    }

    private function canDelete(UserDTO $subject, User $user)
    {
        if (
            (
                $this->security->isGranted('ROLE_CHEF')
                && $subject->getEquipeId() === $user->getEquipe()->getId()
            )
            || $subject->getId() === $user->getId()
        )
        {
            return true;
        }
        return false;
    }
}
