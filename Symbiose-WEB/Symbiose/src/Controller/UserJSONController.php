<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new JsonResponse(array($formatted));

    }

    /**
     * @Route("/AllUser", name="AllUser")
     */
    public function AllUser(NormalizerInterface $Normalizer): Response
    {

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new JsonResponse(array($formatted));

    }

    /**
     * @Route("/UpdateUserJSON/{id}", name="UpdateUserJSONJSON")
     */
    public function UpdateUserJSON(Request $request, NormalizerInterface $Normalizer, $id): Response
    {
        $user=  $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $user->setFirstName($request->query->get('first_name'));
        $user->setLastName($request->query->get('last_name'));
        $user->setGenre($request->query->get('genre'));
        $user->setRole($request->query->get('role'));
//        $user->setPicture($request->query->get('picture'));
        $user->setDob($request->query->get('birthday'));
        $user->setAdresse($request->query->get('adresse'));
        $user->setCin($request->query->get('cin'));
        $user->setEmail($request->query->get('email'));
        $user->setPhoneNumber($request->query->get('phone_number'));
        $user->setBirthday(new \DateTime($user->getDob()));


        $this->getDoctrine()->getManager()->flush();

        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new JsonResponse(array($formatted));
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

        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new JsonResponse(array($formatted));
    }

}
