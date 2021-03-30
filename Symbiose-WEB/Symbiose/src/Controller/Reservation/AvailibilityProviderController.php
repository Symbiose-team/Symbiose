<?php

namespace App\Controller\Reservation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Availability;
use App\Form\AvailabilityType;

class AvailibilityProviderController extends AbstractController
{
    /**
     * @Route("/availibility/provider", name="availibility_provider")
     */
    public function index(): Response
    {
        return $this->render('Reservation/availibility_provider/index.html.twig', [
            'controller_name' => 'AvailibilityProviderController',
        ]);
    }

    /**
     * @Route("/dispo",name="dispo")
     */
    public function affiche(){
        $repo=$this->getDoctrine()->getRepository(Availability::class);
        $dispo=$repo->findAll();
        return $this->render('Reservation/availibility_provider/AdminAvailability.html.twig',['dispo'=>$dispo]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Route ("/addAvailability",name="AddV")
     */
 public function add(\Symfony\Component\HttpFoundation\Request $request){
        $availaibilty=new Availability();
        $form=$this->createForm(AvailabilityType::class,$availaibilty);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($availaibilty);
            $em->flush();
            return $this->redirectToRoute('dispo');

        }
     return $this->render('Reservation/availibility_provider/AddAvailability.html.twig',['form'=>$form->createView()]);

    }
}
