<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminContollerController extends AbstractController
{
    /**
     * @Route("/admin/contoller", name="admin_contoller")
     */
    public function index(): Response
    {
        return $this->render('admin_contoller/index.html.twig', [
            'controller_name' => 'AdminContollerController',
        ]);
    }
}
