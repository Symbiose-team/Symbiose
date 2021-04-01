<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTempController extends AbstractController
{
    /**
     * @Route("/adminTempPage", name="admin_temp")
     * @Method ({"GET"})
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('admin_temp/adminTemp.html.twig', array('products' => $products));

    }


}
