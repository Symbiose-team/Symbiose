<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Services\SendEmail;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ForgotPasswordController extends AbstractController
{
    private EntityManagerInterface $em;
    private SessionInterface $session;
    private UserRepository $repo;

    /**
     * ForgotPasswordController constructor.
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     * @param UserRepository $repo
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session, UserRepository $repo)
    {
        $this->em = $em;
        $this->session = $session;
        $this->repo = $repo;
    }


    /**
     * @Route("account/forgot/password", name="app_forgot_password")
     * @param Request $request
     * @param SendEmail $sendEmail
     * @param TokenGeneratorInterface $tokenGenerator
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function sendRecoveryLink(
        Request $request,
        SendEmail $sendEmail,
        TokenGeneratorInterface $tokenGenerator
    ): Response
    {
        $form=$this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user=$this->repo->findOneBy([
                'Email'=>$form['Email']->getData()
            ]);
            if(!$user){
                $this->addFlash('success','Un email vous a été envoyé pour redéfinir votre mot de passe');
                return $this->redirectToRoute('account_login');
            }
            $user->setForgotPasswordToken($tokenGenerator->generateToken())
                ->setForgotPasswordTokenRequestedAt(new DateTimeImmutable('now'))
                ->setForgotPasswordTokenMustBeVerifiedBefore(new DateTimeImmutable('+15 minutes'));

            $this->em->flush();
            $sendEmail->send([
                'recipient_email'=>$user->getEmail(),
                'subject'=>'Modification de votre mot de passe',
                    'html_template'=>'forgot_password/forgot_password_email.html.twig',
                    'context'=>['user'=>$user]
                    ]
            );
            $this->addFlash('success','un email vous a été envoyé pour redéfinir votre mot de passe');

            return $this->redirectToRoute('account_login');
        }

        return $this->render('forgot_password/forgot_password_step1.html.twig', [
            'forgotPasswordFormStep1' => $form->createView(),

        ]);

    }

    /**
     * @param string $token
     * @param User $user
     * @Route("/account/forgot-password/{id<\d+>}/{token}",name="app_retrieve_credentials")
     * @return RedirectResponse
     */
    public function retrieveCredentialFromTheUrl(
        string $token,
        User $user
    ): RedirectResponse
    {

        $this->session->set('Reset-Password-Token-URL',$token);
        $this->session->set('Reset-Password-User-Email',$user->getEmail());

        return $this->redirectToRoute('app_reset_password');
    }

    /**
     * @Route("/account/reset_password",name="app_reset_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $encoder){
        [
            'token'=>$token,
            'userEmail'=>$userEmail
        ]=$this->getCredentialsFromSession();

        $user=$this->repo->findOneBy(['Email' => $userEmail]);

        if(!$user){
            dump($userEmail);
            throw new CustomUserMessageAuthenticationException('Email could not be found.');

        }

    /** @var  DateTimeImmutable $forgotPasswordTokenMustBeVerifiedBefore */
        $forgotPasswordTokenMustBeVerifiedBefore= $user->getForgotPasswordTokenMustBeVerifiedBefore();

        if(($user->getForgotPasswordToken()===null) || ($user->getForgotPasswordToken()!==$token) || ($this->isNotRequestedInTime($forgotPasswordTokenMustBeVerifiedBefore))){
        return $this->redirectToRoute('app_forgot_password');
        }
        $form=$this->createForm(ResetPasswordType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setHash($encoder->encodePassword($user,$form['hash']->getDate()));
            $user->setForgotPasswordToken(null);
            $user->setForgotPasswordTokenVerifiedAt(new DateTimeImmutable('now'));
            $this->em->flush();
            $this->removeCredentialsFromSession();

            $this->addFlash('success','Votre mot de passe a été modifié');

            return $this->redirectToRoute('account_login');
        }
        return $this->render('forgot_password/forgot_password_step2.html.twig',[
            'forgotPasswordFormStep2'=>$form->createView(),
            'passwordMustBeModifiedBefore'=>$this->passwordMustBeModifiedBefore($user),

        ]);

    }

    /**
     * Gets the user ID and token from the session.
     * @return array
     */
    private function getCredentialsFromSession(): array{
        return [
            'token'=>$this->session->get('Reset-Password-Token-URL'),
            'userEmail'=>$this->session->get('Reset-Password-Token-Email'),

        ];
    }

    /**
     * Validates or not the fact that the link was clicked in the alloted time
     * @param DateTimeImmutable $forgotPasswordTokenMustBeVerifiedBefore
     * @return bool
     */
    public function isNotRequestedInTime(DateTimeImmutable $forgotPasswordTokenMustBeVerifiedBefore): bool
    {
        return (new DateTimeImmutable('now') > $forgotPasswordTokenMustBeVerifiedBefore);
    }

    /**
     * Removes the user ID and token from the session.
     */
    private function removeCredentialsFromSession():void{
        $this->session->remove('Reset-Password-Token-URL');
        $this->session->remove('Reset-Password-Token-Email');
    }

    /**
     * Returns the time before which the password must be changed
     * @param User $user
     * @return string
     */
    private function passwordMustBeModifiedBefore(User $user):string{
        /** @var DateTimeImmutable $passwordMustBeVerifiedBefore */
        $passwordMustBeVerifiedBefore= $user->getForgotPasswordTokenMustBeVerifiedBefore();
        return $passwordMustBeVerifiedBefore->format('H\hi');
    }



}
