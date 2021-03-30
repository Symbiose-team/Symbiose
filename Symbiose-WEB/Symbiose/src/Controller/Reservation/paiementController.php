<?php

namespace App\Controller\Reservation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class paiementController extends AbstractController
{
    /**
     * @Route("/paillement", name="paillement")
     */
    public function index(): Response
    {
        return $this->render('Reservation/paiement/Paillement.html.twig', []);
    }
    /**
     * @Route("/success", name="success")
     */
    public function success(): Response
    {
        return $this->render('Reservation/paiement/success.html.twig', []);
    }
    /**
     * @Route("/error", name="error")
     */
    public function error(): Response
    {
        return $this->render('Reservation/paiement/error.html.twig', []);
    }



    /**
     * @Route("/create-checkout-session",name="checkout")
     */
    public function checkout(): Response
    {
        \Stripe\Stripe::setApiKey('sk_test_51ITS8FLNTPBfKfeUzGNbDz0DPDyrmYXvB5JI2fXilniC1RpcdW8pM2ggmukff3MpFTIMtMJIpCilRwdZsbO9tP4X00si2vPzsH');
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Terrain_Football',
                    ],
                    'unit_amount' => 9870,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success',[],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('error',[],UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return new JsonResponse(['id' => $session->id]);
    }

}
