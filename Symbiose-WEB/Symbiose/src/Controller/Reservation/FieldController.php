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
        return $this->render('reservation/field/index.html.twig', [
            'controller_name' => 'FieldController',
        ]);
    }

    /**
     * @Route("/afficheterrain",name="afficheterrai")
     */
    public function affiche(){
        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->findAll();
        return $this->render('reservation/field/afficher.html.twig',['terrain'=>$field]);
    }


   /**
     * @Route ("/detail/{id}",name="detail")
     */
    public function detail($id){

        $repo=$this->getDoctrine()->getRepository(Field::class);
        $test=$repo->find($id);
        return $this->render('reservation/field/test.html.twig',['test'=>$test]);
    }

    /**
     * @Route ("/reserve/{id}",name="reserver",methods={"GET","POST"})
     */

    public function reserver($id){
        return $this->render('reservation/paiement/Paillement.html.twig',['id'=>$id]);

    }
    /**
     * @Route ("/reserver/{id}",name="reserve",methods={"GET","POST"})
     */

    public function reserve($id){
        return $this->render('reservation/field/reserver.html.twig',['id'=>$id]);

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
