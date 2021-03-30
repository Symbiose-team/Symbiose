<?php

namespace App\Controller\Reservation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FieldRepository;
use App\Entity\Field;


class FieldController extends AbstractController
{
    /**
     * @Route("/field")
     */
    public function index()
    {
        return $this->render('Reservation/field/index.html.twig', [
            'controller_name' => 'FieldController',
        ]);
    }

    /**
     * @Route("/afficheterrain",name="afficheterrai")
     */
    public function affiche(){
        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->findAll();
        return $this->render('Reservation/field/afficher.html.twig',['terrain'=>$field]);
    }


    /**
     * @Route ("/detaill/{id}",name="detaill")
     */
    public function details($id){

        $repo=$this->getDoctrine()->getRepository(Field::class);
        $test=$repo->find($id);
        return $this->render('Reservation/field/test.html.twig',['test'=>$test]);
    }

    /**
     * @Route ("/reserve/{id}",name="reserver",methods={"GET","POST"})
     */

    public function reserver($id){
        return $this->render('Reservation/paiement/Paillement.html.twig',['id'=>$id]);

    }
    /**
     * @Route ("/reserver/{id}",name="reserve",methods={"GET","POST"})
     */

    public function reserve($id){
        return $this->render('Reservation/field/reserver.html.twig',['id'=>$id]);

    }

    /**
     * @Route("/routourner",name="return")
     */
public function retourner(){

    return $this->redirectToRoute('afficheterrai',[]);

}
    /**
     * @Route("/rutern",name="ret")
     */
    public function ret(){

        return $this->redirectToRoute('afficheterrai',[]);

    }



}
