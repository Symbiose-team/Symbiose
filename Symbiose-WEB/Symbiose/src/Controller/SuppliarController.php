<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuppliarController extends AbstractController
{
    /**
     * @Route("/suppliarPage", name="suppliar_Page")
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('suppliar/suppliarPage.html.twig', array('products' => $products));

    }
}
