<?php

namespace App\Security\Voter;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class ArticleVoter extends Voter
{
    public const EDIT = 'ARTICLE_EDIT';
    public const VIEW = 'ARTICLE_VIEW';
    public const DELETE = 'ARTICLE_DELETE';
    public const LIST_ALL = 'ARTICLE_ALL';

    public function __construct(private readonly Security $security) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::LIST_ALL]) ||
            (in_array($attribute, [self::EDIT, self::VIEW]) && $subject instanceof Article);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) return false;
        if (!$subject instanceof Article) return false;

        switch ($attribute) {
            case self::EDIT:
                return $subject->getAuthor()->getId() === $user->getId();
            case self::DELETE:
                return $subject->getAuthor()->getId() === $user->getId();

            case self::LIST_ALL:
                return $this->security->isGranted('ROLE_ADMIN');

            case self::VIEW:
                return true;
        }

        return false;
    }
}
