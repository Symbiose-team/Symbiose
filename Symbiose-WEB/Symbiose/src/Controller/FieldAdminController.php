<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Field;


class FieldAdminController extends AbstractController
{
    /**
     * @Route("/field/admin", name="field_admin")
     */
    public function index(): Response
    {
        return $this->render('field_admin/index.html.twig', [
            'controller_name' => 'FieldAdminController',
        ]);

    }
    /**
     * @Route("/admin",name="admin")
     */
    public function affiche(){
        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->findAll();
        return $this->render('field_admin/affAdmin.html.twig',['terain'=>$field]);
    }
    /**
     * @Route ("/detail/{id}",name="detail")
     */
    public function detail($id){

        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->find($id);
        return $this->render('field/index.html.twig',['n'=>$field]);
    }

    /**
     * @Route ("supprimer/{id}",name="supp")
     */
    public function supprimer($id){
        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($field);
        $em->flush();
         return $this->redirectToRoute('admin');


    }
}
