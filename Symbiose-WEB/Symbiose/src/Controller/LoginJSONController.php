<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class LoginJSONController extends AbstractController
{
    /**
     * @Route("/login/j/s/o/n", name="login_j_s_o_n")
     */
    public function index(): Response
    {
        return $this->render('login_json/index.html.twig', [
            'controller_name' => 'LoginJSONController',
        ]);
    }

    /**
     * @Route ("/LoginJSON/",name="login_json")
     * @param Request $request
     * @param UserRepository $repository
     * @return JsonResponse|Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function login_json(Request $request,UserRepository $repository){
        $email = $request->query->get('email');

        $hash = $request->query->get('hash');

//
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['Email' => $email]);;
        dump($user);
        $test=password_verify($hash,$user->getHash());
        dump($test);
        if($user==null) {

        }
        if ($user) {
            if (password_verify($hash, $user->getHash())) {
                $normalizers = [new ObjectNormalizer()];
                $serializer = new Serializer($normalizers);
                //$formatted = $serializer->normalize($user,'json',['groups'=>'post:read']);
                $formatted = $serializer->normalize($user, 'json', [
                    'circular_reference_handler' => function ($object) {
                        return $object->getId();
                    }
                ]);
//                $formatted=$serializer->normalize(array($user));
                return new JsonResponse(array($formatted));
            } else {

                return new Response("failed1");
            }
        } else {

            return new Response("failed2");
        }
    }
}
