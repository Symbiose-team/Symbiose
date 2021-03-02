<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    //Add a Special event as an admin
    /**
     * @Route("/specialevent/add", name="new_Sevent")
     * @Method({"GET","POST"})
     */
    public function new(Request $request){
        $Sevent = new SpecialEvent();

        $form= $this->createFormBuilder($Sevent)
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array(//'required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('NumParticipants',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('NumRemaining',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('Type',TextType::class,array('attr' => array('class'=>'form-control')))
            ->add('Date',DateType::class,array('attr' => array('class'=>'form-control')))
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
    public function edit(Request $request, $id){
        $Sevent = new SpecialEvent();
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);

        $form= $this->createFormBuilder($Sevent)
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array(//'required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('NumParticipants',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('NumRemaining',NumberType::class,array('attr' => array('class'=>'form-control')))
            ->add('Type',TextType::class,array('attr' => array('class'=>'form-control')))
            ->add('Date',DateType::class,array('attr' => array('class'=>'form-control')))
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
    public function delete(Request $request, $id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Sevent);
        $entityManager->flush();
        return $this->redirectToRoute('event_admin');

        //$response = new Response();
        //$response->send();
    }

    //Show Special event by id
    /**
     * @Route("/specialevent/{id}",name="Sevent_show")
     */
    public function show($id){
        $Sevent = $this->getDoctrine()->getRepository(SpecialEvent::class)->find($id);
        return $this->render('event_admin/show_special_event.html.twig',array('Sevent' => $Sevent));
    }
}
