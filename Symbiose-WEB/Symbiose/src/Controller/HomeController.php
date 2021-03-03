<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        $prenom=["Skander"=>23,"Ramy"=>10,"Anne"=>24];
        {
            return $this->render('home/index.html.twig', [
                'title'=>'Aurevoir tout le monde',
                'age'=>12,
                'tableau'=>$prenom
            ]);
        }
    }
}
