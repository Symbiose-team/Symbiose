<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserJSONController extends AbstractController
{
    /**
     * @Route("/user/j/s/o/n", name="user_j_s_o_n")
     */
    public function index(): Response
    {
        return $this->render('user_json/index.html.twig', [
            'controller_name' => 'UserJSONController',
        ]);
    }

    /**
     * @Route("/UserJSON/{id}", name="UserJSON")
     */
    public function UserJSONbyID(Request $request, $id, NormalizerInterface $Normalizer): Response
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $json = $Normalizer ->normalize(array($user));

        return new Response(json_encode($json));

    }

    /**
     * @Route("/AllUser", name="AllUser")
     */
    public function AllUser(NormalizerInterface $Normalizer): Response
    {

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();
        $json = $Normalizer ->normalize($user, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));

    }

    /**
     * @Route("/UpdateUserJSON/{id}", name="UpdateUserJSONJSON")
     */
    public function UpdateUserJSON(Request $request, NormalizerInterface $Normalizer, $id): Response
    {
        $user=  $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $user->setFirstName($request->get('first_name'));
        $user->setLastName($request->get('last_name'));
        $user->setEmail($request->get('email'));
        $user->setGenre($request->get('genre'));
        $user->setRole($request->get('role'));
        $user->setAdresse($request->get('adresse'));


        $this->getDoctrine()->getManager()->flush();

        $json = $Normalizer ->normalize($user, 'json',['groups'=>'post:read']);

        return new Response("mise a jour avec succes".json_encode($json));
    }

    /**
     * @Route("/UpdateUserPicJSON/{id}",name="update_picture_json")
     * @param Request $request
     * @param NormalizerInterface $Normalizer
     * @param $id
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function UpdateUserJSONPicture(Request $request, NormalizerInterface $Normalizer, $id): Response
    {
        $user=  $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $user->setPicture($request->query->get('picture'));


        $this->getDoctrine()->getManager()->flush();

        $json = $Normalizer ->normalize($user, 'json',['groups'=>'post:read']);

        return new Response("mise a jour de l'image avec succes".json_encode($json));
    }

}
