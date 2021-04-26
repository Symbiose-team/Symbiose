<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\Role;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use App\Services\SendEmail;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permet d'afficher et de gerer le formulaire de connexxion
     * @Route("/login", name="account_login")
     *
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error= $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        dump($error);
        return $this->render('account/login.html.twig',[
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     *
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout(){
        //..rien !
    }

    /**
     * Permet d'afficher le formulaire d'inscription
     * @Route("/register", name="account_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param SendEmail $sendEmail
     * @param TokenGeneratorInterface $tokenGenerator
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function register(Request $request,UserPasswordEncoderInterface $encoder,SendEmail $sendEmail,TokenGeneratorInterface $tokenGenerator){


        $user= new User();
        $role=new Role();
        $em=$this->getDoctrine()->getManager();


    $form = $this->createForm(RegistrationType::class,$user);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $registrationToken= $tokenGenerator->generateToken();
        $user->setRegistrationToken($registrationToken);
        $hash = $encoder->encodePassword($user,$user->getHash());
        $user->setHash($hash);
        if($user->getRole()=='Fournisseur'){
            $role->setTitle("ROLE_FOURNISSEUR");
            $user->addUserRole($role);
            $em->persist($role);
            $em->persist($user);
        }
        elseif ($user->getRole()=='Client'){
            $role->setTitle("ROLE_CLIENT");
            $user->addUserRole($role);
            $em->persist($role);
            $em->persist($user);
        }
        $em->flush();

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

        $this->addFlash(
            'success',
            'Votre compte a bien été crée ! Vous pouvez maintenant vous connecter'
        );

        return $this->redirectToRoute('account_login');
    }

    return $this->render('account/registration.html.twig',["form"=>$form->createView()]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     * @Route("/account/profile",name="account_profile")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function profile(Request $request){
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(AccountType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();

            $this->addFlash(
                'success',
                'Les données du profile ont été enregistrées avec succés'
            );
        }
        return $this->render("account/profile.html.twig",['form'=>$form->createView()]);
    }

    /**
     * Permet de modifier le mot de passe
     *
     * @Route("/account/password-update",name="account_password")
     * @param Request $request
     * @IsGranted("ROLE_USER")
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function updatepassword(Request $request,UserPasswordEncoderInterface $encoder){
        $em=$this->getDoctrine()->getManager();
        $passwordUpdate= new PasswordUpdate();
        $user=$this->getUser();
        $form=$this->createForm(PasswordUpdateType::class,$passwordUpdate);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //1.Vérifier que le oldPassword du formulaire soit le même que le password de l'utilisateur
            if(!password_verify($passwordUpdate->getOldPassword(),$user->getHash())){
                //Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas un mot de passe actuel !"));
            }
            else{
               $newPassword= $passwordUpdate->getNewPassword();
               $hash = $encoder->encodePassword($user,$newPassword);

               $user->setHash($hash);
               $em->persist($user);
               $em->flush();

               $this->addFlash(
                   "success",
                   "Votre mot de passe a bien été modifié"
               );
               return $this->redirectToRoute("homepage");
            }

        }
        return $this->render('account/password.html.twig',['form'=>$form->createView()]);

    }

    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     * @Route("/account" , name="account_index")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function myAccount(){
        return $this->render("user/index.html.twig",['user'=>$this->getUser()]);
    }

    /**
     * @Route("/account/{id<\d+>}/{token}", name="account_verif")
     * @param EntityManagerInterface $em
     * @param User $user
     * @param string $token
     * @return RedirectResponse
     */
    public function verifyUserAccount(EntityManagerInterface $em,User $user, string $token){
        // j'ai du l'enlever pour regler le probleme de vérification pour java !!a corriger !! ($this->isNotRequestedInTime($user->getAccountMustBeVerifiedBefore()))
        // * /{id<\d+>} a rajouter en cas d'erreur
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

    private function isNotRequestedInTime(?\DateTimeImmutable $getAccountMustBeVerifiedBefore)
    {
        return (new \DateTimeImmutable('now')> $getAccountMustBeVerifiedBefore);
    }



}

