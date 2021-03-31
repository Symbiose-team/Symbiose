<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\ProductSearchType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductController extends AbstractController
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * @Route("/products", name="products")
     * @Method ({"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new ProductSearch();
        $form = $this->createForm(ProductSearchType::class, $search);
        $form->handleRequest($request);

        $products = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('products/index.html.twig',
            array(
            'products' => $products,
            'form' => $form->createView()
            )
        );

    }

    /**
     * @Route("/product/new", name="new_product")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->add('Create', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-block btn-primary mt-3')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager -> persist($product);
            $entityManager -> flush();

            return $this->redirectToRoute('products');

        }

        return $this->render('products/new.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/product/edit/{id}", name="edit_product")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {

        $product = new Product();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $form->add('Update', SubmitType::class, array('label' => 'Update', 'attr' => array('class' => 'btn btn-block btn-success mt-3')));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('products/edit.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route ("/product/{id}", name="product_show")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render('products/show.html.twig', array('product' => $product));
    }

    /**
     * @Route("/product/delete/{id}", name="delete_product")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('products');
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
