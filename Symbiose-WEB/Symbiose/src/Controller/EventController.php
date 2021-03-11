<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class EventController extends AbstractController
{
    //Get event list
    /**
     * @Route("/events", name="event_list")
     * @Method({"GET"})
     */
    public function index(): Response
    {
        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();
        $Sevents=$this->getDoctrine()->getRepository(SpecialEvent::class)->findAll();
        return $this->render('event/event.html.twig', array(
            'events' => $events, 'SpecialEvents'=> $Sevents));
    }

    /**
     * @Route("/success",name="success")
     */
    public function success(){
        return $this->render('event/success.html.twig');
    }

    /**
     * @Route("/error",name="error")
     */
    public function error(){
        return $this->render('event/error.html.twig');
    }

    //Paiement Stripe
    /**
     * @Route("/create-checkout-session",name="checkout")
     * @Method({"POST"})
     */
    public function checkout(){
        \Stripe\Stripe::setApiKey('sk_test_51ITcGCEiKz1hPVEvnLl5Udb5FOx5XRX24KhliPUatANALVfZWlzNdoqzZlGogAHWTqdGZJerWnlBtLdC14cNmMb300eL0c6XaH');

        header('Content-Type: application/json');

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => 2000,
                    'product_data' => [
                        'name' => 'Events',
                        'images' => ["https://i.imgur.com/EHyR2nP.png"],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('error', [], UrlGeneratorInterface::ABSOLUTE_URL),

        ]);
        
        return new JsonResponse(['id'=>$checkout_session->id]);

    }

    /**
     * @Route("/event/join/{id}", name="join_event")
     */
    public function join_event($id): Response
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        //TODO Work on the logic (as a client i want to join an event)
        /*
        $remaining = $event.NumRemaining
            if($remaining = 0) {
                print("cant join event");
                $event.state = "closed";
            }
            else
                $event.NumRemaining = $event.NumRemaining - 1
        */
        return $this->render('/event/join_event.html.twig',array('event' => $event));
    }

    //TODO Work on the logic (as a client i want to join an event)
    /**
     * @Route("/specialevent/join/{id}", name="join_special_event")
     */
    public function join_specialevent($id): Response
    {

        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);

        return $this->render('/event/join_special_event.html.twig',array('Sevent' => $Sevent));
    }

    //Order matters!
    //Show event by id
    /**
     * @Route("/event/{id}",name="event_show")
     */
    public function show($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('event/show_event.html.twig',array('event' => $event));
    }


}
