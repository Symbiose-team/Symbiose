<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTempController extends AbstractController
{
    /**
     * @Route("/admintemp", name="admin_temp")
     */
    public function index(): Response
    {
        return $this->render('admin_temp/admin_temp.html.twig', [
            'controller_name' => 'AdminTempController',
        ]);
    }
}
