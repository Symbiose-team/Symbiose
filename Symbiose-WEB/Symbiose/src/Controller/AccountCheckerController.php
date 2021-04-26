<?php

namespace App\Controller;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountCheckerController implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
    //add this new if error delete\undo below
        if(!$user->getIsEnabled()){
            throw new CustomUserMessageAuthenticationException("acc desactivé");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
        if($user->getIsEnabled() === 0){
            throw new CustomUserMessageAuthenticationException("acc desactivé");
        }
        if(!$user->getIsVerified()){
            throw new CustomUserMessageAuthenticationException("Votre compte n'est pas actif , veuillez l'activer depuis l'email qu'on vous a envoyé ");
        }


    }
}
