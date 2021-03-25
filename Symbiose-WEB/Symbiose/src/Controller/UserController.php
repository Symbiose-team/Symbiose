<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="user-show")
     * @param User $user
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user'=>$user
        ]);
    }
}
