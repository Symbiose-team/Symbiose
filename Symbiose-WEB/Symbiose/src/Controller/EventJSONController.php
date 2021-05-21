<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use Faker\Factory;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

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
    public function AllEvents(NormalizerInterface $Normalizer,SerializerInterface $serializerInterface): Response
    {

        $repo=$this->getDoctrine()->getRepository(Event::class);
        $fields=$repo->findAll();
        $json=$serializerInterface->serialize($fields ,'json',[ 'groups'=>'post:read']);
        dump($json);
        // die;
        return  JsonResponse::fromJsonString($json);

    }

    /**
     * @Route("/SearchEvents/{name}", name="SearchEvents")
     */
    public function SearchEvents(NormalizerInterface $Normalizer,$name,SerializerInterface $serializerInterface): Response
    {
        $repo=$this->getDoctrine()->getRepository(Event::class)->findBy($name);
        $json=$serializerInterface->serialize($repo ,'json',[ 'groups'=>'post:read']);
        dump($json);
        //die;
        return  JsonResponse::fromJsonString($json);
    }

    /**
     * @Route("/EventJSON/{id}", name="EventJSON")
     */
    public function EventJSONbyID(Request $request, $id, NormalizerInterface $Normalizer,SerializerInterface $serializerInterface): Response
    {
        $event=$this->getDoctrine()->getRepository(Event::class)->find($id);
        $json=$serializerInterface->serialize($event ,'json',[ 'groups'=>'post:read']);
        dump($json);
        // die;
        return  JsonResponse::fromJsonString($json);
    }

    /**
     * @Route("/addEventJSON/new", name="AddEventJSON")
     */
    public function AddEventJSON(Request $request, NormalizerInterface $Normalizer): Response
    {
        //$faker = Factory::create('fr_FR');
        $date = $request->query->get("date");

        $em = $this->getDoctrine()->getManager();
        $event = new Event();
        $event->setName($request->get('name'));
        $event->setDate(new \DateTime($date));
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
        $date = $request->query->get("date");

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
        $event->setName($request->get('name'));
        $event->setDate(new \DateTime($date));
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

    /**
     * @param $id
     * @Route ("/Event/put/{id}/{name}/{date}/{type}",name="put")
     * @return string
     */
    public function put(Request $request,$id,$name,SerializerInterface $serializer)
    {
        $date = $request->query->get("date");

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
        $event->setName($name);
        $event->setDate(new \DateTime($date));
        $event->setType($request->get('type'));

        $json=$serializer->serialize($event,'json',['groups'=>'post:read']);
        $em->flush();
        return new Response("updated ".json_encode($json));

    }
}
