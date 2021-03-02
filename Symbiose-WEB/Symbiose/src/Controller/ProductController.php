<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
     * @Route("/product/new", name="new_product")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $product = new Product();

        $form = $this->createFormBuilder($product)->add('name', TextType::class,
            array('attr' => array('class' => 'form-control')))->add('type', TextType::class,
            array('required' => false, 'attr' => array('class' => 'form_control')))->add('save', SubmitType::class,
            array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))->getForm();

        return $this->render('products/new.html.twig', array('form'=>$form->createView()));
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
