<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Services\SendEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
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
    public function RegisterJSON(Request $request,UserPasswordEncoderInterface $encoder,SendEmail $sendEmail,TokenGeneratorInterface $tokenGenerator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $role=new Role();
        $registrationToken= $tokenGenerator->generateToken();
        $user->setRegistrationToken($registrationToken);
        $user->setFirstName($request->query->get('first_name'));
        $user->setLastName($request->query->get('last_name'));
        $user->setGenre($request->query->get('genre'));
        $user->setRole($request->query->get('role'));
        $user->setPicture($request->query->get('picture'));

        $user->setDob($request->query->get('birthday'));
        $hash = $encoder->encodePassword($user,$request->query->get("hash"));
        $user->setAdresse($request->query->get('adresse'));
        $user->setHash($hash);
        $user->setCin($request->query->get('cin'));
        $user->setEmail($request->query->get('email'));
        $user->setPhoneNumber($request->query->get('phone_number'));
        $user->setBirthday(new \DateTime($user->getDob()));
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

        $sendEmail->send([
            'recipient_email'=>$user->getEmail(),
            'subject'=>"Vérification de votre adresse email pour activer votre compte utilisateur",
            'html_template'=> "account/conf_email.html.twig",
            'context'=>[
                'userID'=> $user->getId(),
                'userCIN'=>$user->getCin(),
                'registrationToken'=> $registrationToken,
                'tokenLifeTime'=>$user->getAccountMustBeVerifiedBefore()->format('d/m/Y à H:i')
            ]
        ]);

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

    /**
     * @Route("/account/{id<\d+>}/{token}", name="account_verif")
     * @param EntityManagerInterface $em
     * @param User $user

     * @return RedirectResponse
     */
    public function verifyUserAccount(EntityManagerInterface $em,User $user, string $token){
        // * /{id<\d+>} a rajouter en cas d'erreur
//        /{token
        if(($user->getRegistrationToken()=== null) || ($user->getRegistrationToken() !==$token)){
            throw new AccessDeniedException();
        }
        $user->setIsVerified(true);
        $user->setIsEnabled(true);
        $user->setAccountVerifiedAt(new \DateTimeImmutable('now'));

        $em->flush();
        $this->addFlash("success","Compte vérifié !");

        return $this->redirectToRoute('account_login');
    }

    /**
     * @Route("/account/register/done/{id<\d+>}" ,name="register_done")
     * @param Request $request
     * @param $token
     * @return JsonResponse
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function doneAction(Request $request,$token)
    {
        $em = $this->getDoctrine()->getManager();
        $u = $em->getRepository(User::class)->find($token);



        $user = $em->getRepository(User::class)->findOneBy($u->getUsername());
        $serializer = new Serializer([new ObjectNormalizer()]);

        $user->setEnabled(true);
        $user->setIsVerified(true);
        $em->flush();
        if($user->isEnabled() ) {

            $formatted = $serializer->normalize(array("true"));
        }
        else {
            $formatted = $serializer->normalize(array("false"));
        }
        return new JsonResponse($formatted);

    }
}
