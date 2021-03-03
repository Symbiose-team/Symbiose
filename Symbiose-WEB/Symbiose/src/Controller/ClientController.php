<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/clientPage", name="clientPage")
     * @Method ({"GET"})
     */
    public function clientPage(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('client/clientPage.html.twig', array('products' => $products));
    }

    /**
     * @Route ("/equipment", name="equipment")
     */
    public function equipment(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('client/equipment.html.twig', array('products' => $products));
    }

    /**
     * @Route ("/clothing", name="clothing")
     */
    public function clothing(): Response
    {
        return $this->render('client/clothing.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route ("/buy", name="buy_equipment")
     */
    public function buy(): Response
    {
        return $this->render('client/buy.html.twig');
    }
    /**
     * @Route ("/rent", name="rent_equipment")
     */
    public function rent(): Response
    {
        return $this->render('client/rent.html.twig');
    }
}
