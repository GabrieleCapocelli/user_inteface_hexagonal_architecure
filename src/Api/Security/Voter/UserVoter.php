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
    public const SHOW = 'USER_SHOW';
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
        return in_array($attribute, [self::EDIT, self::SHOW, self::DELETE]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        $subject = $this->userQueries->showUser($subject);

        switch ($attribute) {
            case self::SHOW:
            case self::EDIT:
                return $this->canShowOrEdit($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }

        return false;
    }

    private function canShowOrEdit(UserDTO $subject, User $user): bool
    {
        if (
            (
                $this->security->isGranted('ROLE_CHEF')
                && (
                    $subject->getEquipeId() === $user->getEquipe()->getId()
                    || $subject->getEquipeId() === null
                    )
            )
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
