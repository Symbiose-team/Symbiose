<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RegistrationJSONController extends AbstractController
{
    /**
     * @Route("/registration/j/s/o/n", name="registration_j_s_o_n")
     */
    public function index(): Response
    {
        return $this->render('registration_json/index.html.twig', [
            'controller_name' => 'RegistrationJSONController',
        ]);
    }

    /**
     * @Route("/RegistrationJSON/", name="registration_json")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function RegisterJSON(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $role=new Role();
        $user->setFirstName($request->query->get('first_name'));
        $user->setLastName($request->query->get('last_name'));
        $user->setGenre($request->query->get('genre'));
        $user->setRole($request->query->get('role'));
        $user->setPicture($request->query->get('picture'));
        $user->setBirthday(new \DateTime($request->query->get('birthday')));
        $hash = $encoder->encodePassword($user,$request->query->get("hash"));
        $user->setAdresse($request->query->get('adresse'));
        $user->setHash($hash);
        $user->setCin($request->query->get('cin'));
        $user->setEmail($request->query->get('email'));
        $user->setPhoneNumber($request->query->get('phone_number'));
        if($user->getRole()=='Fournisseur'){
            $role->setTitle("ROLE_FOURNISSEUR");
            $user->addUserRole($role);
            $entityManager->persist($role);
            $entityManager->persist($user);
        }
        elseif ($user->getRole()=='Client'){
            $role->setTitle("ROLE_CLIENT");
            $user->addUserRole($role);
            $entityManager->persist($role);
            $entityManager->persist($user);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers);
//        $json = $Normalizer ->normalize(array($user));
        $formatted = $serializer->normalize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse(array($formatted));
    }
}
