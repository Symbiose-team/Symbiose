<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProductJSONController extends AbstractController
{
    /**
     * @Route("/getAllProducts", name="getAllProducts")
     */
    public function getProduct(NormalizerInterface $Normalizer,SerializerInterface $serializerInterface): Response
    {
        $repo=$this->getDoctrine()->getRepository(Product::class);
        $products=$repo->findAll();
        $json=$serializerInterface->serialize($products ,'json',[ 'groups'=>'prod']);
        dump($json);

        return  JsonResponse::fromJsonString($json);
    }

    /**
     * @Route("/addProductJSON/new", name="AddEventJSON")
     */
    public function AddProductJSON(Request $request, NormalizerInterface $Normalizer): Response
    {
        //$faker = Factory::create('fr_FR');
        $em = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setName($request->get('name'));
        $product->setDescription($request->get('description'));
        $product->setPrice($request->get('price'));
        $product->setType($request->get('type'));
        $product->setState($request->get('state'));
        //$event->setDate($faker->dateTime);
        $em->persist($product);
        $em->flush();
        $json = $Normalizer ->normalize($product, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }

    /**
     * @param $id
     * @Route ("/updateProductJSON/{id}",name="UpdateProductJSON")
     * @return string
     */
    public function UpdateProductJSON(Request $request, NormalizerInterface $Normalizer, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository(Product::class)->find($id);
        $game->setName($request->get('name'));
        $game->setTime(\DateTime::createFromFormat('Y-m-d',($request->get('time'))));
        $em->flush();
        $json = $Normalizer ->normalize($game, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }

    /**
     * @Route("/deleteProductJSON/{id}", name="DeleteProductJSON")
     */
    public function DeleteProductJSON(Request $request, NormalizerInterface $Normalizer, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);
        $em->remove($product);
        $em->flush();
        $json = $Normalizer ->normalize($product, 'json',['groups'=>'post:read']);

        return new Response(json_encode($json));
    }

}
