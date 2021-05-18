<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GameJSONController extends AbstractController
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
     * @Route("/AllGames", name="AllGames")
     */
    public function AllGames(NormalizerInterface $Normalizer): Response
    {

        $repo = $this->getDoctrine()->getRepository(Game::class);
        $events = $repo->findAll();
        $json = $Normalizer ->normalize($events, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));

    }

    /**
     * @Route("/GameJSON/{id}", name="GameJSON")
     */
    public function EventJSONbyID(Request $request, $id, NormalizerInterface $Normalizer): Response
    {

        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository(Game::class)->find($id);
        $json = $Normalizer ->normalize($game, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));

    }

    /**
     * @Route("/addGameJSON/new", name="AddGameJSON")
     */
    public function addGameJSON(Request $request, NormalizerInterface $Normalizer): Response
    {

        $em = $this->getDoctrine()->getManager();
        $game = new Game();
        $game->setName($request->get('name'));
        $game->setTime(\DateTime::createFromFormat('Y-m-d',($request->get('time'))));

        $em->persist($game);
        $em->flush();
        $json = $Normalizer ->normalize($game, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }

    /**
     * @Route("/updateGameJSON/{id}", name="UpdateGameJSON")
     */
    public function UpdateGameJSON(Request $request, NormalizerInterface $Normalizer, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository(Game::class)->find($id);
        $game->setName($request->get('name'));
        $game->setTime(\DateTime::createFromFormat('Y-m-d',($request->get('time'))));
        $em->flush();
        $json = $Normalizer ->normalize($game, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }

    /**
     * @Route("/deleteGameJSON/{id}", name="DeleteGameJSON")
     */
    public function DeleteGameJSON(Request $request, NormalizerInterface $Normalizer, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository(Game::class)->find($id);
        $em->remove($game);
        $em->flush();
        $json = $Normalizer ->normalize($game, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }
}