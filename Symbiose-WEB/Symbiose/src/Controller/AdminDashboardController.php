<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Repository\UserRepository;
use Cassandra\Type\UserType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AdminDashboardController extends AbstractController
{
    /**
     * Permet d'affichier le nombre d'utilisateurs
     * @Route("/admin", name="admin_dashboard")
     * @return Response
     */
    public function index(): Response
    {
        $em=$this->getDoctrine()->getManager();

        $users= $em->createQuery('SELECT COUNT(u) from APP\Entity\User u')->getSingleScalarResult();

        return $this->render('admin_dashboard/index.html.twig', [
            'stats' => compact('users')
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/{page<\d+>?1}", name="admin_utilisateurs")
     * @param UserRepository $repo
     * @param int $page
     * @return Response
     */
    public function Gestion(UserRepository $repo,$page =1): Response
    {
        $limit=5;
        $start = $page * $limit - $limit;
        $total=count($repo->findAll());
        $pages = ceil($total / $limit); //3.5 =4
        return $this->render('admin_dashboard/utilisateurs/admin_utilisateurs.html.twig',[
            'users'=>$repo->findBy([], [], $limit, $start),
            'pages'=>$pages,
            'page'=>$page
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'edition
     * @Route("/admin/utilisateur/{id}/edit",name="admin_utilisateurs_edit")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function edit(User $user,Request $request): Response
    {
        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(AccountType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success',
            'Modifications effectuées avec succès ');
        }

        return $this->render('admin_dashboard/utilisateurs/edit.html.twig',[
            'user'=>$user,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param User $user
     * @Route("/admin/utilisateurs/{id}/delete",name="admin_user_delete")
     */
    public function delete(User $user){
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('success',
        "l'utilisateur a été bien supprimé");
        return $this->redirectToRoute("admin_utilisateurs");
    }

    /**
     * Test is enabled / diabled

     * @param User $user
     * @return RedirectResponse
     * @Route("/admin/utilisateurs/{id}/permute", name="admin_user_permute")
     */
    public function permuter(User $user){
        $em=$this->getDoctrine()->getManager();
        $permute = $user->getIsEnabled()? false : true;
        $user->setIsEnabled($permute);
        $em->flush();
        $this->addFlash('success',
            "l'utilisateur bloqué");
        return $this->redirectToRoute("admin_utilisateurs");
    }

    /**
     * Ceci est un test
     * @Route("/admin/utilisateurs/recherche",name="admin_user_recherche")
     * @param Request $request
     * @param NormalizerInterface $Normalizer

     * @return Response
     * @throws ExceptionInterface
     */
        public function recherche(Request $request,NormalizerInterface $Normalizer){
            $repository = $this->getDoctrine()->getRepository(User::class);
            $requestString=$request->get('searchValue');
            $user = $repository->findByAjax($requestString);
            $jsonContent = $Normalizer->normalize($user, 'json',['groups'=>'post:read']);
            $retour=json_encode($jsonContent);
            return new JsonResponse($retour);
        }




}
