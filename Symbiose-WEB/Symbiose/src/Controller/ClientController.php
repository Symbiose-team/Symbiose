<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    private $repository;

    public function __construct(ProductRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * @Route("/clientPage", name="clientPage")
     * @Method ({"GET"})
     */
    public function clientPage(): Response
    {
        return $this->render('client/clientPage.html.twig');
    }

    /**
     * @Route ("/equipment", name="equipment")
     */
    public function equipment(PaginatorInterface $paginator, Request $request): Response
    {
        $products = $paginator->paginate(
            $this->repository->findVisibleEquipmentQuery(),
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('client/equipment.html.twig', array('products' => $products));
    }

    /**
     * @Route ("/clothing", name="clothing")
     */
    public function clothing(PaginatorInterface $paginator, Request $request): Response
    {
        $products = $paginator->paginate(
            $this->repository->findVisibleClothingQuery(),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('client/clothing.html.twig', array('products' => $products));

    }



//    /**
//     * @Route ("/buy", name="buy_equipment")
//     */
//    public function buy(): Response
//    {
//        return $this->render('client/buy.html.twig');
//    }
//    /**
//     * @Route ("/rent", name="rent_equipment")
//     */
//    public function rent(): Response
//    {
//        return $this->render('client/rent.html.twig');
//    }
}
