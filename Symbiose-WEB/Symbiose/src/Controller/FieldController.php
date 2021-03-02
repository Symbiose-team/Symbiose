<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FieldRepository;
use App\Entity\Field;


class FieldController extends AbstractController
{
    /**
     * @Route("/field", name="field")
     */
    public function index(): Response
    {
        return $this->render('field/index.html.twig', [
            'controller_name' => 'FieldController',
        ]);
    }

  #/**
   #  * @Route("/afficheterrain",name="afficheterrai")
 #    */
#public function add(FieldRepository $repository){
     #   $repo=$repository->fiendAll();
       # return $this->render('afficher.html.twig',['terrain'=>$repo]);}

    /**
     * @Route ("/")
     */
public function home(){
         $field=['terrain1','terrain2','terrain3'];
             return $this->render('field/afficher.html.twig',['fields'=>$field]);
}

    /**
     * @Route ("/detail",name="detail")
     */
    public function detail(){

        return $this->render('field/index.html.twig');
    }

    /**
     * @param $terrain
     * @return mixed
     * @Route ("/jareb/{terrain}",name="jareb")
     */
    public function aff($terrain)
    {
        return $this->render('field/index.html.twig', ['n' => $terrain]);
    }

    /**
     * @Route ("/add",name="add")
     */
public function affichee(FieldRepository $repository){
        $repository=$this->getDoctrine();
        $repo=$repository->findAll();
}



}
