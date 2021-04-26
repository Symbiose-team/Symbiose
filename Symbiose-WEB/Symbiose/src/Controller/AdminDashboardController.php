<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\EventType;
use App\Form\SpecialEventType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Services\Pagination;
use Knp\Component\Pager\PaginatorInterface;
use Cassandra\Type\UserType;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
        $events=$em->createQuery('SELECT COUNT(e) from APP\Entity\Event e')->getSingleScalarResult();

        $male_p= $em->createQuery("SELECT COUNT(CASE WHEN u.genre='Homme' then 1 ELSE 0 END) as male , count(CASE WHEN u.genre='Femme' then 1 else 0 end) as female_cnt, count('*') as total_cnt from App\Entity\User u ")->getResult();

        return $this->render('admin_dashboard/index.html.twig', [
            'stats' => compact('users'),
            's_ev'=>compact('events'),
            'genre'=>compact('male_p')
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/{page<\d+>?1}", name="admin_utilisateurs")
     * @param UserRepository $repo
     * @param int $page
     * @param Pagination $pagination
     * @return Response
     */
    public function Gestion(UserRepository $repo, $page,Pagination $pagination): Response
    {
        $pagination->setEntityClass(User::class)
                   ->setPage($page);
        return $this->render('admin_dashboard/utilisateurs/admin_utilisateurs.html.twig',[
            'users'=>$pagination->getData(),
            'pages'=>$pagination->getPages(),
            'page'=>$page
        ]);
    }
        //    public function Gestion(UserRepository $repo,$page =1): Response
        //    {
        //        $limit=5;
        //        $start = $page * $limit - $limit;
        //        $total=count($repo->findAll());
        //        $pages = ceil($total / $limit); //3.5 =4
        //        return $this->render('admin_dashboard/utilisateurs/admin_utilisateurs.html.twig',[
        //            'users'=>$repo->findBy([], [], $limit, $start),
        //            'pages'=>$pages,
        //            'page'=>$page
        //        ]);
        //    }

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

//    /**
//     * Ceci est un test
//     * @Route("/admin/utilisateurs/recherche",name="admin_user_recherche")
//     * @param Request $request
//     * @param NormalizerInterface $Normalizer
//
//     * @return Response
//     * @throws ExceptionInterface
//     */
//        public function recherche(Request $request,NormalizerInterface $Normalizer){
//            $repository = $this->getDoctrine()->getRepository(User::class);
//            $requestString=$request->get('searchValue');
//            $user = $repository->findByAjax($requestString);
//            $jsonContent = $Normalizer->normalize($user, 'json',['groups'=>'post:read']);
//            $retour=json_encode($jsonContent);
//            return new JsonResponse($retour);
//        }



        //*********Gestion Evenement****************

    private $repository;
    /**
     * $var ObjectManager
     */
    private $em;
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/events", name="event_admin")
     */
    public function admin(PaginatorInterface $paginator, Request $request): Response
    {
        $events = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        $Sevents = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        $S_events=$this->getDoctrine()->getRepository(SpecialEvent::class)->findAll();
        return $this->render('Event/event_admin/eventadmin.html.twig', ['current_menu' => 'events', 'events' => $events , 'SpecialEvents'=>$Sevents]);

    }

    //Add an event
    /**
     * @Route("/admin/event/add", name="admin_new_event")
     * @Method({"GET","POST"})
     */


    public function new(Request $request){
        $event = new Event();

        $form= $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $event = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('Event/event_admin/new_event.html.twig', array('form'=>$form->createView()));
    }

    //Edit an event
    /**
     * @Route("/admin/event/edit/{id}", name="admin_edit_event")
     * @Method({"GET","POST"})
     */
    public function Eventedit(Request $request, $id){
        $event = new Event();
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        $form= $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('Event/event_admin/edit_event.html.twig', array('form'=>$form->createView()));
    }

    //DELETE event
    /**
     * @Route ("/admin/event/delete/{id}", name="admin_event_delete")
     * @Method ({"DELETE"})
     */
    public function Eventdelete(Request $request, $id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('event_admin');

    }

    //Add a Special event as an admin
    /**
     * @Route("/admin/specialevent/add", name="admin_new_Sevent")
     * @Method({"GET","POST"})
     */
    public function newSevent(Request $request){
        $Sevent = new SpecialEvent();

        $form= $this->createForm(SpecialEventType::class, $Sevent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $Sevent = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Sevent);
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('Event/event_admin/new_special_event.html.twig', array('form'=>$form->createView()));
    }

    //Edit a Special event
    /**
     * @Route("/admin/specialevent/edit/{id}", name="admin_edit_Sevent")
     * @Method({"GET","POST"})
     */
    public function editSevent(Request $request, $id){
        $Sevent = new SpecialEvent();
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);

        $form= $this->createForm(SpecialEventType::class, $Sevent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('event_admin');
        }

        return $this->render('Event/event_admin/edit_special_event.html.twig', array('form'=>$form->createView()));
    }

    //DELETE Special event
    /**
     * @Route ("/admin/specialevent/delete/{id}" , name="admin_delete_Sevent")
     * @Method ({"DELETE"})
     */
    public function deleteSevent(Request $request, $id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Sevent);
        $entityManager->flush();
        return $this->redirectToRoute('event_admin');

    }

    //Order matters!
    //Show admin event by id
    /**
     * @Route("/admin/eventadmin/{id}",name="admin_event_show")
     */
    public function show($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('Event/event_admin/show_admin_event.html.twig',array('event' => $event));
    }

    //Show Special event by id
    /**
     * @Route("/admin/specialevent/{id}",name="admin_Sevent_show")
     */
    public function showSevent($id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        return $this->render('Event/event_admin/show_special_event.html.twig',array('Sevent' => $Sevent));
    }
}

