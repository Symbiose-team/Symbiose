<?php

namespace App\Controller;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Field;
use App\Form\FieldType;
use Symfony\Component\Validator\Constraints\DateTime;


class FieldProviderController extends AbstractController
{
    /**
     * @Route("/field/provider", name="field_provider")
     */
    public function index(): Response
    {
        return $this->render('field_provider/index.html.twig', [
            'controller_name' => 'FieldProviderController',
        ]);
    }
    /**
     * @Route("/provider",name="provider")
     */
    public function affiche(){
        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->findAll();
        return $this->render('field_provider/affprovider.html.twig',['terain'=>$field]);
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Symfony\Component\HttpFoundation\Response
     * @Route ("/addprovider",name="addterain")
     */
    public function add(\Symfony\Component\HttpFoundation\Request $request){
        $field=new Field();
        $form=$this->createForm(FieldType::class,$field);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($field);
            $em->flush();
            return $this->redirectToRoute('provider');

        }
        return $this->render('field_provider/addfield.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route ("delete/{id}",name="supprime")
     */
    public function supprimer($id){
        $now =DateTime::DEFAULT_GROUP;
        $this->$now = new \DateTime('now');
        $repo=$this->getDoctrine()->getRepository(Field::class);
        $field=$repo->find($id);
        if ($field->getDateEnd()< $now ) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($field);
            $em->flush();
            return $this->redirectToRoute('provider');
        }
        else
            return $this->redirectToRoute('admin');

    }
}
