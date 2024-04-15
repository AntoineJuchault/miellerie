<?php

namespace App\Security\Voter;

use App\Entity\Products;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

use function PHPUnit\Framework\returnSelf;

class ProductsVoter extends Voter
{
    const EDIT = 'PRODUCT_EDIT';
    const DELETE = 'PRODUCT_DELETE';

    private $security;

    public function __construct($security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $product): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE]) &&
            $product instanceof Products;
    }

    protected function voteOnAttribute($attribute, $product, TokenInterface $token): bool
    {
        // On recupere l'utilisateur a partir du token 
        $user = $token->getUser();

        if (!$user instanceof UserInterface) return false;

        // On verifie si l'utilisateur est admin
        if ($this->security->isGranted("ROLE_ADMIN")) return true;

        // on verifie les permissions

        switch ($attribute) {
            case self::EDIT:
                // On verifie si l'utilisateur peu editer;
                return $this->canEdit();
                break;
                // on verifie si l'utilisateur peut supprimer
            case self::DELETE:
                return $this->canDelete();
                break;
        }
    }

    private function canEdit()
    {
        if ($this->security->isGranted("ROLE_ADMIN"));
    }
    private function canDelete()
    {
        if ($this->security->isGranted("ROLE_ADMIN"));
    }
}
