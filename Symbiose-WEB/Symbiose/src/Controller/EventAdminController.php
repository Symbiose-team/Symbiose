<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventAdminController extends AbstractController
{
    //Admin page
    /**
     * @Route("/eventadmin", name="event_admin")
     */
    public function admin(): Response
    {
        $S_events=$this->getDoctrine()->getRepository(SpecialEvent::class)->findAll();
        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('event_admin/eventadmin.html.twig',array('SpecialEvents' => $S_events,'events' => $events));
    }

    //Add an event
    /**
     * @Route("/event/add", name="new_event")
     * @Method({"GET","POST"})
     */
    public function new(Request $request){
        $event = new Event();

        $form= $this->createFormBuilder($event)
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array(//'required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('NumParticipants',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('NumRemaining',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Football' => 'Football',
                    'Basketball' =>'Basketball',
                    'Tennis' => 'Tennis',
                    'Paintball' => 'Paintball',
                    'LazerTag' => 'LazerTag',
                ],
            ])
            ->add('Date',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('save',SubmitType::class, array('label'=>'Create',
                'attr'=>array('class'=>'btn btn-primary mt-3')))

            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $event = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('event_admin/new_event.html.twig', array('form'=>$form->createView()));
    }

    //Edit an event
    /**
     * @Route("/event/edit/{id}", name="edit_event")
     * @Method({"GET","POST"})
     */
    public function edit(Request $request, $id){
        $event = new Event();
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        $form= $this->createFormBuilder($event)
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array(//'required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('NumParticipants',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('NumRemaining',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Football' => 'Football',
                    'Basketball' =>'Basketball',
                    'Tennis' => 'Tennis',
                    'Paintball' => 'Paintball',
                    'LazerTag' => 'LazerTag',
                ],
            ])
            ->add('Date',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('save',SubmitType::class, array('label'=>'Update',
                'attr'=>array('class'=>'btn btn-primary mt-3')))

            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('event_admin/edit_event.html.twig', array('form'=>$form->createView()));
    }

    //DELETE event
    /**
     * @Route ("/event/delete/{id}")
     * @Method ({"DELETE"})
     */
    public function delete(Request $request, $id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('event_admin');

        //$response = new Response();
        //$response->send();
    }

    //Add a Special event as an admin
    /**
     * @Route("/specialevent/add", name="new_Sevent")
     * @Method({"GET","POST"})
     */
    public function newSevent(Request $request){
        $Sevent = new SpecialEvent();

        $form= $this->createFormBuilder($Sevent)
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array(//'required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('NumParticipants',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('NumRemaining',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Football' => 'Football',
                    'Basketball' =>'Basketball',
                    'Tennis' => 'Tennis',
                    'Paintball' => 'Paintball',
                    'LazerTag' => 'LazerTag',
                ],
            ])
            ->add('Date',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('save',SubmitType::class, array('label'=>'Create',
                'attr'=>array('class'=>'btn btn-primary mt-3')))

            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $Sevent = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Sevent);
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('event_admin/new_special_event.html.twig', array('form'=>$form->createView()));
    }

    //Edit a Special event
    /**
     * @Route("/specialevent/edit/{id}", name="edit_Sevent")
     * @Method({"GET","POST"})
     */
    public function editSevent(Request $request, $id){
        $Sevent = new SpecialEvent();
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);

        $form= $this->createFormBuilder($Sevent)
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array(//'required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('NumParticipants',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('NumRemaining',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Football' => 'Football',
                    'Basketball' =>'Basketball',
                    'Tennis' => 'Tennis',
                    'Paintball' => 'Paintball',
                    'LazerTag' => 'LazerTag',
                ],
            ])
            ->add('Date',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('save',SubmitType::class, array('label'=>'Update',
                'attr'=>array('class'=>'btn btn-primary mt-3')))

            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('event_admin');
        }

        return $this->render('event_admin/edit_special_event.html.twig', array('form'=>$form->createView()));
    }

    //DELETE Special event
    /**
     * @Route ("/specialevent/delete/{id}")
     * @Method ({"DELETE"})
     */
    public function deleteSevent(Request $request, $id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Sevent);
        $entityManager->flush();
        return $this->redirectToRoute('event_admin');

        //$response = new Response();
        //$response->send();
    }

    //Order matters!
    //Show admin event by id
    /**
     * @Route("/eventadmin/{id}",name="admin_event_show")
     */
    public function show($id){
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);
        return $this->render('event_admin/show_admin_event.html.twig',array('event' => $event));
    }

    //Show Special event by id
    /**
     * @Route("/specialevent/{id}",name="Sevent_show")
     */
    public function showSevent($id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        return $this->render('event_admin/show_special_event.html.twig',array('Sevent' => $Sevent));
    }
}
