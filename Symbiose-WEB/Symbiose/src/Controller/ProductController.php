<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     * @Method ({"GET"})
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('products/index.html.twig', array('products' => $products));

    }

    /**
     * @Route ("/product/{id}", name="product_show")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render('products/show.html.twig', array('product' => $product));
    }

//    /**
//     * @Route("/products/save")
//     */
//    public function save()
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $products = new Product();
//        $products->setType('Clothing');
//        $products->setName('These are the articles proposed');
//
//        $entityManager->persist($products);
//        $entityManager->flush();
//
//        return new Response('Saved a products with the id of ' . $products->getId());
//    }
}
