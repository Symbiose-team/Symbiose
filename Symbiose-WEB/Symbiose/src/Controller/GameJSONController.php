<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GameJSONController extends AbstractController
{


    /**
     * @Route("/AllGames", name="AllGames")
     */
    public function AllGames(NormalizerInterface $Normalizer,SerializerInterface $serializerInterface): Response
    {

        $repo=$this->getDoctrine()->getRepository(Game::class);
        $fields=$repo->findAll();
        $json=$serializerInterface->serialize($fields ,'json',[ 'groups'=>'post:read']);
        dump($json);
        // die;
        return  JsonResponse::fromJsonString($json);

    }

    /**
     * @Route("/GameJSON/{id}", name="GameJSON")
     */
    public function GameJSONbyID(Request $request, $id, NormalizerInterface $Normalizer): Response
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