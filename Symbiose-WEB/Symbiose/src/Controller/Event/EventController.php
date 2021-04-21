<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\EventSearch;
use App\Entity\SpecialEvent;
use App\Form\EventSearchType;
use App\Repository\EventRepository;
use App\Repository\SpecialEventRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
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
use Twilio\Rest\Client;


class EventController extends AbstractController
{


    private $event_repository;
    private $sevent_repository;

    /**
     * $var ObjectManager
     */
    private $em;

    public function __construct(EventRepository $event_repository,
                                SpecialEventRepository $sevent_repository,
                                EntityManagerInterface $em)
    {
        $this->event_repository = $event_repository;
        $this->sevent_repository = $sevent_repository;
        $this->em = $em;
    }

    //Get event list
    /**
     * @Route("/events", name="event_list")
     * @Method({"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        $search = new EventSearch();
        $form = $this->createForm(EventSearchType::class, $search);
        $form->handleRequest($request);

        $events = $paginator->paginate(
            $this->event_repository->search($search),
            $request->query->getInt('page', 1),
            12
        );


        return $this->render('Event/event/event.html.twig', [
            'current_menu' => 'events',
            'events' => $events,
            'form' => $form->createView()
        ]);
    }

    //Get Special event list
    /**
     * @Route("/sevents", name="sevent_list")
     * @Method({"GET"})
     */
    public function indexx(PaginatorInterface $paginator, Request $request): Response
    {

        $Sevents = $paginator->paginate(
            $this->sevent_repository->findAll(),
            $request->query->getInt('page', 1),
            12
        );


        return $this->render('Event/event/Sevent.html.twig', [
            'current_menu' => 'Sevents',
            'Sevents' => $Sevents ,]);
    }

    /**
     * @Route("/success",name="success")
     */
    public function success(){
        return $this->render('Event/event/success.html.twig');
    }

    /**
     * @Route("/error",name="error")
     */
    public function error(){
        return $this->render('Event/event/error.html.twig');
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
                        'name' => 'Event',
                        'images' => ["http://localhost/pidev/logo-mrigel-sghir.jpg"],
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

        $sid = "AC38bb5bb69de3b58061c6ee92458101b0"; // Your Account SID from www.twilio.com/console
        $token = "7d695374171c0eba1950eebe694d3df5"; // Your Auth Token from www.twilio.com/console

        $twilio_number = "+12245019002";

        $client = new Client($sid, $token);
        $message = $client->messages->create(
            '+21694325950', // Text this number
            [
                'from' => $twilio_number, // From a valid Twilio number
                'body' => 'Hello from Symbiose, Thank you for joining this event'
            ]
        );

        $event = $this->event_repository->find($id);
        $num = $event->getNumRemaining() - 1;
        $event->setNumRemaining($num);

        $x =$event->getNumRemaining();
        dump($x);

        if ($x <= 90){
            $event->setState(0);
        }
        $this->em->flush();
        dump($event);


        return $this->render('Event/event/join_event.html.twig',array('event' => $event));
    }

    /**
     * @Route("/sevent/join/{id}", name="join_sevent")
     */
    public function join_specialevent($id): Response
    {

        $sid = "AC38bb5bb69de3b58061c6ee92458101b0"; // Your Account SID from www.twilio.com/console
        $token = "7d695374171c0eba1950eebe694d3df5"; // Your Auth Token from www.twilio.com/console

        $twilio_number = "+12245019002";

        $client = new Client($sid, $token);
        $message = $client->messages->create(
            '+21694325950', // Text this number
            [
                'from' => $twilio_number, // From a valid Twilio number
                'body' => 'Hello from Symbiose, Thank you for joining this event'
            ]
        );

        $Sevent = $this->sevent_repository->find($id);
        $num = $Sevent->getNumRemaining() - 1;
        $Sevent->setNumRemaining($num);

        $y =$Sevent->getNumRemaining();
        dump($y);

        if ($y <= 0){
            $Sevent->setState(0);
        }
        $this->em->flush();
        dump($Sevent);

        return $this->render('Event/event/join_special_event.html.twig',array('Sevent' => $Sevent));
    }

    //Order matters!
    //Show event by id
    /**
     * @Route("/event/{id}",name="event_show")
     */
    public function show($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('Event/event/show_event.html.twig',array('event' => $event));
    }

    //Show special event by id
    /**
     * @Route("/sevent/{id}",name="sevent_show")
     */
    public function sshow($id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        return $this->render('Event/event/show_sevent.html.twig',array('Sevent' => $Sevent));
    }


}
