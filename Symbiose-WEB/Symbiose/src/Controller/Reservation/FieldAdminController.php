<?php

namespace App\Controller\Reservation;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Field;
use App\Form\FieldType;


class FieldAdminController extends AbstractController
{
    /**
     * @Route("/field/admin", name="field_admin")
     */
    public function index(): Response
    {
        return $this->render('Reservation/field_admin/index.html.twig', [
            'controller_name' => 'FieldAdminController',
        ]);

    }

    /**
     * @Route ("/AFF",name="aff")
     */
public function aff(){
        return $this->render('Reservation/main/index.html.twig', [
            'controller_name' => 'FieldAdminController',
        ]);
}
    /**
     * @Route("/fieldadmin",name="admin")
     */
    public function affiche(){
        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->findAll();
        return $this->render('Reservation/field_admin/affAdmin.html.twig',['terain'=>$field]);
    }

    /**
     * @Route("/admindett",name="admindett",methods={"GET","POST"})
     */
    public function affi(){
        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->findAll();
        return $this->render('Reservation/field_admin/detail.html.twig',['terain'=>$field]);
    }
    /**
     * @Route ("/detail/{id}",name="detailss")
     */
    public function detail($id){

        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->find($id);
        return $this->render('Reservation/field_admin/index.html.twig',['n'=>$field]);
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

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Symfony\Component\HttpFoundation\Response
     * @Route ("/addfield",name="addfield")
     */
    public function add(\Symfony\Component\HttpFoundation\Request $request){
        $field=new Field();
        $form=$this->createForm(FieldType::class,$field);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($field);
            $em->flush();
            return $this->redirectToRoute('admin');

        }
        return $this->render('Reservation/field_admin/add.html.twig',['form'=>$form->createView()]);
}

    /**
     * @param $id
     * @Route ("/update/{id}",name="update")
     */
public function update(\Symfony\Component\HttpFoundation\Request $request,$id)
{
    $repository=$this->getDoctrine()->getRepository(Field::class);
    $field=$repository->find($id);
    $form=$this->createForm(FieldType::class,$field);
    $form->add('Update',SubmitType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid() ){
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('admin');

    }
return $this->render('Reservation/field_admin/update.html.twig',['form'=>$form->createView()]);
    }



}
