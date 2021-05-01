<?php

namespace App\Controller;

use App\Entity\Event;
use Faker\Factory;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EventJSONController extends AbstractController
{
    /**
     * @Route("/event/j/s/o/n", name="event_j_s_o_n")
     */
    public function index(): Response
    {
        return $this->render('event_json/index.html.twig', [
            'controller_name' => 'EventJSONController',
        ]);
    }

    /**
     * @Route("/AllEvents", name="AllEvents")
     */
    public function AllEvents(NormalizerInterface $Normalizer): Response
    {

        $repo = $this->getDoctrine()->getRepository(Event::class);
        $events = $repo->findAll();
        $json = $Normalizer ->normalize($events, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));

    }

    /**
     * @Route("/EventJSON/{id}", name="EventJSON")
     */
    public function EventJSONbyID(Request $request, $id, NormalizerInterface $Normalizer): Response
    {

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
        $json = $Normalizer ->normalize($event, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));

    }

    /**
     * @Route("/addEventJSON/new", name="AddEventJSON")
     */
    public function AddEventJSON(Request $request, NormalizerInterface $Normalizer): Response
    {
        $faker = Factory::create('fr_FR');
        $em = $this->getDoctrine()->getManager();
        $event = new Event();
        $event->setName($request->get('name'));
        $event->setDate($faker->dateTime);
        $event->setNumParticipants($request->get('num_participants'));
        $event->setNumRemaining($request->get('num_remaining'));
        $event->setType($request->get('type'));
        $event->setState($request->get('state'));
        $em->persist($event);
        $em->flush();
        $json = $Normalizer ->normalize($event, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }

    /**
     * @Route("/updateEventJSON/{id}", name="UpdateEventJSON")
     */
    public function UpdateEventJSON(Request $request, NormalizerInterface $Normalizer, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
        $event->setName($request->get('name'));
        $event->setDate($request->get('date'));
        $event->setNumParticipants($request->get('num_participants'));
        $event->setNumRemaining($request->get('num_remaining'));
        $event->setType($request->get('type'));
        $event->setState($request->get('state'));
        $em->flush();
        $json = $Normalizer ->normalize($event, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }

    /**
     * @Route("/deleteEventJSON/{id}", name="DeleteEventJSON")
     */
    public function DeleteEventJSON(Request $request, NormalizerInterface $Normalizer, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
        $em->remove($event);
        $em->flush();
        $json = $Normalizer ->normalize($event, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }
}
