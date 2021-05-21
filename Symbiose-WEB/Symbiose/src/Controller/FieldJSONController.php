<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Field;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class FieldJSONController extends AbstractController
{
    /**
     * @Route("/field/j/s/o/n", name="field_j_s_o_n")
     */
    public function index(): Response
    {
        return $this->render('field_json/index.html.twig', [
            'controller_name' => 'FieldJSONController',
        ]);
    }

    /**
     * @Route("/androidaff",name="androidaff")
     */
    public function getField(SerializerInterface $serializerInterface)
    {
          $repo=$this->getDoctrine()->getRepository(Field::class);
          $fields=$repo->findAll();
          $json=$serializerInterface->serialize($fields ,'json',[ 'groups'=>'field']);
       // dump($json);
      // die;
       return  JsonResponse::fromJsonString($json);

    }


    /**
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     * @Route ("/android",name="android")
     */
    public function addandroid(SerializerInterface $serializer, \Symfony\Component\HttpFoundation\Request $request,EntityManagerInterface $em)
    {
        $content = $request->getContent();
        $data = $serializer->deserialize($content, Field::class, 'json');
        $field=new Field();
        $field->setName($request->get('name'));
        $em->persist($field);
        $em->flush();
        return new Response("ajouter".json_encode($data));
    }
    /**
     * @Route("/addFieldJSON/new", name="AddFieldJSON")
     */
    public function AddFieldJSON(Request $request, NormalizerInterface $Normalizer): Response
    {

        $em = $this->getDoctrine()->getManager();
        $field = new Field();
        $field->setSerialNumber($request->get('serial_number'));
        $field->setName($request->get('name'));
        $field->setAddress($request->get('address'));
        $field->setProvider($request->get('provider'));
        $field->setDateEnd(new \DateTime($request->get('end')));
        $field->setDateStart(new \DateTime($request->get('start')));
        $em->persist($field);
        $em->flush();
      //  $json = $Normalizer ->normalize($event, 'json',['groups'=>'post:read']);
        return new Response($field->getId());
    }

    /**
     * @param $id
     * @Route ("/put/{id}/{name}",name="put")
     * @return string
     */
    public function put(\Symfony\Component\HttpFoundation\Request $request, $id,$name,SerializerInterface $serializer)
    {

        $em = $this->getDoctrine()->getManager();
         $field = $em->getRepository(Field::class)->find($id);
         $field->setName($name);
         $json=$serializer->serialize($field,'json',['groups'=>'field']);
         $em->flush();
        return new Response("deja fait ".json_encode($json));

    }
    /**
     * @Route("/updateFieldJSON/{id}", name="UpdateFieldJSON")
     */
    public function UpdateFieldJSON(Request $request, SerializerInterface $serializer, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $field = $em->getRepository(Field::class)->find($id);
        $field->setName($request->get('name'));
        $em->flush();
        $json = $serializer ->serialize($field, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }

    /**
     * @Route("/deleteandroid/{id}", name="DeleteFieldJSON")
     */
    public function DeleteFieldJSON(\Symfony\Component\HttpFoundation\Request $request, NormalizerInterface $Normalizer, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $field = $em->getRepository(Field::class)->find($id);

        $em->remove($field);
        $em->flush();
      //  $json = $Normalizer ->normalize($field, 'json',['groups'=>'field']);

        return new Response($field->getId());
    }
}
